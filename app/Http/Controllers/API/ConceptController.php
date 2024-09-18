<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Concept\StoreRequest as ConceptStoreRequest;
use App\Http\Resources\ConceptResource;
use App\Models\Concept;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Fetch the perPage parameter and set a maximum limit of 100
        $perPage = $request->query('per_page', 15);
        $perPage = min($perPage, 100);

        // Validate that perPage is a positive integer
        if (!is_numeric($perPage) || $perPage <= 0) {
            $perPage = 15; // Fallback to default if invalid
        }

        // Fetch the sort_by and sort_order parameters with defaults
        $sortBy = $request->query('sort_by', 'preferredTerm'); // Default to sorting by 'preferredTerm'
        $sortOrder = $request->query('sort_order', 'asc'); // Default to ascending order

        // Validate the sort_order to be either 'asc' or 'desc'
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        $items = Concept::with('terms', 'preferredTerm', 'conceptCategories')
            ->select('concepts.*')
            ->leftJoin('concept_categories', function ($join) {
                $join->on('concepts.id', '=', 'concept_categories.concept_id');
            })
            ->leftJoin('vocabulary as category_vocabularies', function ($join) {
                $join->on('concept_categories.category_id', '=', 'category_vocabularies.id');
            })
            ->leftJoin('terms as preferred_terms', function ($join) {
                $join->on('concepts.id', '=', 'preferred_terms.concept_id')
                    ->where('preferred_terms.preferred', true);
            })
            ->where(
                'deprecated', '=', false
            );

        if ($sortBy === 'preferredTerm') {
            $items->orderBy('preferred_terms.text', $sortOrder); // Order by the preferred term
        } elseif ($sortBy === 'category') {
            $items->orderBy('category_vocabularies.value', $sortOrder); // Order by the category name
        } else {
            $items->orderBy($sortBy, $sortOrder);
        }

        return ConceptResource::collection($items->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\Concept\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConceptStoreRequest $request)
    {
        $category_id = $request['category_id'];
        $terms = $request['terms'];

        DB::beginTransaction();

        try {
            // Create concept
            $concept = new Concept;
            $concept->deprecated = false;
            if (!$concept->save()) {
                throw new \Exception('Unable to save concept');
            }

            // Attach concept to the category
            $concept->conceptCategories()->attach($category_id);

            // Create terms
            foreach ($terms as $term) {
                $term = new Term($term);
                if (!$concept->terms()->save($term)) {
                    throw new \Exception('Term not created for concept');
                }
            }

            // Commit changes to database
            DB::commit();
            return response()->json([
                "id" => $concept->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                "error" => "Error creating new Concept",
                "exception" => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Concept::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $concept = Concept::findOrFail($id);
        $result = $concept->update($request->all());
        return new Response($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deprecate(Request $request, $id)
    {
        $concept = Concept::findOrFail($id);
        $to = $request->input('to');
        if ($to) {
            $replaceConcept = Concept::findOrFail($to);
            $concept->setDeprecatedTo($replaceConcept);
        } else {
            $concept->deprecated = !$concept->deprecated;
            $concept->save();
        }
        return $concept->deprecated ? 'true' : 'false';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Reconcile Concept for OpenRefine
     *
     * Return an json reconciliation result for OpenRefine concept reconciliation
     * e.g. api/concepts/reconcile?term=teacher&category=occupation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JSONResponse
     */
    public function reconcile(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'category' => 'required',
        ]);

        if (isset($request['category'])) {
            $category_id = config('cache.category_ids')[$request['category']] ?? null;
            $category = isset($category_id) ? $request['category'] : null;
        }
        $term = $_GET["term"];

        $terms = DB::table('concepts')->select('concepts.id as id', 'text as name')
            ->addSelect(DB::raw("true as match, 100 as score, '$category' as type"))
            ->leftJoin('terms', 'concepts.id', '=', 'terms.concept_id')
            ->leftJoin('concept_categories', 'concepts.id', '=', 'concept_categories.concept_id')
            ->where([['text', 'ILIKE', $term]])
            ->where('concept_categories.category_id', $category_id)
            ->where('deprecated', false)
            ->orderBy('preferred', 'desc');

        return response()->json($terms->get());
    }
}

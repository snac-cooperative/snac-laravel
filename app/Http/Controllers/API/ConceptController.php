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
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'reconcile']);
        $this->authorizeResource(Concept::class);
    }

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
            ], 201);
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
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function show(Concept $concept)
    {
        return $concept;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Concept $concept)
    {
        $attributes = $request->all();

        // Sync concept categories
        if (array_key_exists('conceptCategories', $attributes)) {
            $category_ids = array_map(function ($category) {
                return $category['id'];
            }, $attributes['conceptCategories']);

            $concept->conceptCategories()->sync($category_ids);

            unset($attributes['conceptCategories']);
        }

        $concept->update($attributes);

        return new Response($concept);
    }

    /**
     * Relate Concepts
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function relateConcepts(Request $request, Concept $concept)
    {
        if ($request->user()->cannot('update', $concept)) {
            abort(403);
        }
    
        $relation_type = $request->input('relation_type');
        $related_id = $request->input('related_id');

        switch ($relation_type) {
            case "broader":
                $concept->addBroader($related_id);
                break;
            case "narrower":
                $concept->addNarrower($related_id);
                break;
            case "related":
                $concept->addRelated($related_id);
                break;
        }

        return $concept;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function deprecate(Request $request, Concept $concept)
    {
        if ($request->user()->cannot('update', $concept)) {
            abort(403);
        }
    
        $to = $request->input('to');
        if ($to) {
            $replaceConcept = Concept::findOrFail($to);
            $concept->setDeprecatedTo($replaceConcept);
        } else {
            $concept->deprecated = !$concept->deprecated;
            $concept->save();
        }

        return response()->json($concept, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concept $concept)
    {
        $concept->conceptCategories()->detach();
        $concept->terms()->delete();
        $concept->delete();

        return response('Deleted ' . $concept->id, 204);
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

        $category_id = config('cache.category_ids')[$request->input('category')] ?? null;
        $category = $category_id ? $request->input('category') : null;
        $term = $request->input('term');

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

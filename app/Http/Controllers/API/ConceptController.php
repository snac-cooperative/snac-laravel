<?php

namespace App\Http\Controllers\API;

use App\Models\Concept;
use App\Models\Term;
use App\Models\ConceptCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Concept::with('conceptCategories')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'preferred_term' => 'required',
            'category_id' => 'required_without:category'
        ]);

        if (!isset($request['category_id'])) {
            $request['category_id'] = config('cache.category_ids')[$request['category']];
        }

        DB::beginTransaction();
        try {
            $concept = new Concept;
            $concept->deprecated = false;
            $concept->save();
            $term = new Term;
            $term->text = $request['preferred_term'];
            $term->preferred = true;
            if(!$concept->terms()->save($term)) {
                throw new \Exception('Concept not created for term');
            }
            $conceptCategory = new ConceptCategory;
            $conceptCategory->concept_id = $concept->id;
            $conceptCategory->category_id = $request['category_id'];
            if(!$conceptCategory->save()) {
                throw new \Exception('Concept Category not created for Concept');
            }
            DB::commit();
            return response()->json([
                "id" => $concept->id,
                "termId" => $term->id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "id" => false,
                "error" => "Error creating new Concept",
                "exception" => $e->getMessage()
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
        //
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
        return $concept->deprecated ? 'true' : 'false' ;
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
            'category' => 'required'
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

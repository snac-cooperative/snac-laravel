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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['preferred_term'] && $request['category_id']) {
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
                return [
                    "id" => $concept->id,
                    "termId" => $term->id
                ];
            } catch (\Exception $e) {
                DB::rollback();
                return [
                    "id" => false,
                    "error" => "Error creating new Concept",
                    "exception" => $e->getMessage()
                ];
            }
        }
        return [
            "id" => false,
            "error" => "preffered_term and category_id are required fields"
        ];
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

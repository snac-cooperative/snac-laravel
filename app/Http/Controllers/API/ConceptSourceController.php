<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ConceptSource;
use Illuminate\Http\Request;

class ConceptSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ConceptSource::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conceptId = $request['concept_id'];
        if (method_exists($request, 'route') && $request->route('concept')) {
            $conceptId = $request->route('concept');
        }
        $concept = Concept::findOrFail($conceptId);
        $conceptSource = ConceptSource::create($request->all());
        $concept->sources()->save($conceptSource);
        return $conceptSource;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ConceptSource::findOrFail($id);
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
        $source = ConceptSource::findOrFail($id);
        $source->update($request->all());
        return $source;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $source = ConceptSource::findOrFail($id)->delete();
        return response('Deleted' . $id, 204);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Concept;
use App\Models\ConceptNote;

class ConceptNoteController extends Controller
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
        $conceptId = $request['concept_id'];
        if (method_exists($request, 'route') && $request->route('concept')) {
            $conceptId = $request->route('concept');
        }
        $concept = Concept::findOrFail($conceptId);
        $conceptNote = ConceptNote::create($request->all());
        $concept->sources()->save($conceptNote);
        return $conceptNote;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ConceptNote::findOrFail($id);
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
        $note = ConceptNote::findOrFail($id);
        $note->update($request->all());
        return $note;
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
        return response('Deleted'.$id, 204);
    }
}

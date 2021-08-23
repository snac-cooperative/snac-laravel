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
        $concept = Concept::findOrFail($conceptId);
        $language_id = 130;
        $conceptNote = ConceptNote::create([
            'concept_id' => $concept['id'],
            'note' => $request['note'],
            'type_id' => $request['type_id'],
            'language_id' => $language_id,
        ]);
        $concept->notes()->save($conceptNote);
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
        $note->update([
            'note' => $request['note'],
        ]);
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
       $note  = ConceptNote::findOrFail($id)->delete();
        return response('Deleted'.$id, 204);
    }
}

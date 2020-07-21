<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\Term;
use Illuminate\Http\Request;

class ConceptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concepts = Concept::with(['terms' => function($query) {
            $query->orderBy('preferred', 'desc');
        }])->where(
            'deprecated', false
        )->get();
        $control = [
            'snacURL' => 'http://localhost/~josephglass/snac/www/'
        ];
        return view('concepts.index', ['concepts' => $concepts, 'control' => $control]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $control = [
            'snacURL' => 'http://localhost/~josephglass/snac/www/'
        ];
        return view('concepts.create', ['control' => $control]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestParams = $request->only('term-value');
        $concept = new Concept;
        $concept->deprecated = false;
        $concept->save();
        $term = new Term;
        $term->text = $requestParams['term-value'];
        $term->preferred = true;
        //$term->concept_id = $concept->id;
        //$term->save();
        $concept->terms()->save($term);
        //Savemany... Ref.
        return redirect('concepts')->with('status', 'Concept Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function show($concept_id)
    {
        $concept = Concept::with('terms')->findOrFail($concept_id);
        $control = [
            'snacURL' => 'http://localhost/~josephglass/snac/www/'
        ];
        return view('concepts.show', ['concept' => $concept, 'control' => $control]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function edit(Concept $concept)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concept $concept)
    {
        //
    }
}

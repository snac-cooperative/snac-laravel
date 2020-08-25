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
            //$query->where('preferred', true);
        }])->where(
            'deprecated', false
        )->get();
        return view('concepts.index', ['concepts' => $concepts]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indextable()
    {
        // $concepts = Concept::with(['terms' => function($query) {
        //     $query->orderBy('preferred', 'desc');
        //     //$query->where('preferred', true);
        // }])->where(
        //     'deprecated', false
        // )->get();

        // // Concepts with category and preferred term
        $concepts = Concept::with('conceptCategories')->with(['terms' => function ($query) {
            $query->where('preferred', true);
        }])->get();

        // To get only preferred terms
        // $terms = Term::with('conceptCategories')->where('preferred', true);

        return view('concepts.indextable', ['concepts' => $concepts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('concepts.create');
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
        //$request->validate Check
        //Ref: https://laravel.com/docs/7.x/validation
        //$requestParams = $request->only(Concept::fillable);
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
        if($request->ajax()) {
            return [
                "id" => $concept->id,
                "termId" => $term->id
            ];
        }
        return redirect('concepts')->with('status', 'Concept Created');
    }

    public function addTerm(Request $request)
    {
        $requestParams = $request->only('term-value');
        //$request->validate Check
        //Ref: https://laravel.com/docs/7.x/validation
        //$requestParams = $request->only(Concept::fillable);
        $concept = Concept::find($request->route('concept'));
        $term = new Term;
        $term->text = $requestParams['term-value'];
        $term->preferred = true;
        $concept->terms()->save($term);
        //Savemany... Ref.
        if($request->ajax()) {
            return [
                "termId" => $term->id
            ];
        }
        return redirect('concepts', $concept->id)->with('status', 'Concept Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function show($concept_id)
    {
        $concept = Concept::with('terms')
                        ->with('broader')
                        ->with('narrower')
                        ->with('related')
                        ->findOrFail($concept_id);
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

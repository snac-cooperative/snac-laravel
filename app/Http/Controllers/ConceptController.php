<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isVocabularyEditor = false;
        if (!Auth::guest()) {
            $isVocabularyEditor = $user->isVocabularyEditor();
        }
        $terms = [];
        return view('concepts.index', ['isVocabularyEditor' => $isVocabularyEditor, 'terms' => $terms]);
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
        // $requestParams = $request->only('term-value');
        //$request->validate Check
        //Ref: https://laravel.com/docs/7.x/validation
        //$requestParams = $request->only(Concept::fillable);
        $concept = new Concept;
        $concept->deprecated = false;
        $concept->save();
        $term = new Term;
        // $term->text = $requestParams['term-value'];
        $term->preferred = true;
        //$term->concept_id = $concept->id;
        //$term->save();
        $concept->terms()->save($term);
        //Savemany... Ref.
        if ($request->ajax()) {
            return [
                "id" => $concept->id,
                "termId" => $term->id,
            ];
        }
        return redirect('concepts')->with('status', 'Concept Created');
    }

    public function addTerm(Request $request)
    {
        $concept = Concept::find($request->route('concept'));
        $term = Term::create($request->all());
        $concept->terms()->save($term);
        //Savemany... Ref.
        if ($request->ajax()) {
            return [
                "termId" => $term->id,
            ];
        }
        return redirect('concepts', $concept->id)->with('status', 'Term Created');
    }

    public function markPreferred(Request $request)
    {
        $concept = Concept::find($request->route('concept'));

        foreach ($concept->terms as $term) {
            $term->preferred = false;
        }
        $term = Term::find($request->term_id);
        $term->preferred = true;
        $term->save();

        if ($request->ajax()) {
            return [
                "termId" => $term->id,
            ];
        }
        return redirect('concepts', $concept->id)->with('status', 'Term Marked Preferred');
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
            ->with('sources')
            ->findOrFail($concept_id);

        $isVocabularyEditor = false;
        $user = Auth::user();
        if (!Auth::guest()) {
            $isVocabularyEditor = $user->isVocabularyEditor();
        }

        $relations = [];

        if (count($concept->broader)) {
            $relations['Broader'] = [];
            foreach ($concept->broader as $broader) {
                $relations['Broader'][] = $broader->terms[0];
            }
        }

        if (count($concept->narrower)) {
            $relations['Narrower'] = [];
            foreach ($concept->narrower as $narrower) {
                $relations['Narrower'][] = $narrower->terms[0];
            }
        }

        if (count($concept->related)) {
            $relations['Related'] = [];
            foreach ($concept->related as $related) {
                $relations['Related'][] = $related->terms[0];
            }
        }

        return view(
            'concepts.show',
            compact('concept', 'isVocabularyEditor', 'relations')
        );
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function search_page(Concept $concept)
    {
        return view('concepts.search');
    }

    /**
     * Find a concept by preferred term.
     *
     * @param  \App\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function search(Concept $concept)
    {
        $term = $_GET["term"];
        $category = $_GET["category"] ?? "";
        $all_terms = isset($_GET["all_terms"]);
        // TODO: filter on deprecated;

        $terms = DB::table("concepts")->select("concepts.id as concept_id", "terms.id as term_id", "text", "value as category", "preferred")
            ->leftJoin("terms", "concepts.id", "=", "terms.concept_id")
            ->leftJoin("concept_categories", "concepts.id", "=", "concept_categories.concept_id")
            ->leftJoin("vocabulary", "concept_categories.category_id", "vocabulary.id")
            ->where([["text", "ILIKE", "%" . $term . "%"]]);

        if (!$all_terms) {
            $terms = $terms->where("preferred", "true");
        }

        if ($category) {
            $terms = $terms->where("vocabulary.value", "ilike", $category);
        }

        return $terms->get();
    }
}

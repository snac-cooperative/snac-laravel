<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermResource;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Term::class);
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
        $perPage = $request->query('perPage', 15);
        $perPage = min($perPage, 100); // Set a max limit of 100

        // Validate that perPage is a positive integer
        if (!is_numeric($perPage) || $perPage <= 0) {
            $perPage = 15; // Fallback to default if invalid
        }

        // Fetch the sort_by and sort_order parameters with defaults
        $sortBy = $request->query('sort_by', 'text'); // Default to sorting by 'text'
        $sortOrder = $request->query('sort_order', 'asc'); // Default to ascending order

        // Validate the sort_order to be either 'asc' or 'desc'
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        $items = Term::orderBy($sortBy, $sortOrder)->paginate($perPage);

        return TermResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Term::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        return $term;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        $term->update($request->all());
        return $term;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $term->delete();
        
        return response('Deleted ' . $term->id, 204);
    }
}

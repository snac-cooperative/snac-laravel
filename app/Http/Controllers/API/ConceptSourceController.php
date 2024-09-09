<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConceptSourceResource;
use App\Models\Concept;
use App\Models\ConceptSource;
use Illuminate\Http\Request;

class ConceptSourceController extends Controller
{
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
        $perPage = min($perPage, 100); // Set a max limit of 100

        // Validate that perPage is a positive integer
        if (!is_numeric($perPage) || $perPage <= 0) {
            $perPage = 15; // Fallback to default if invalid
        }

        // Fetch the sort_by and sort_order parameters with defaults
        $sortBy = $request->query('sort_by', 'id'); // Default to sorting by 'id'
        $sortOrder = $request->query('sort_order', 'asc'); // Default to ascending order

        // Validate the sort_order to be either 'asc' or 'desc'
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        $items = ConceptSource::orderBy($sortBy, $sortOrder)->paginate($perPage);

        return ConceptSourceResource::collection($items);
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

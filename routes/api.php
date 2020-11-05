<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Concept;
use App\Models\Term;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('concepts', function () {
    return Concept::with('conceptCategories')->get();
});

Route::apiResource('concepts', 'API\ConceptController');

Route::get('concepts_summary', function () {
    // Return only the preferred term
    // return Concept::with('conceptCategories')->with(['terms' => function ($query) {
    //     $query->where('preferred', true);
    // }])->get();
    return Term::where('preferred', 'true')->get();
});
Route::apiResource('concept_sources', 'API\ConceptSourceController');

Route::apiResource('terms', 'API\TermController');

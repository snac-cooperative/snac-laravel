<?php

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('concepts/reconcile/{id}', 'API\ConceptController@reconcile');
Route::get('concepts/reconcile', 'API\ConceptController@reconcile');

Route::put('concepts/{id}/relate_concept', 'ConceptController@relateConcepts');
Route::put('concepts/{id}/deprecate', 'API\ConceptController@deprecate');
Route::apiResource('concepts', 'API\ConceptController')->except([
    'update',
]);

Route::get('concepts_summary', function () {
    // Return only the preferred term
    // return Concept::with('conceptCategories')->with(['terms' => function ($query) {
    //     $query->where('preferred', true);
    // }])->get();
    return Term::where('preferred', 'true')->get();
});
Route::apiResource('concept_sources', 'API\ConceptSourceController');

Route::apiResource('terms', 'API\TermController');

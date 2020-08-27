<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
// });

Route::get('concepts', function () {
    return Concept::with('conceptCategories')->get();
});

Route::get('concepts/{id}', function ($id) {
    return Concept::findOrFail($id);
});


Route::get('concepts_summary', function () {
    // Return only the preferred term
    // return Concept::with('conceptCategories')->with(['terms' => function ($query) {
    //     $query->where('preferred', true);
    // }])->get();
    return Term::where('preferred', 'true')->get();
});

//
// Route::get('terms', function () {
//     return Term::all();
// });

Route::apiResource('terms', 'API\TermController');


// Route::get('concepts/find/{search_params}', function ($seachParams) {
    // return Concept::where($seachParams);
// });



// Route::get('concepts',              'ConceptsController@index');
// Route::get('concepts/create',       'ConceptsController@create');
// Route::post('concepts',             'ConceptsController@store');
// Route::get('concepts/{concept}',    'ConceptsController@show');
// Route::delete('concepts/{concept}', 'ConceptsController@destroy');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
// });

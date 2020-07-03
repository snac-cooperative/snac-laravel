<?php

use App\Concept;
use Illuminate\Http\Request;

/**
 * Show Concept Dashboard
 */
Route::get('/concept', 'ConceptController@index');

/**
 * Add New Concept
 */
Route::post('concept', function (Request $request) {
    //
});

/**
 * Delete Concept
 */
Route::delete('concept/{concept}', function (Concept $concept) {
    //
});

Route::get('/foo', function () {
    return 'Hello World';
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Concept;
use Illuminate\Http\Request;

/**
 * Show Concept Dashboard
 */
Route::get('/concept', 'ConceptController@index');

/**
 * Add New Concept
 */
Route::post('/concept', function (Request $request) {
    //
});

/**
 * Delete Concept
 */
Route::delete('/concept/{concept}', function (Concept $concept) {
    //
});

Route::get('/foo', function () {
    return 'Hello World';
});


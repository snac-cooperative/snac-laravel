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

Route::get('concepts',              'ConceptsController@index');
Route::get('conceptstable',              'ConceptsController@indextable');
Route::get('concepts/create',       'ConceptsController@create');
Route::post('concepts',             'ConceptsController@store');
Route::post('concepts/{concept}/add_term', 'ConceptsController@addTerm');
Route::get('concepts/{concept}',    'ConceptsController@show');
Route::delete('concepts/{concept}', 'ConceptsController@destroy');

Route::resource('terms', 'TermsController');

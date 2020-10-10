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

Route::get('concepts',              'ConceptController@index');
Route::post('concepts',             'ConceptController@store');
Route::get('concepts/create',       'ConceptController@create');
Route::get('concepts/search',       'ConceptController@search');
Route::post('concepts/{concept}/add_term', 'ConceptController@addTerm');
Route::get('concepts/{concept}',    'ConceptController@show');
Route::delete('concepts/{concept}', 'ConceptController@destroy');

Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('github/login', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/', 'ConceptController@index');

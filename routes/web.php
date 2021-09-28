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
use Illuminate\Support\Facades\Auth;

Route::get('concepts',              'ConceptController@index');
Route::post('concepts',             'ConceptController@store')->middleware('can:edit-vocabulary');
Route::get('concepts/create',       'ConceptController@create')->middleware('can:edit-vocabulary');
Route::get('concepts/search',       'ConceptController@search');
Route::post('concepts/{concept}/add_term', 'ConceptController@addTerm')->middleware('can:edit-vocabulary');
Route::get('concepts/{concept}',    'ConceptController@show');
Route::delete('concepts/{concept}', 'ConceptController@destroy');

Route::post('logout/all', function () {
    return Redirect::away(env('SNAC_AUTHENTICATION_URL') . '?command=logout3');
});
Route::get('logoff', function () {
    Auth::logout();
    if(isset($_GET['redirect'])) {
        return redirect(urldecode($_GET['redirect']));
    }
    return redirect('/');
});

Route::get('login/snac', function() {
    session(['_from_snac' => true]);
    if(isset($_GET['redirect'])) {
        session(['_redirect_after_login' => $_GET['redirect']]);
    }
    return Socialite::driver('google')->redirect();
});

Route::get('login/github', 'Auth\LoginController@redirectToGitHubProvider');
Route::get('github/login', 'Auth\LoginController@handleGitHubProviderCallback');

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('google/login', 'Auth\LoginController@handleProviderCallback');

Auth::routes(['register' => false]);

Route::get('/', 'ConceptController@index');


// Simple Form Routes
Route::get('repositories', 'RepositoryController@create');
Route::post('repositories', 'RepositoryController@store');
Route::get('resources_guided', 'ResourceController@create');
Route::get('cpfs', 'EntityController@create');
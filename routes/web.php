<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

// Disable Laravel user registration
Auth::routes(['register' => false]);

Route::get('/', [ConceptController::class, 'index']);

Route::controller(ConceptController::class)->group(function () {
    Route::get('concepts', 'index')->name('concepts.index');

    Route::get('concepts/search', 'search')->name('search');
    Route::get('concepts/search_page', 'search_page');
    Route::get('concepts/{concept}', 'show');

    Route::middleware(['auth'])->name('concepts.')->group(function () {
        Route::post('concepts', 'store')->name('store');
        Route::get('concepts/create', 'create')->name('create');
        Route::post('concepts/{concept}/add_term', 'addTerm')->name('addTerm');
        Route::delete('concepts/{concept}', 'destroy')->name('destroy');
    });
});

// Route::post('concepts',             'ConceptController@store')->middleware('can:edit-vocabulary'); // TODO: switch to can:edit-vocabulary after demo testing

Route::post('logout/all', function () {
    return Redirect::away(env('SNAC_AUTHENTICATION_URL') . '?command=logout3');
});
Route::get('logoff', function () {
    Auth::logout();
    if (isset($_GET['redirect'])) {
        return redirect(urldecode($_GET['redirect']));
    }
    return redirect('/');
});

Route::get('login/snac', function () {
    session(['_from_snac' => true]);
    if (isset($_GET['redirect'])) {
        session(['_redirect_after_login' => $_GET['redirect']]);
    }
    return Socialite::driver('google')->redirect();
});

Route::get('login/github', [LoginController::class, 'redirectToGitHubProvider']);
Route::get('github/login', [LoginController::class, 'handleGitHubProviderCallback']);

Route::get('login/google', [LoginController::class, 'redirectToProvider']);
Route::get('google/login', [LoginController::class, 'handleProviderCallback']);

// Simple Form Routes
Route::get('repositories', [RepositoryController::class, 'create']);
Route::post('repositories', [RepositoryController::class, 'store']);
Route::get('resources_guided', [ResourceController::class, 'create']);
Route::get('cpfs', [EntityController::class, 'create']);

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $localUser = User::select('id')->where('email', $user->email)->first();
        if(!$localUser) {
            return redirect('register');
        }
        Auth::loginUsingId($localUser->id, true);

        //SNAC LOGIN
        return Redirect::away('http://localhost/index.php?command=login3&code='.urlencode($user->token));
    }

    public function redirectToGitHubProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        $localUser = User::select('id')->where('email', $user->email)->first();
        if(!$localUser) {
            return redirect('register');
        }
        Auth::loginUsingId($localUser->id, true);
        return redirect('concepts');
    }
}

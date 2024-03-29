<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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

    public function authGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function registerGithub()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = \App\Models\User::updateOrCreate([
            'email' => $githubUser->email,

        ], [
            'name' => $githubUser->nickname,
            'email' => $githubUser->email,
            'avatar' => $githubUser->avatar,
            'password' => \Str::random(6)
        ]);

        \Auth::login($user);
        return redirect("/");
    }
    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }
}
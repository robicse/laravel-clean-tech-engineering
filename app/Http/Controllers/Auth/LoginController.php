<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo ;
    protected function redirectTo( ) {
        if (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Admin')) {
            return $this->redirectTo = '/home';
        }
        elseif (Auth::check() && (Auth::User()->getRoleNames()[0] == NULL)) {
            return $this->redirectTo = '/login';
        }
        elseif (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Customer')) {
            return $this->redirectTo = '/user/dashboard';
        }
        elseif (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Service Provider')) {
            return $this->redirectTo = '/user/dashboard';
        }
        else {
            return('/login');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

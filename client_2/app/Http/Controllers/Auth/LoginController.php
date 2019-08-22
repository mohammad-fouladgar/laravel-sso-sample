<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\MyBroker;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request, MyBroker $myBroker)
    {
        $this->validateLogin($request);

        //Login on SSO SERVER
        if($user = $myBroker->login($request->get('email'),$request->get('password'))){

            \Auth::loginUsingId($user['id']);

            return $this->sendLoginResponse($request);
        }
        
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $broker  = new MyBroker();
        $broker->logout();
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function showLoginForm()
    {
        return view('auth.login', [
            "title" => "User Login",
            "loginRoute" => "login",
            "forgotPasswordRoute" => "password.request"
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()
            ->route('login')
            ->with('status', 'User has been logged out!');
    }

    protected function authenticated(Request $request, $user)
    {
        // If User has been authenticated
        $user->last_login = $request->ip() . " " . $request->server('HTTP_USER_AGENT') . " " . date('Y-m-d H:i:s');
        $user->update();
        return redirect($this->redirectTo);
    }
}

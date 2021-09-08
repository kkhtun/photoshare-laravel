<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public $maxAttempts = 3;
    public $decayMinutes = 0.5;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    //
    public function showLoginForm()
    {
        return view('auth.login', [
            "title" => "Admin Login",
            "loginRoute" => "admin.login",
            "forgotPasswordRoute" => "admin.password.request"
        ]);
    }

    public function login(Request $request)
    {
        $this->validator($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()
                ->intended(route('admin.home'))
                ->with('status', 'You are logged in as admin!');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->loginFailed();
    }
    // This is necessary for login throttle to work 
    public function username()
    {
        return 'email';
    }

    public function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login failed, please try again');
    }

    public function validator(Request $request)
    {
        $rules = [
            "email" => "required|email|exists:admins|min:4|max:127",
            "password" => "required|string|min:4|max:127",
        ];

        $messages = [
            "email.exists" => "The credentials do not match our records"
        ];

        $request->validate($rules, $messages);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.login')
            ->with('status', 'Admin has been logged out!');
    }
}

<?php

namespace App\Http\Controllers\Backend\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'backend.user.';

    /**
     * check user logged in
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){
        if(Auth::guard('user')->check()){
            return redirect()->route('user.dashboard');
        }

        return view($this->pathView . 'auth.login');
    }

    /**
     * authenticate user to login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('user')->attempt($credentials, $request->has('remember_me'))){
            $request->session()->regenerate();
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'error' => trans('message.error_login')
        ]);
    }

    /**
     * user logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }
}

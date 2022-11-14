<?php

namespace App\Http\Controllers\Backend\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'Backend.Admin.';

    public function index()
    {
        //
        if (Auth::guard('admin')->check()) {
            // return route dashboard
            // return redirect('')

        }

        return view($this->pathView .'Auth.Login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();
            // return redirect()->route($this->pathView . 'DashBoard.demo');

            // return redirect()->route('welcome');
        }

        return back()->withErrors([
            'error' => trans('message.error_login')
        ]);
    }

}

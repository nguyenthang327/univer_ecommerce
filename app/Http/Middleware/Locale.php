<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\Language;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $admin = Auth::guard('admin')->user();
        // $user = Auth::guard('user')->user();
        // if($admin){
        //     $language = Language::find($admin->language_id);
        //     if($language){
        //         $locale = $language->name;
        //         App::setLocale($locale);
        //         session()->put('locale', $locale);
        //     }
        // }elseif($user) {
        //     $language = Language::find($user->language_id);
        //     if($language){
        //         $locale = $language->name;
        //         App::setLocale($locale);
        //         session()->put('locale', $locale);
        //     }
        // }else{
        //     App::setLocale(session()->get('locale') ?? 'vi');
        // }
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }else{
            session()->put('locale', 'vi');
            App::setLocale('vi');
        }
        return $next($request); 
    }
}

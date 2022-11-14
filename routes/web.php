<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminLogin;

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

Route::get('/', function () {
    return view('welcome');
});


// Backend admin
Route::middleware('web')->group(function () {
    Route::prefix('/admin')->group(function(){

        // auth
        Route::get('/login', [AdminLogin::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminLogin::class, 'authenticate'])->name('admin.post.login');
        Route::post('/logout', [AdminLogin::class, 'logout'])->name('admin.logout');
    });
});
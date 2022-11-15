<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminLogin;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Backend\Admin\AdminController;

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
    return view('Backend.Admin.Layout.master');
});


// Backend admin
Route::middleware('web')->group(function () {
    Route::prefix('/admin')->group(function(){

        // auth
        Route::get('/login', [AdminLogin::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminLogin::class, 'authenticate'])->name('admin.post.login');
        Route::post('/logout', [AdminLogin::class, 'logout'])->name('admin.logout');

        Route::group(['middleware' => ['auth.admin']], function(){
            // dashboard
            Route::get('/', [AdminDashboard::class, 'index'])->name('admin.dashboard');

            // profile
            Route::prefix('/profile')->group(function(){
               Route::get('/', [AdminController::class, 'index'])->name('admin.profile');
               Route::put('/edit', [AdminController::class, 'edit'])->name('admin.profile.edit');
            });
        });
    });
});

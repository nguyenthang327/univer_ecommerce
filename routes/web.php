<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminLogin;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Backend\Admin\UserController as BeUser;

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
               Route::get('/', [AdminController::class, 'adminProfile'])->name('admin.profile');
               Route::put('/{id}', [AdminController::class, 'update'])->name('admin.profile.update');
               Route::get('{id}/avatar', [AdminController::class, 'getAvatar'])->name('admin.avatar');

            });

            // user
            Route::prefix('/user')->group(function(){
                Route::get('/', [BeUser::class, 'index'])->name('admin.user.index');
                Route::get('/create', [BeUser::class, 'create'])->name('admin.user.create');
                Route::get('/{id}/edit', [BeUser::class, 'edit'])->name('admin.user.edit');
                Route::put('/{id}/update', [BeUser::class, 'update'])->name('admin.user.update');
                Route::delete('/{id}/destroy', [BeUser::class, 'destroy'])->name('admin.user.destroy');
                Route::get('{id}/avatar', [BeUser::class, 'getAvatar'])->name('admin.user.avatar');
            });
        });
    });
});


// Get administrative units
Route::get('getDistrictList', [AddressController::class, 'getDistrictList'])->name('getDistrictList');
Route::get('getCommuneList', [AddressController::class, 'getCommuneList'])->name('getCommuneList');
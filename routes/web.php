<?php

use Illuminate\Support\Facades\Route;
// Route admin
use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminAuth;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Backend\Admin\UserController as BeUser;
use App\Http\Controllers\Backend\Admin\CategoryController;

// Route user
use App\Http\Controllers\Backend\User\Auth\LoginController as UserAuth;
use App\Http\Controllers\Backend\User\DashboardController as UserDashboard;

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


Route::middleware('web')->group(function () {

    // Backend admin
    Route::prefix('/admin')->group(function(){

        // auth
        Route::get('/login', [AdminAuth::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminAuth::class, 'authenticate'])->name('admin.post.login');
        Route::post('/logout', [AdminAuth::class, 'logout'])->name('admin.logout');

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
                Route::post('/store', [BeUser::class, 'store'])->name('admin.user.store');
                Route::get('/{id}/edit', [BeUser::class, 'edit'])->name('admin.user.edit');
                Route::put('/{id}/update', [BeUser::class, 'update'])->name('admin.user.update');
                Route::delete('/{id}/destroy', [BeUser::class, 'destroy'])->name('admin.user.destroy');
                Route::post('/{id}/restore', [BeUser::class, 'restore'])->name('admin.user.restore');
                Route::get('{id}/avatar', [BeUser::class, 'getAvatar'])->name('admin.user.avatar');
            });

            // Product category
            Route::prefix('/product-category')->group(function(){
                Route::get('/', [CategoryController::class, 'index'])->name('admin.productCategory.index');
                Route::get('/create', [CategoryController::class, 'create'])->name('admin.productCategory.create');
                Route::post('/store', [CategoryController::class, 'store'])->name('admin.productCategory.store');
                Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('admin.productCategory.edit');
                Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.productCategory.update');
            });
        });
    });

    // Backend user
    Route::prefix('/user')->group(function(){

        // auth
        Route::get('/login', [UserAuth::class, 'index'])->name('user.login');
        Route::post('/login', [UserAuth::class, 'authenticate'])->name('user.post.login');
        Route::post('/logout', [UserAuth::class, 'logout'])->name('user.logout');

        Route::group(['middleware' => ['auth.user']], function(){
            // dashboard
            Route::get('/', [UserDashboard::class, 'index'])->name('user.dashboard');

            // profile
            Route::prefix('/profile')->group(function(){
               Route::get('/', [AdminController::class, 'userProfile'])->name('user.profile');
               Route::put('/{id}', [AdminController::class, 'update'])->name('user.profile.update');
               Route::get('{id}/avatar', [AdminController::class, 'getAvatar'])->name('user.avatar');
            });

            // Product category
            Route::prefix('/product-category')->group(function(){
                Route::get('/', [CategoryController::class, 'index'])->name('user.productCategory.index');
            });
        });
    });
});

// Get administrative units
Route::get('getDistrictList', [AddressController::class, 'getDistrictList'])->name('getDistrictList');
Route::get('getCommuneList', [AddressController::class, 'getCommuneList'])->name('getCommuneList');
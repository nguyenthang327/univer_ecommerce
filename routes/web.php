<?php

use Illuminate\Support\Facades\Route;
// Route admin
use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminAuth;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Backend\Admin\UserController as BeAdminUser;
use App\Http\Controllers\Backend\Admin\CategoryController;
use App\Http\Controllers\Backend\Admin\BrandController;
use App\Http\Controllers\Backend\Admin\CouponController;
use App\Http\Controllers\Backend\Admin\CustomerController;
use App\Http\Controllers\Backend\User\CustomerController as UserCustomerController;
use App\Http\Controllers\Backend\Admin\OrderController as AdminOrderController;
// Route user
use App\Http\Controllers\Backend\User\Auth\LoginController as UserAuth;
use App\Http\Controllers\Backend\User\DashboardController as UserDashboard;
use App\Http\Controllers\Backend\User\OrderController as UserOrderController;
use App\Http\Controllers\Backend\User\ProductController;
use App\Http\Controllers\Backend\User\UserController as BeUser;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\App;

// Route Frontend
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductCommentController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\ProfileController;

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

// Route::middleware('web')->group(function () {

    // Backend admin
    Route::prefix('/admin')->group(function(){

        // auth
        Route::get('/login', [AdminAuth::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminAuth::class, 'authenticate'])->name('admin.post.login');
        Route::post('/logout', [AdminAuth::class, 'logout'])->name('admin.logout');

        Route::group(['middleware' => ['auth:admin']], function(){
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
                Route::get('/', [BeAdminUser::class, 'index'])->name('admin.user.index');
                Route::get('/create', [BeAdminUser::class, 'create'])->name('admin.user.create');
                Route::post('/store', [BeAdminUser::class, 'store'])->name('admin.user.store');
                Route::get('/{id}/edit', [BeAdminUser::class, 'edit'])->name('admin.user.edit');
                Route::put('/{id}/update', [BeAdminUser::class, 'update'])->name('admin.user.update');
                Route::delete('/{id}/destroy', [BeAdminUser::class, 'destroy'])->name('admin.user.destroy');
                Route::post('/{id}/restore', [BeAdminUser::class, 'restore'])->name('admin.user.restore');
                Route::get('{id}/avatar', [BeAdminUser::class, 'getAvatar'])->name('admin.user.avatar');
            });

             // customer
             Route::prefix('/customer')->group(function(){
                 // Customer
                Route::get('/', [CustomerController::class, 'index'])->name('admin.customer.index');
                Route::get('{id}/avatar', [CustomerController::class, 'getAvatar'])->name('admin.customer.avatar');
                Route::get('/create', [CustomerController::class, 'create'])->name('admin.customer.create');
                Route::post('/store', [CustomerController::class, 'store'])->name('admin.customer.store');
                Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('admin.customer.edit');
                Route::put('/{id}/update', [CustomerController::class, 'update'])->name('admin.customer.update');
                Route::delete('/{id}/destroy', [CustomerController::class, 'destroy'])->name('admin.customer.destroy');
                Route::post('/{id}/restore', [CustomerController::class, 'restore'])->name('admin.customer.restore');
            });

            // Product category
            Route::prefix('/product-category')->group(function(){
                Route::get('/create', [CategoryController::class, 'create'])->name('admin.productCategory.create');
                Route::post('/store', [CategoryController::class, 'store'])->name('admin.productCategory.store');
                Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('admin.productCategory.edit');
                Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.productCategory.update');
                Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.productCategory.destroy');
            });

            // Brand
            Route::prefix('/brand')->group(function(){
                Route::get('/', [BrandController::class, 'index'])->name('admin.brand.index');
                Route::post('/store', [BrandController::class, 'store'])->name('admin.brand.store');
                Route::post('/update/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
                Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('admin.brand.destroy');
            });

             // Brand
            Route::prefix('/coupon')->group(function(){
                Route::get('/', [CouponController::class, 'index'])->name('admin.coupon.index');
                Route::get('/create', [CouponController::class, 'create'])->name('admin.coupon.create');
                Route::post('/store', [CouponController::class, 'store'])->name('admin.coupon.store');
                Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('admin.coupon.edit');
                Route::put('/update/{id}', [CouponController::class, 'update'])->name('admin.coupon.update');
                Route::delete('/destroy/{id}', [CouponController::class, 'destroy'])->name('admin.coupon.destroy');
            });

            // Order
            Route::prefix('/order')->group(function(){
                Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order.index');
                Route::get('/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.order.edit');
                Route::put('/update/{id}', [AdminOrderController::class, 'update'])->name('admin.order.update');
                // Route::delete('/{id}/destroy', [AdminOrderController::class, 'destroy'])->name('admin.order.destroy');
            });
        });
    });

    // Backend user
    Route::prefix('/user')->group(function(){

        // auth
        Route::get('/login', [UserAuth::class, 'index'])->name('user.login');
        Route::post('/login', [UserAuth::class, 'authenticate'])->name('user.post.login');
        Route::post('/logout', [UserAuth::class, 'logout'])->name('user.logout');

        Route::group(['middleware' => ['auth:user']], function(){
            // dashboard
            Route::get('/', [UserDashboard::class, 'index'])->name('user.dashboard');

            // profile
            Route::prefix('/profile')->group(function(){
               Route::get('/', [BeUser::class, 'userProfile'])->name('user.profile');
               Route::put('/', [BeUser::class, 'update'])->name('user.profile.update');
               Route::get('{id}/avatar', [BeUser::class, 'getAvatar'])->name('user.avatar');
            });

            // Customer
            Route::prefix('/customer')->group(function() {
                Route::get('/', [UserCustomerController::class, 'index'])->name('user.customer.index');
                Route::get('{id}/avatar', [UserCustomerController::class, 'getAvatar'])->name('user.customer.avatar');
            });

              // Order
            Route::prefix('/order')->group(function(){
                Route::get('/', [UserOrderController::class, 'index'])->name('user.order.index');
                Route::get('/{id}/edit', [UserOrderController::class, 'edit'])->name('user.order.edit');
                Route::put('/update/{id}', [UserOrderController::class, 'update'])->name('user.order.update');
                // Route::delete('/{id}/destroy', [AdminOrderController::class, 'destroy'])->name('admin.order.destroy');
            });
        });
    });

    Route::group(['middleware' => ['auth:admin,user']], function(){
        Route::post('files/uploadTemp', [UploadController::class, 'uploadTemp'])->name('file.uploadTemp');
        Route::delete('files/removeFile', [UploadController::class, 'removeFile'])->name('file.removeFile');

        // Product category
        Route::prefix('/manage')->group(function(){
            Route::prefix('/product-category')->group(function(){
                Route::get('/', [CategoryController::class, 'index'])->name('admin.productCategory.index');
            });

             // Product
            Route::prefix('/product')->group(function(){
                Route::get('/', [ProductController::class, 'index'])->name('user.product.index');
                Route::get('/create', [ProductController::class, 'create'])->name('user.product.create');
                Route::post('/store', [ProductController::class, 'store'])->name('user.product.store');
                Route::get('/edit/{slug}', [ProductController::class, 'edit'])->name('user.product.edit');
                Route::put('/update/{id}', [ProductController::class, 'update'])->name('user.product.update');
                Route::put('/{id}/update-type', [ProductController::class, 'updateTypeProduct'])->name('user.product.updateTypeProduct');
                Route::post('/option/{id}', [ProductController::class, 'option'])->name('user.product.option');
                Route::delete('/{productId}/option/{id}', [ProductController::class, 'deleteOption'])->name('user.product.deleteOption');
                Route::post('/{productId}/generate-variation', [ProductController::class, 'generateVariation'])->name('user.product.generateVariation');
                Route::put('/{productId}/update-sku', [ProductController::class, 'updateSku'])->name('user.product.updateSku');
                Route::delete('/{id}/destroy', [ProductController::class, 'destroy'])->name('user.product.destroy');
            });
        });

        //export order
        Route::get('export-order-PDF/{id}', [AdminOrderController::class, 'exportOrderPDF'])->name('order.export.pdf');
    });
// });

// Get administrative units
Route::get('getDistrictList', [AddressController::class, 'getDistrictList'])->name('getDistrictList');
Route::get('getCommuneList', [AddressController::class, 'getCommuneList'])->name('getCommuneList');

Route::middleware('web')->group(function () {
    Route::get('/language/{locale}', [HomepageController::class, 'changeLanguage'])->name('changeLanguage');
    Route::get('/', [HomepageController::class, 'index'])->name('site.home');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('customer.login');

    Route::get('/register', [AuthController::class, 'registerStep1'])->name('customer.register.step1');
    Route::post('/register', [AuthController::class, 'register'])->name('customer.register');
    Route::get('/register/verify/{id}', [AuthController::class, 'registerStep2'])->name('customer.register.step2');
    Route::post('/register/verify/{id}', [AuthController::class, 'registerVerify'])->name('customer.register.verify');

    Route::post('/logout', [AuthController::class, 'logout'])->name('customer.logout');

    Route::prefix('/product')->group(function(){
        Route::get('/', [FrontendProductController::class, 'index'])->name('site.product.index');
        Route::get('/{slug}', [FrontendProductController::class, 'show'])->name('site.product.show');
    });

    Route::group(['middleware' => ['auth:customer']], function(){
        Route::prefix('/infor')->group(function(){
            Route::get('', [ProfileController::class, 'index'])->name('customer.index');
            Route::post('/update', [ProfileController::class, 'update'])->name('customer.update');
        });

        Route::prefix('/product-wishlist')->group(function(){
            Route::get('/', [FrontendProductController::class, 'listFavoriteProduct'])->name('customer.product.listFavoriteProduct');
            Route::post('/store', [FrontendProductController::class, 'favoriteStore'])->name('customer.product.favoriteStore');
        });

        Route::prefix('/cart')->group(function(){
            Route::get('/', [CartController::class, 'index'])->name('customer.cart.index');
            Route::post('/add', [CartController::class, 'store'])->name('customer.cart.store');
            Route::put('/{id}', [CartController::class, 'update'])->name('customer.cart.update');
            Route::delete('/{id}/destroy/', [CartController::class, 'destroy'])->name('customer.cart.destroy');
        });

        Route::prefix('/coupon')->group(function(){
            Route::get('check', [CartController::class, 'checkCoupon'])->name('check.coupon');
        });

        Route::prefix('/order')->group(function(){
            Route::get('/', [OrderController::class, 'checkoutView'])->name('customer.order.checkoutView');
            Route::post('/store', [OrderController::class, 'store'])->name('customer.order.store');
            Route::get('/order-completed', [OrderController::class, 'orderCompletedView'])->name('customer.order.orderCompletedView');
            Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('customer.order.orderHistory');
            Route::get('/{id}/show', [OrderController::class, 'getDetail'])->name('customer.order.getDetail');
        });

        Route::prefix('/comment')->group(function(){
            Route::get('/', [ProductCommentController::class , 'index'])->name('customer.comment.product.index');
            Route::post('/store', [ProductCommentController::class, 'store'])->name('customer.comment.product.store');
            Route::delete('/{id}/delete', [ProductCommentController::class, 'destroy'])->name('customer.comment.product.delete');
        });
    });
});

Route::group(['middleware' => ['auth:admin,user,customer']], function(){
    Route::post('password/update', [ChangePasswordController::class, 'changePasswod'])->name('password.update');
});

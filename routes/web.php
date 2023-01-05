<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

/**
 * Route for admin
 */

// Group route with prefix 'admin'
Route::prefix('admin')->group(function () {
    // Group route with middleware 'auth'
    Route::group(['middleware' => 'auth'], function () {
        // Group dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        // Route Category
        Route::resource('/category', CategoryController::class, ['as' => 'admin']);

        // Route Product
        Route::resource('/product', ProductController::class, ['as' => 'admin']);

        //route order
        Route::resource('/order', OrderController::class, ['except' => [
            'create', 'store', 'edit', 'update', 'destroy'
        ], 'as' => 'admin']);

        //route customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');

        //route slider
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);

        //profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');

        //route user
        Route::resource('/user', UserController::class, ['except' => ['show'], 'as' => 'admin']);
    });
});

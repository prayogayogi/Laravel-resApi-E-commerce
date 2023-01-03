<?php

use App\Http\Controllers\Admin\CategoryController;
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
    });
});

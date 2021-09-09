<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComeController;
use App\Http\Controllers\ComeOutsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ComeReportsController;
use App\Http\Controllers\ComeOutsReportsController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    
    Route::middleware(['staff'])->group(function () {
        Route::resource('categories', CategoriesController::class)->except(['create', 'edit']);
        Route::resource('products', ProductsController::class)->except(['create', 'edit']);
        Route::resource('comes', ComeController::class)->only(['store','update','destroy']);
        Route::resource('come_outs', ComeOutsController::class)->only(['store','update','destroy']);
    });

    Route::middleware(['admin'])->group(function () {
        Route::prefix('come_reports')->group(function () {
            Route::get('daily', [ComeReportsController::class, 'daily']);
            Route::get('weekly', [ComeReportsController::class, 'weekly']);
            Route::get('monthly', [ComeReportsController::class, 'monthly']);
            Route::get('yearly', [ComeReportsController::class, 'yearly']);
        });
        Route::prefix('out_reports')->group(function () {
            Route::get('daily', [ComeOutsReportsController::class, 'daily']);
            Route::get('weekly', [ComeOutsReportsController::class, 'weekly']);
            Route::get('monthly', [ComeOutsReportsController::class, 'monthly']);
            Route::get('yearly', [ComeOutsReportsController::class, 'yearly']);
        });
    });
});

Route::post('register/{role}', [RegisterController::class, 'register'])->name('register');
Route::post('login', [RegisterController::class, 'login'])->name('login');
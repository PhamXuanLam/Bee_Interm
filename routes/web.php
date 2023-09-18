<?php

use App\Helpers\Common;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProductCategoryController;
use App\Http\Controllers\User\StatisticalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.dashboard');
});

/**
 * Auth User
*/

Route::prefix('/')->group(function () {
    Route::get('/login', [AuthController::class, "show"]);
    Route::post('/login', [AuthController::class, "login"])->name('login');
    Route::post('/logout', [AuthController::class, "logout"])->name("logout");
    Route::get('/forgot-password', [AuthController::class, "forgotPassword"])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'mailForgotPassword'])->name('mail-forgot-password');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
});

/**
 * User -> Category
 */

Route::prefix("/category")->middleware("auth:web")->group(function () {
    Route::get("/", [ProductCategoryController::class, "index"])->name("category.index");

    Route::get("/create", [ProductCategoryController::class, "create"])->name("category.create");
    Route::post("/", [ProductCategoryController::class, "store"])->name("category.store");

    Route::get("/{id}/edit", [ProductCategoryController::class, "edit"])->where("id", "[0-9]+")->name("category.edit");
    Route::put("/{id}", [ProductCategoryController::class, "update"])->where("id", "[0-9]+")->name("category.update");

    Route::delete("/{id}", [ProductCategoryController::class, "destroy"])->where("id", "[0-9]+")->name("category.destroy");
});

/**
 * Product management
 */
Route::prefix("/product")->group(function () {
    Route::get("/{id}", [ProductController::class, "show"])->where("id", "[0-9]+")->name("product.show");
    Route::get("/", [ProductController::class, "index"])->name("product.index");

    Route::get('/create', [ProductController::class, "create"])->name("product.create");
    Route::post("/", [ProductController::class, "store"])->name("product.store");

    Route::get("/{id}/edit", [ProductController::class, 'edit'])->where('id', '[0-9]+')->name("product.edit");
    Route::put("/{id}", [ProductController::class, 'update'])->where("id", "[0-9]+")->name("product.update");

    Route::delete("/{id}", [ProductController::class, "destroy"])->where("id", "[0-9]+")->name("product.delete");

    Route::post("/download", [ProductController::class, "download"])->name("product.download");
    Route::get("/{id}/{avatar?}", [ProductController::class, 'showImage'])->where("id", "[0-9]+")->name("product.image");
})->middleware('auth:web');

/**
 * Order management
 */
Route::prefix("/order")->group(function () {
    Route::get("/{id}", [OrderController::class, "show"])->where("id", "[0-9]+")->name("order.show");
    Route::get("/", [OrderController::class, "index"])->name("order.index");
    Route::get("/download/{id}", [OrderController::class, "download"])->where("id", "[0-9]+")->name("order.download");
})->middleware('auth:web');

/**
 * Statistical and Chart
 */
Route::prefix("/statistical")->group(function () {
    Route::get("/chart", [StatisticalController::class, "chart"])->name("statistical.chart");
    Route::get("/customer/{id}", [StatisticalController::class, "customers"])->where("id", "[0-9]+")->name("statistical.customer");
    Route::get("/", [StatisticalController::class, "index"])->name("statistical.index");
})->middleware('auth:web');

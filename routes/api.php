<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:customer_api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/customer')->group(function () {
    Route::post("/login", [CustomerController::class, 'login']);
    Route::get('/show', [CustomerController::class, 'show']);
    Route::put('/update', [CustomerController::class, 'update']);
})->middleware("auth:customer_api");

Route::prefix('/product')->group(function ()  {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
})->middleware("auth:customer_api");

Route::prefix("/order")->group(function () {
    Route::post('/', [OrderController::class, 'store']);
})->middleware("auth:customer_api");

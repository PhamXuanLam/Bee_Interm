<?php

use App\Http\Controllers\Admin\AdministrativeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
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
    return view('admin.dashboard');
})->middleware('auth:admin')->name('admin');

/**
 * Auth admin
 */
Route::prefix("/")->group(function () {
    Route::get('/login', [AuthController::class, "show"]);
    Route::post('/login', [AuthController::class, "login"])->name("admin.login");
    Route::post('/logout', [AuthController::class, "logout"])->name("admin.logout");
});


Route::middleware('locale')->group(function () {
    Route::get('/change-language/{language}', [UserController::class, 'changeLanguage'])->name('change-language');
    /**
     * User management
     */
    Route::prefix("/users")->group(function () {
        Route::get("/{id}", [UserController::class, "show"])->where("id", "[0-9]+")->name("admin.users.show");
        Route::get("/", [UserController::class, "index"])->name("admin.users.index");

        Route::get('/create', [UserController::class, "create"])->name("admin.users.create");
        Route::post("/", [UserController::class, "store"])->name("admin.users.store");

        Route::get("/{id}/edit", [UserController::class, 'edit'])->where('id', '[0-9]+')->name("admin.users.edit");
        Route::put("/{id}", [UserController::class, 'update'])->where("id", "[0-9]+")->name("admin.users.update");

        Route::delete("/{id}", [UserController::class, "destroy"])->where("id", "[0-9]+")->name("admin.users.delete");
        Route::get("/{id}/{avatar?}", [UserController::class, 'showImage'])->where("id", "[0-9]+")->name("users.image");
    })->middleware('auth:admin')->name('admin');

    /**
     * Administrative
     */

    Route::prefix('/administrative')->group(function () {
        Route::get('/', [AdministrativeController::class, 'showUpload']);
        Route::post('/', [AdministrativeController::class, 'import']);

        Route::get("/{id}/district", [AdministrativeController::class, 'getDistricts'])->where("id", "[0-9]+")->name('administrative.districts');
        Route::get("/{id}/commune", [AdministrativeController::class, 'getCommunes'])->where("id", "[0-9]+")->name('administrative.communes');
    });
});


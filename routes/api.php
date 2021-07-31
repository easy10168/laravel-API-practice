<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//public API
Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::get('/books/search/{name}', [BookController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//protected API for user
Route::middleware('auth:sanctum', 'auth.role.user')->group(function () {
    Route::apiResource('/carts', CartController::class);
    Route::apiResource('/cart-items', CartItemController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkout', [CartController::class, 'checkout']);
});

//protected API for admin
Route::prefix('admin')->group(function () {

    Route::post('/register', [AuthController::class, 'adminRegister']);
    Route::post('/login', [AuthController::class, 'adminLogin']);

    Route::middleware(['auth:sanctum', 'auth.role.admin'])->group(
        function () {
            Route::apiResource('/books', BookController::class)->except(['index', 'show']);
        }
    );
});

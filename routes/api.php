<?php

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

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;

Route::middleware(['jwt-auth'])->group(function(){
    Route::post('/categories', [CategoriesController::class,'store']);
    Route::get('/categories', [CategoriesController::class,'show']);
    Route::put('/categories/{id}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriesController::class, 'delete']);

});

Route::middleware(['web'])->group(function () {
    Route::get('auth/google', [GoogleAuthController::class, 'redirect']);
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle']);
});

Route::get('/login/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('oauth.google');
Route::get('/login/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);


Route::post('/product', [ProductController::class,'store']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/product', [ProductController::class, 'show']);
Route::get('/product/{id}', [ProductController::class, 'showById']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'delete']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

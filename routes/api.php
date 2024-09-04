<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
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

Route::middleware(['auth'])->prefix('auth')->group(function () {
   Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('auth');
   Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function() {
   Route::post('film', [FilmController::class, 'index'])->withoutMiddleware(['auth', 'verified']);
   Route::post('film/store', [FilmController::class, 'store'])->withoutMiddleware(['auth', 'verified']);
   Route::apiResource('film', FilmController::class)->except('index', 'store')->withoutMiddleware(['auth', 'verified']);
});
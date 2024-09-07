<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
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
   Route::post('film', [FilmController::class, 'index']);
   Route::post('film/store', [FilmController::class, 'store']);
   Route::apiResource('film', FilmController::class)->except('index', 'store');

   Route::post('genre', [GenreController::class, 'index']);
   Route::post('genre/store', [GenreController::class, 'store']);
   Route::apiResource('genre', GenreController::class)->except('index', 'store');
});
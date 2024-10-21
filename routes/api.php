<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookedSeatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\FilmCastsController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth', 'json'])->prefix('auth')->group(function () {
   Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('auth');
   Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth');
   Route::delete('logout', [AuthController::class, 'logout']);
   Route::get('me', [AuthController::class, 'me']);
});

Route::middleware(['auth', 'verified'])->prefix('master')->group(function() {   
   Route::post('users', [UserController::class, 'index']);
   Route::post('users/store', [UserController::class, 'store']);
   Route::apiResource('users', UserController::class)->except('index', 'store');

   Route::get('cinema', [CinemaController::class, 'get']);
   Route::post('cinema', [CinemaController::class, 'index']);
   Route::post('cinema/store', [CinemaController::class, 'store']);
   Route::apiResource('cinema', CinemaController::class)->except('index', 'store');
   
   Route::post('booked-seat', [BookedSeatController::class, 'index']);
   Route::post('booked-seat/store', [BookedSeatController::class, 'store']);
   Route::apiResource('booked-seat', BookedSeatController::class)->except('index', 'store');
   
   Route::post('booking', [BookingController::class, 'index']);
   Route::post('booking/store', [BookingController::class, 'store']);
   Route::apiResource('booking', BookingController::class)->except('index', 'store');
   
   Route::get('film', [FilmController::class, 'get']);
   Route::post('film', [FilmController::class, 'index']);
   Route::post('film/store', [FilmController::class, 'store']);
   Route::apiResource('film', FilmController::class)->except('index', 'store');

   Route::post('film-cast', [FilmCastsController::class, 'index']);
   Route::post('film-cast/store', [FilmCastsController::class, 'store']);
   Route::apiResource('film-cast', FilmCastsController::class)->except('index', 'store');
   
   Route::post('genre', [GenreController::class, 'index']);
   Route::post('genre/store', [GenreController::class, 'store']);
   Route::apiResource('genre', GenreController::class)->except('index', 'store');
   
   Route::post('payment', [PaymentController::class, 'index']);
   Route::post('payment/store', [PaymentController::class, 'store']);
   Route::apiResource('payment', PaymentController::class)->except('index', 'store');

   Route::post('promotion', [PromotionController::class, 'index']);
   Route::post('promotion/store', [PromotionController::class, 'store'])->withoutMiddleware(['auth', 'verified']);
   Route::apiResource('promotion', PromotionController::class)->except('index', 'store');

   Route::post('review', [ReviewController::class, 'index']);
   Route::post('review/store', [ReviewController::class, 'store']);

   Route::apiResource('review', ReviewController::class)->except('index', 'store');

   Route::post('seat', [SeatController::class, 'index']);
   Route::post('seat/store', [SeatController::class, 'store']);
   Route::apiResource('seat', SeatController::class)->except('index', 'store');

   Route::post('show-time', [ShowtimeController::class, 'index']);
   Route::post('show-time/store', [ShowtimeController::class, 'store']);
   Route::apiResource('show-time', ShowtimeController::class)->except('index', 'store');

   Route::get('studio', [StudioController::class, 'get']);
   Route::post('studio', [StudioController::class, 'index']);
   Route::post('studio/store', [StudioController::class, 'store']);
   Route::apiResource('studio', StudioController::class)->except('index', 'store');
});
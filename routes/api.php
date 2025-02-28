<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookedSeatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilmCastsController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SettingController;
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
   Route::post('send-otp', [AuthController::class, 'sendOtp'])->withoutMiddleware('auth');
   Route::post('send-otp-forgot', [AuthController::class, 'sendOtpForgotPassword'])->withoutMiddleware('auth');
   Route::post('match-otp-forgot', [AuthController::class, 'matchOtpForgotPassword'])->withoutMiddleware('auth');
   Route::post('update-forgot-password', [AuthController::class, 'updateForgotPassword'])->withoutMiddleware('auth');
   Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth');
   Route::delete('logout', [AuthController::class, 'logout']);
   Route::get('me', [AuthController::class, 'me']);
});

Route::prefix('setting')->group(function () {
   Route::get('', [SettingController::class, 'get']);
   Route::post('update', [SettingController::class, 'update']);
});

Route::post('contact-us', [ContactController::class, 'index'])->middleware((['throttle:3,1']));


Route::middleware(['auth', 'verified'])->prefix('master')->group(function() {
   Route::post('users', [UserController::class, 'index']);
   Route::post('users/store', [UserController::class, 'store']);
   Route::post('users/update/akun', [UserController::class, 'updateAkun']);
   Route::post('users/update/keamanan', [UserController::class, 'updateSecurity']);
   Route::apiResource('users', UserController::class)->except('index', 'store');

   Route::get('cinema', [CinemaController::class, 'get']);
   Route::post('cinema', [CinemaController::class, 'index'])->withoutMiddleware(['auth', 'verified']);
   Route::post('cinema/store', [CinemaController::class, 'store']);
   Route::apiResource('cinema', CinemaController::class)->except('index', 'store');

   Route::post('booked-seat', [BookedSeatController::class, 'index']);
   Route::post('booked-seat/show-by-booking', [BookedSeatController::class, 'showByBooking']);
   Route::post('booked-seat/store', [BookedSeatController::class, 'store']);
   Route::post('payment/midtrans-notification', [BookedSeatController::class, 'callback'])->withoutMiddleware(['auth', 'verified']);
   Route::apiResource('booked-seat', BookedSeatController::class)->except('index', 'store');

   Route::post('booking', [BookingController::class, 'index']);
   Route::post('booking/store', [BookingController::class, 'store'])->withoutMiddleware(['auth', 'verified']);
   Route::get("booking/report", [BookingController::class, "report"])->withoutMiddleware(['auth', 'verified']);
   Route::post('booking/history', [BookingController::class, 'history']);
   Route::apiResource('booking', BookingController::class)->except('index', 'store');

   Route::get('film', [FilmController::class, 'get'])->withoutMiddleware(['auth', 'verified']);
   Route::get('film/top-film', [FilmController::class, 'topFilm'])->withoutMiddleware(['auth', 'verified']);
   Route::get('film/now-showing', [FilmController::class, 'nowShowing'])->withoutMiddleware(['auth', 'verified']);
   Route::get('film/coming-soon', [FilmController::class, 'comingSoon'])->withoutMiddleware(['auth', 'verified']);
   Route::post('film', [FilmController::class, 'index']);
   Route::post('film/store', [FilmController::class, 'store']);
   Route::apiResource('film', FilmController::class)->except('index', 'store')->withoutMiddleware(['auth', 'verified']);

   Route::post('film-cast', [FilmCastsController::class, 'index']);
   Route::post('film-cast/store', [FilmCastsController::class, 'store']);
   Route::apiResource('film-cast', FilmCastsController::class)->except('index', 'store');

   Route::get('genre', [GenreController::class, 'get']);
   Route::post('genre', [GenreController::class, 'index']);
   Route::post('genre/store', [GenreController::class, 'store']);
   Route::apiResource('genre', GenreController::class)->except('index', 'store');

   Route::post('payment', [PaymentController::class, 'index']);
   Route::post('payment/store', [PaymentController::class, 'store']);
   Route::post('payment/{uuid}/update-status', [PaymentController::class, 'changeStatusToSuccess']);
   Route::apiResource('payment', PaymentController::class)->except('index', 'store');

   Route::post('promotion', [PromotionController::class, 'index']);
   Route::post('promotion/store', [PromotionController::class, 'store'])->withoutMiddleware(['auth', 'verified']);
   Route::apiResource('promotion', PromotionController::class)->except('index', 'store');

   Route::post('review', [ReviewController::class, 'index']);
   Route::post('review/store', [ReviewController::class, 'store']);
   Route::apiResource('review', ReviewController::class)->except('index', 'store');

   Route::get('seat', [SeatController::class, 'get']);
   Route::post('seat', [SeatController::class, 'index']);
   Route::get('seat/by-studio', [SeatController::class, 'getByStudio'])->withoutMiddleware(['auth', 'verified']);
   Route::post('seat/store', [SeatController::class, 'store']);
   Route::apiResource('seat', SeatController::class)->except('index', 'store');

   Route::post('show-time', [ShowtimeController::class, 'index']);
   Route::post('show-time/store', [ShowtimeController::class, 'store']);
   Route::post('show-time/get-list', [ShowtimeController::class, 'getShowtime'])->withoutMiddleware(['auth', 'verified']);
   Route::apiResource('show-time', ShowtimeController::class)->except('index', 'store');

   Route::get('studio', [StudioController::class, 'get']);
   Route::post('studio', [StudioController::class, 'index']);
   Route::post('studio/show-seat', [StudioController::class, 'show_seat'])->withoutMiddleware(['auth', 'verified']);
   Route::post('studio/store', [StudioController::class, 'store']);
   Route::apiResource('studio', StudioController::class)->except('index', 'store');

   Route::get('role', [RoleController::class, 'get']);

   Route::get('dashboard', [DashboardController::class, 'index']);

});

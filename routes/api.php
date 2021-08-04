<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventsController;
use App\Http\Controllers\API\ProfileController;
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


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/register', [AuthController::class, "register"]);
});

Route::get('events', [EventsController::class, 'all']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, "show"]);
        Route::put('', [ProfileController::class, "update"]);
        Route::put('/password', [ProfileController::class, "updatePassword"]);
    });
    Route::prefix('client')->group(function () {
        Route::resource('/events', EventsController::class);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\StandByController;

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

Route::post('/upload', [FileUploadController::class, 'upload']);

Route::get('/events/{userId}', [EventController::class, 'index']);

Route::get('/flights-next-week/{userId}', [FlightController::class, 'next']);

Route::get('/standbys/{userId}', [StandByController::class, 'index']);

Route::get('/flights-from/{userId}/{location}', [FlightController::class, 'from']);

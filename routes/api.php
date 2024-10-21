<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserDetailController;

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

Route::post('/login', [AuthController::class, 'login']);

Route::get('/users', [UserController::class, 'getUsers']);

Route::post('/user/set-location', [UserDetailController::class, 'setUserLocation']);

Route::post('/locations', [LocationController::class, 'createLocation']);
Route::get('/locations', [LocationController::class, 'getLocations']);

Route::post('/attendances', [AttendanceController::class, 'createAttendance']);
Route::get('/attendances', [AttendanceController::class, 'getAttendance']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

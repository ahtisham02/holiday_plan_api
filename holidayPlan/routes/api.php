<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HolidayPlanController;
use App\Http\Controllers\API\AuthController;
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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    Route::get('holiday-plans', [HolidayPlanController::class, 'index']);
    Route::get('holiday-plans/{id}', [HolidayPlanController::class, 'show']);
    Route::post('holiday-plans', [HolidayPlanController::class, 'store']);
    Route::post('holiday-plans/{id}', [HolidayPlanController::class, 'update']);
    Route::delete('holiday-plans/{id}', [HolidayPlanController::class, 'destroy']);
    Route::get('holiday-plans/{id}/pdf', [HolidayPlanController::class, 'generatePdf']);
});

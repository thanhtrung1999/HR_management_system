<?php

use App\Http\Controllers\Employee\WorkScheduleController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('employee/requests/create', [\App\Http\Controllers\Employee\RequestController::class, 'storeAPI']);
Route::post('load-calendar', [WorkScheduleController::class, 'loadCalendarAPI']);
Route::post('check-in', [WorkScheduleController::class, 'checkInAPI']);
Route::post('check-out', [WorkScheduleController::class, 'checkOutAPI']);

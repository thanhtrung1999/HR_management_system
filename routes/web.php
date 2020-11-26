<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [App\Http\Controllers\AuthController::class, 'login'])->middleware('checkLogout');
Route::post('login', [App\Http\Controllers\AuthController::class, 'postLogin']);
Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout']);

// root
Route::group(['prefix' => 'root', 'middleware' => 'checkRootLogin'], function (){
    Route::resource('employees', \App\Http\Controllers\Root\EmployeeController::class)->except(['show']);
    Route::resource('departments', \App\Http\Controllers\Root\DepartmentController::class)->except(['show']);
    Route::resource('requests', \App\Http\Controllers\Root\RequestController::class);
});

// employee
Route::get('/', [\App\Http\Controllers\EmployeeController::class, 'getCalendar'])->middleware('checkEmployeeLogin');
Route::group(['prefix' => 'employee', 'middleware' => 'checkEmployeeLogin'], function (){
    Route::resource('work-schedules', \App\Http\Controllers\Employee\WorkScheduleController::class);
    Route::group(['prefix'=>'manager'], function (){
        Route::resource('employees', \App\Http\Controllers\Employee\Manager\EmployeeController::class);
        Route::resource('employees-work-schedule', \App\Http\Controllers\Employee\Manager\ManageEmployeeWorkScheduleController::class);
    });
    Route::resource('requests', \App\Http\Controllers\Employee\RequestController::class);
    Route::resource('requests-approval', \App\Http\Controllers\Employee\RequestApprovalController::class);
});

Route::get('send-email-verified-acc/{email}', [\App\Http\Controllers\MailController::class, 'sendMailVerified']);

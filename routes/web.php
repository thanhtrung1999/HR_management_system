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
Route::get('/', [\App\Http\Controllers\Employee\WorkScheduleController::class, 'index'])->middleware('checkEmployeeLogin');
Route::post('check-in', [\App\Http\Controllers\Employee\WorkScheduleController::class, 'checkIn']);
Route::post('check-out', [\App\Http\Controllers\Employee\WorkScheduleController::class, 'checkOut']);
Route::post('load-calendar', [\App\Http\Controllers\Employee\WorkScheduleController::class, 'loadCalendar']);

Route::group(['prefix' => 'employee', 'middleware' => 'checkEmployeeLogin'], function (){
    Route::group(['prefix'=>'manager'], function (){
        Route::group(['prefix'=>'employees'], function (){
            Route::get('/', [\App\Http\Controllers\Employee\Manager\EmployeeController::class, 'getEmployees'])->name('manager.listEmployees');
            Route::get('detail/{id}', [\App\Http\Controllers\Employee\Manager\EmployeeController::class, 'detailEmployee'])->name('manager.detailEmployee');
        });
        Route::resource('employees-work-schedules', \App\Http\Controllers\Employee\Manager\ManageEmployeeWorkScheduleController::class)->only([
            'index', 'show', 'destroy'
        ]);
    });
    Route::resource('requests', \App\Http\Controllers\Employee\RequestController::class)->except(['show', 'edit', 'update'])->names([
        'index' => 'employee.listRequests',
        'create' => 'employee.createRequest',
        'store' => 'employee.postCreateRequest',
        'destroy' => 'employee.cancelRequest'
    ]);
    Route::resource('profile', \App\Http\Controllers\ProfileController::class)->only(['index', 'edit', 'update']);
});

Route::get('verify-account/{id}/{token}', [\App\Http\Controllers\MailController::class, 'getFormReset'])->name('user.verify');
Route::post('reset-password/{id}/{token}', [\App\Http\Controllers\ResetPasswordController::class, 'changePassword'])->name('changePassword');

Route::post('reset-password', [\App\Http\Controllers\ResetPasswordController::class, 'resetPasswordByRoot']);
Route::get('reset-password/{id}/{token}', [\App\Http\Controllers\MailController::class, 'getFormResetByRoot'])->name('reset-password');
Route::post('send-data-reset/{id}/{token}', [\App\Http\Controllers\ResetPasswordController::class, 'sendDataResetPass'])->name('sendDataResetPass');

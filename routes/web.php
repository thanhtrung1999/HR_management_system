<?php

use App\Http\Controllers\Employee\Manager\EmployeeController;
use App\Http\Controllers\Employee\Manager\ManagedEmployeeRequestController;
use App\Http\Controllers\Employee\Manager\ManagedEmployeeWorkScheduleController;
use App\Http\Controllers\Employee\RequestController;
use App\Http\Controllers\Employee\WorkScheduleController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Root\DepartmentController;
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
Route::group(['prefix' => 'root', 'middleware' => 'checkRootLogin'], function () {
    Route::resource('employees', \App\Http\Controllers\Root\EmployeeController::class)->except(['show']);
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::group(['prefix' => 'requests'], function () {
        Route::get('/', [\App\Http\Controllers\Root\RequestController::class, 'getListRequests'])->name('root.getListRequests');
        Route::get('approval/{id}', [\App\Http\Controllers\Root\RequestController::class, 'approvalRequest'])->name('root.approvalRequest');
        Route::get('cancel/{id}', [\App\Http\Controllers\Root\RequestController::class, 'cancelRequest'])->name('root.cancelRequest');
    });
});

// employee
Route::get('/', [WorkScheduleController::class, 'index'])->middleware('checkEmployeeLogin');
Route::post('check-in', [WorkScheduleController::class, 'checkIn']);
Route::post('check-out', [WorkScheduleController::class, 'checkOut']);
Route::post('load-calendar', [WorkScheduleController::class, 'loadCalendar']);

Route::group(['prefix' => 'employee', 'middleware' => 'checkEmployeeLogin'], function () {
    Route::group(['prefix'=>'manager', 'middleware' => 'checkManager'], function () {
        Route::group(['prefix'=>'employees'], function () {
            Route::get('/', [EmployeeController::class, 'getEmployees'])->name('manager.listEmployees');
            Route::get('detail/{id}', [EmployeeController::class, 'detailEmployee'])->name('manager.detailEmployee');
            Route::get('export', [EmployeeController::class, 'exportEmployee'])->name('manager.exportEmployee');
        });
        Route::group(['prefix'=>'employees-work-schedules'], function () {
            Route::get('/', [ManagedEmployeeWorkScheduleController::class, 'getEmployeesWorkSchedule'])->name('manager.getWorkSchedule');
            Route::get('detail/{id}', [ManagedEmployeeWorkScheduleController::class, 'getDetailWorkScheduleOfEmployee'])->name('manager.getDetailWorkSchedule');
            Route::get('export', [ManagedEmployeeWorkScheduleController::class, 'exportTimeSheetEmployees'])->name('manager.exportTimeSheetEmployees');
        });
        Route::group(['prefix' => 'requests'], function () {
            Route::get('/', [ManagedEmployeeRequestController::class, 'getListRequests'])->name('manager.getListRequests');
            Route::get('approval/{id}', [ManagedEmployeeRequestController::class, 'approvalRequest'])->name('manager.approvalRequest');
            Route::get('cancel/{id}', [ManagedEmployeeRequestController::class, 'cancelRequest'])->name('manager.cancelRequest');
        });
    });
    Route::resource('requests', RequestController::class)->except(['show', 'edit', 'update'])->names([
        'index' => 'employee.listRequests',
        'create' => 'employee.createRequest',
        'store' => 'employee.postCreateRequest',
        'destroy' => 'employee.cancelRequest'
    ]);
    Route::resource('profile', ProfileController::class)->only(['index', 'edit', 'update']);
});

Route::get('verify-account/{id}/{token}', [MailController::class, 'getFormReset'])->name('user.verify');
Route::post('verify-account/{id}/{token}', [ResetPasswordController::class, 'changePassword'])->name('changePassword');

Route::post('reset-password', [ResetPasswordController::class, 'resetPasswordByRoot']);
Route::get('reset-password/{id}/{token}', [MailController::class, 'getFormResetByRoot'])->name('reset-password');
Route::post('send-data-reset/{id}/{token}', [ResetPasswordController::class, 'sendDataResetPass'])->name('sendDataResetPass');
Route::get('test-url', function (){
    echo "Test";
});

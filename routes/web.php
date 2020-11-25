<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RootController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('login', [App\Http\Controllers\LoginController::class, 'login'])->middleware('checkLogout');
Route::post('login', [App\Http\Controllers\LoginController::class, 'postLogin']);
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout']);

Route::group(['prefix' => 'root', 'middleware' => 'checkRootLogin'], function (){
    Route::group(['prefix' => 'employees'], function (){
        Route::get('/', [RootController::class, 'employees']);
        Route::get('create', [RootController::class, 'createEmployee'])->name('createEmployee');
        Route::post('create', [RootController::class, 'postCreateEmployee'])->name('postCreateEmployee');
        Route::get('update/{id}', [RootController::class, 'updateEmployee'])->name('updateEmployee');
        Route::post('update/{id}', [RootController::class, 'postUpdateEmployee'])->name('postUpdateEmployee');
        Route::get('delete/{id}', [RootController::class, 'deleteEmployee'])->name('deleteEmployee');
    });
    Route::group(['prefix' => 'departments'], function (){
        Route::get('/', [RootController::class, 'departments']);
        Route::get('create', [RootController::class, 'createDepartment'])->name('createDepartment');
        Route::get('get-create', [RootController::class, 'getCreateDepartment'])->name('getCreateDepartment');
        Route::get('update/{id}', [RootController::class, 'updateDepartment'])->name('updateDepartment');
        Route::post('update/{id}', [RootController::class, 'postUpdateDepartment'])->name('postUpdateDepartment');
        Route::get('delete/{id}', [RootController::class, 'deleteDepartment'])->name('deleteDepartment');
    });
    Route::get('requests', [RootController::class, 'requests']);
});

Route::get('/', [\App\Http\Controllers\EmployeeController::class, 'getCalendar'])->middleware('checkEmployeeLogin');
Route::group(['prefix' => 'employee', 'middleware' => 'checkEmployeeLogin'], function (){
    Route::group(['prefix'=>'manager'], function (){
        Route::group(['prefix'=>'employees'], function (){
            Route::get('/', [\App\Http\Controllers\EmployeeController::class, 'getEmployees'])->name('list-employees');
            Route::get('working-schedule', [\App\Http\Controllers\EmployeeController::class, 'getWorkingSchedule'])->name('working-schedule');
        });
    });
    Route::group(['prefix'=>'requests'], function(){
        Route::get('/', [\App\Http\Controllers\EmployeeController::class, 'getRequests']);
    });
    Route::get('requests-approval', [\App\Http\Controllers\EmployeeController::class, 'getRequestsApproval']);
});

Route::get('send-email-verified-acc/{email}', [\App\Http\Controllers\MailController::class, 'sendMailVerified']);

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
Route::get('login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('login', [App\Http\Controllers\LoginController::class, 'postLogin']);
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout']);

Route::group(['prefix' => 'root'], function (){
    Route::group(['prefix' => 'employees'], function (){
        Route::get('/', [RootController::class, 'employees']);
        Route::get('create', [RootController::class, 'createEmployee']);
        Route::get('update', [RootController::class, 'updateEmployee']);
    });
    Route::group(['prefix' => 'departments'], function (){
        Route::get('/', [RootController::class, 'departments']);
        Route::get('create', [RootController::class, 'createDepartment']);
        Route::get('update', [RootController::class, 'updateDepartment']);
    });
    Route::get('requests', [RootController::class, 'requests']);
});

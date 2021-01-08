<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthenticationController;

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
Route::get('', function () {
    return 'successfull';
});

Route::resource('users', 'UserController');
Route::resource('tasks', 'TaskController');
Route::resource('items', 'ItemController');
Route::resource('reports', 'ReportController');
Route::post('login', 'AuthenticationController@Login');
Route::put('changePassword', 'UserController@changePassword');

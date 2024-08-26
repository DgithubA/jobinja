<?php

use App\Http\Controllers\API\Auth\UsersAuthController;
use Illuminate\Support\Facades\Route;

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


Route::group(['prefix' => 'v1'], function () {

    Route::resource('Users', '\App\Http\Controllers\API\UserController')->middleware('auth:custom-header');
    Route::resource('Posts', '\App\Http\Controllers\API\PostController')->middleware('auth:custom-header');
    Route::resource('Resoums', '\App\Http\Controllers\API\ResoumController')->middleware('auth:custom-header');

    Route::controller(UsersAuthController::class)->group(function () {
        Route::post('Users/login', 'login')->name('user-login');
        Route::post('Users/register', 'register');
        Route::post('Users/logout', 'logout');
        Route::post('Users/refresh', 'refresh');
    })->middleware('auth:custom-header');
});

Route::get('/test','\App\Http\Controllers\API\UserController@test');

/*
Route::controller(AdminsAuthController::class)->group(function () {
    Route::post('Admins/login', 'login')->name('admin-login');
    Route::post('Admins/register', 'register');
    Route::post('Admins/logout', 'logout');
    Route::post('Admins/refresh', 'refresh');
});
*/






<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [\App\Http\Controllers\API\UserController::class,'usersform']);


Route::any('/test', function () {
    $user_resoum = \App\Models\UserResoum::findorfail(1);
    $public = $user_resoum->public;
    $user_resoum->update(['public' => "true"]);
    dd("ok");
})->name('test');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

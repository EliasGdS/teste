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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\UserController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/users/get-users', [App\Http\Controllers\UserController::class, 'getUsers'])->name('users.get-users');
    Route::get('/users/get-user', [App\Http\Controllers\UserController::class, 'getUser'])->name('users.get-user');
    Route::resource('/users', App\Http\Controllers\UserController::class)->names('users');
});

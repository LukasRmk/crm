<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
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

Route::resource("/", ClientController::class)->middleware("auth");
Route::resource("home", ClientController::class)->middleware("auth");
Route::resource("clients", ClientController::class)->middleware("auth");
Route::put('/tasks/storeComment', [TaskController::class, 'storeComment'])->name('storeComment')->middleware("auth");
Route::delete('/tasks/destroyComment/{comment}', [TaskController::class, 'destroyComment'])->name('destroyComment')->middleware("auth");
Route::resource('tasks', TaskController::class)->middleware("auth");
Route::resource('user', UserController::class)->middleware("auth");
Route::resource('contacts', ContactController::class)->middleware("auth");

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WindowController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\MotivationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
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

Route::resource("/", DashboardController::class)->middleware("auth");
Route::resource("/home", DashboardController::class)->middleware("auth");
Route::resource("dashboard", DashboardController::class)->middleware("auth");
Route::resource("clients", ClientController::class)->middleware("auth");
Route::put('/tasks/storeComment', [TaskController::class, 'storeComment'])->name('storeComment')->middleware("auth");
Route::delete('/tasks/destroyComment/{comment}', [TaskController::class, 'destroyComment'])->name('destroyComment')->middleware("auth");
Route::resource('tasks', TaskController::class)->middleware("auth");
Route::resource('user', UserController::class)->middleware("auth");
Route::resource('users', UserController::class)->middleware("auth");
Route::get('/adminEdit/{user}', [ 'as' => 'users.adminEdit', 'uses' => 'App\Http\Controllers\UserController@adminEdit']);
//Route::put('/users/adminUpdate', [ 'as' => 'users.adminUpdate', 'uses' => 'App\Http\Controllers\UserController@adminUpdate']);
//Route::put('/users/adminUpdate', [UserController::class, 'adminUpdate'])->name('adminUpdate')->middleware("auth");
Route::resource('organizations', OrganizationController::class)->middleware("auth");
Route::resource('contacts', ContactController::class)->middleware("auth");
Route::resource('windows', WindowController::class)->middleware("auth");
Route::resource('stages', StageController::class)->middleware("auth");
Route::resource('sales', SalesController::class)->middleware("auth");
Route::resource('motivation', MotivationController::class)->middleware("auth");
Route::get('stages/updateStageOrder/{order}', [StageController::class, 'updateStageOrder'])->name('updateStageOrder')->middleware("auth");
Route::get('sales/getSalesWindow/{window}/{seller}', [SalesController::class, 'getSalesWindow'])->name('getSalesWindow')->middleware("auth");
Route::get('sales/setNewStage/{sale}/{stage}', [SalesController::class, 'setNewStage'])->name('setNewStage')->middleware("auth");
Route::get('sales/setNewOrder/{order}', [SalesController::class, 'setNewOrder'])->name('setNewOrder')->middleware("auth");
Route::get('sales/setStatus/{status}/{sale}', [SalesController::class, 'setStatus'])->name('setStatus')->middleware("auth");
Route::get('motivation/showResults/{period}/{customFrom}/{customTo}', [MotivationController::class, 'showResults'])->name('showResults')->middleware("auth");

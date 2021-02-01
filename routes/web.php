<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/management/users/all', [App\Http\Controllers\UserController::class ,'Fetch']);
Route::post('/management/users/search', [App\Http\Controllers\UserController::class ,'search']);
Route::post('/management/users/create', [App\Http\Controllers\UserController::class ,'create']);
Route::post('/management/users/update/{id}' , [App\Http\Controllers\UserController::class ,'update']);
Route::post('/management/users/delete/{id}' , [App\Http\Controllers\UserController::class ,'delete']);

Route::get('/management/users/confirm/{id}', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(500);
    }
})->name('confirm');

Route::post('/management/users/confirm/{id}', [App\Http\Controllers\UserController::class, 'confirm'])->name('confirm')->middleware('confirm');
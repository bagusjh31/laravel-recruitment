<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\JobStatusController;

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

/**
 * route resource user
 */
Route::resource('/user', UserController::class);
Route::resource('/profile', ProfileController::class);
Route::resource('/job', VacancyController::class);
Route::resource('/status', JobStatusController::class);
Route::post('/login', [UserController::class, 'login']);
Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {
    // manggil controller sesuai bawaan laravel 8
    Route::post('logout', [UserController::class, 'logout']);
    // manggil controller dengan mengubah namespace di RouteServiceProvider.php biar bisa kayak versi2 sebelumnya
    Route::post('logoutall', 'UserController@logoutall');
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('check-auth', [AuthController::class, 'checkAuth'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::post('checkLoggedIn', [AuthController::class, 'checkAuth']);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/UserNews', [NewsController::class, 'UserFavNews']);
    Route::post('/data', [NewsController::class, 'fetchAllNewsSources']);
    Route::post('/update-fav', [NewsController::class, 'saveFavoriteTopics']);
    Route::get('/test', [NewsController::class, 'saveFavoriteTopics']);

});

Route::get('/test', [NewsController::class, 'test']);


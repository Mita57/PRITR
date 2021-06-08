<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextController;

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

Route::prefix('/text')->group(function () {
    Route::get('/getRandom', [TextController::class, 'index']);
    Route::post('/postText', [TextController::class, 'store']);
    Route::put('{id}', [TextController::class, 'update']);
    Route::delete('{id}', [TextController::class, 'destroy']);
    Route::get('/show/{id}', [TextController::class, 'show']);
});




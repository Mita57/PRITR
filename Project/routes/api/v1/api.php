<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextController;
use App\Http\Controllers\GameController;

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

Route::prefix('/defaultRace')->group(function () {
    Route::get('/getRace', [GameController::class, 'index']);
    Route::post('/startGame', [GameController::class, 'startGame']);
    Route::post('/joinGame', [GameController::class, 'join_game'])->middleware('auth:api');
    Route::get('/getGameMembers', [GameController::class, 'get_game_members']);
    Route::post('/postTextData', [GameController::class, 'post_text_data'])->middleware('auth:api');
    Route::post('/gameFinal', [GameController::class, 'game_final'])->middleware('auth:api');

});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'AuthController@logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');





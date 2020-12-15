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
    return view('landing');
});

Route::get('/classic', 'Controller@classic');

Route::get('/arena', 'Controller@arena');

Route::get('/classic', 'Controller@classic');

Route::get('/practice', 'Controller@practice');

Route::get('/royale', 'Controller@royale');

Route::get('/user', 'Controller@user');

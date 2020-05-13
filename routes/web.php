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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/2fa', 'TwoFactorAuthenticationController@get');
    Route::post('/2fa', 'TwoFactorAuthenticationController@post');
 
    Route::group(['middleware' => 'auth.duo'], function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });
});

Auth::routes();




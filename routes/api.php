<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'App\Http\Controllers\UserController@login');
    // Route::post('/register', 'App\Http\Controllers\UserController@register');
    Route::post('/getcoapendapatan', 'App\Http\Controllers\JurnalController@getcoa');
    //Route::post('/storejurnal', 'App\Http\Controllers\JurnalController@store');

    Route::post('/storependapatan', 'App\Http\Controllers\JurnalController@storependapatan');
    Route::post('/updatependapatan', 'App\Http\Controllers\JurnalController@updatependapatan');
    Route::post('/storepencairandana', 'App\Http\Controllers\JurnalController@storepencairandana');
    Route::post('/updatepencairandana', 'App\Http\Controllers\JurnalController@updatepencairandana');

    Route::post('/storepjkpencairandana', 'App\Http\Controllers\JurnalController@storepjkpencairandana');
    Route::post('/updatepjkpencairandana', 'App\Http\Controllers\JurnalController@updatepjkpencairandana');

    Route::post('/storeaccrumhs', 'App\Http\Controllers\JurnalController@storeaccrumhs');
    Route::post('/updateaccrumhs', 'App\Http\Controllers\JurnalController@updateaccrumhs');

    Route::post('/storepelunassanaccrumhs', 'App\Http\Controllers\JurnalController@storepelunassanaccrumhs');
    Route::post('/updatepelunassanaccrumhs', 'App\Http\Controllers\JurnalController@updatepelunassanaccrumhs');
});
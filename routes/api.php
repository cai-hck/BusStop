<?php

use Illuminate\Http\Request;

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
Route::get('/login/{id}', 'ApiController@login');
Route::get('/token/{id}/{token}', 'ApiController@token');
Route::get('/getbusstops', 'ApiController@getbusstops');
Route::get('/getbusstop/{id}', 'ApiController@getbusstop');
Route::get('/getbusinfo/{id}', 'ApiController@getbusinfo');
Route::post('/givelocation', 'ApiController@givelocation');
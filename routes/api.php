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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('locations', 'API\loctionController@index');
Route::middleware('auth:api')->get('profile', 'API\UserController@profile');

Route::middleware('auth:api')->get('locations','API\LocationController@index');
Route::middleware('auth:api')->get('locations/{id}','API\LocationController@show');
Route::middleware('auth:api')->post('locations','API\LocationController@create');
Route::middleware('auth:api')->delete('locations/{id}', 'API\LocationController@delete');

Route::middleware('auth:api')->post('vote', 'API\VoteController@create');
Route::get('vote/{location_id}', 'API\VoteController@get');
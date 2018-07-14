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

Route::get('/users/all', 'UserController@index');
Route::post('/create_account', 'UserController@store');
Route::post('/create_account_pemilik_kos', 'UserController@store_pemilik_kos');
Route::post('/login', 'UserController@login');

Route::get('/kost/user', 'KostController@show')->middleware('auth:api', 'pemilik_kost');
Route::get('/kost/all', 'KostController@index')->middleware('auth:api');
Route::get('/kost/all/detail', 'KostController@detail')->middleware('auth:api');
Route::post('/kost/{id}/create', 'KostController@create');
Route::delete('/kost/{id}', 'KostController@delete');

Route::get('/room/all', 'RoomController@index');
Route::post('room/{id}/create', 'RoomController@create');
Route::delete('/room/{id}', 'RoomController@delete');

Route::get('/book/all', 'BookSurveyController@index');
Route::post('/user/{user_id}/book', 'BookSurveyController@book');

Route::get('/reset', 'UserController@reset_api');

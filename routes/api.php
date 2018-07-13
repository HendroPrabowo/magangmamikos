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

Route::get('/kost/all', 'KostController@index');
Route::get('/kost/all/detail', 'KostController@detail');
Route::post('/kost/{id}/create', 'KostController@create');
Route::delete('/kost/{id}', 'KostController@delete');

Route::get('/room/all', 'RoomController@index');
Route::post('room/{id}/create', 'RoomController@create');
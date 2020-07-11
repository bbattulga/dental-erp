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


Route::post('/test', 'ReceptionTimeController@test');

///////////// USERS ///////////////////////

/////////////// RECEPTION START ///////////////////
Route::get('reception/time/{date?}', 'ReceptionTimeController@index'); 
Route::post('reception/time/create', 'ReceptionTimeController@store');
Route::get('reception/time/{id}', 'ReceptionTimeController@show');
Route::put('reception/time/update', 'ReceptionTimeController@update');
Route::delete('reception/time/delete/{id}', 'ReceptionTimeController@destroy');

Route::post('reception/doctors', 'ReceptionTimeController@api_doctors');

Route::get('reception/time/{date1}/{date2}/{doctor_id}', 'ReceptionTimeController@api_shifts_interval');

Route::post('reception/sameusers', 'UserController@query');
Route::post('reception/doctors/{id?}', 'ReceptionTimeController@api_doctors');
Route::post('reception/sameusers', 'UserController@query');

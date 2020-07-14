<?php

//////////////// API START //////////////////

// only authorized users can access the api

/*
the reason why it is called webapi is 
it is essentially web.php but act like an api.

it is simpler than api_token e.t.c
and fits with the legacy code
*/

/////// NOTICE THE PREFIXES OF ROUTE GROUPS

/////  GENERAL START /////


$namespace = 'Api';

Route::group(['namespace' => $namespace,'prefix'=>'/api/'],function(){

    Route::post('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::post('user/create', 'UserController@store');
    Route::put('user/update', 'UserController@update');
    Route::delete('user/delete/{id}', 'UserController@destroy');

    Route::post('user/query', 'UserController@query');
});

///// GENERAL END


// ADMIN API

Route::group(['namespace' => $namespace,'prefix'=>'/api/admin'],function(){
    Route::get('/', 'AdminTreatmentController@test');
});

// RECEPTION API
Route::group(['namespace' => $namespace, 'prefix'=>'/api/reception'],function(){

    Route::get('time', 'AppointmentController@index');
    Route::get('time/{id}', 'AppointmentController@show');
    Route::post('time/create', 'AppointmentController@store');
    Route::put('time/update', 'AppointmentController@update');
    Route::delete('time/delete/{id}', 'AppointmentController@destroy');
    Route::post('time/cancel', 'AppointmentController@cancel');

    Route::get('time/date/today', 'AppointmentController@today');
    Route::get('time/date/{date}', 'AppointmentController@showDate');
    Route::post('time/date/datebetween', 'AppointmentController@showDateBetween');

    Route::post('doctors', 'DoctorController@index');

}); // END RECEPTON API

// DOCTOR API
Route::group(['namespace' => $namespace, 'prefix'=>'/api/doctor'],function(){
    Route::get('/', function(){
        return 'api test index web.php';
    });

}); // END DOCTOR API

// ACCOUNTANT API
Route::group(['namespace' => $namespace, 'prefix'=>'/api/accountant'],function(){
    Route::get('/', function(){
        return 'api test index web.php';
    });

}); // END ACCOUNTANT API

///////////////// API END /////////////////////
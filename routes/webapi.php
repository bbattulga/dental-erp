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

// ADMIN API
Route::group(['prefix'=>'/api/admin'],function(){
    Route::get('/', 'AdminTreatmentController@test');
});

// RECEPTION API
Route::group(['prefix'=>'/api/reception'],function(){

    Route::get('/', 'ReceptionTimeController@index');
    Route::get('time/{date?}', 'ReceptionTimeController@index');
    Route::post('time/create', 'ReceptionTimeController@store');
    Route::get('time/{id}', 'ReceptionTimeController@show');
    Route::put('time/update', 'ReceptionTimeController@update');
    Route::delete('time/delete/{id}', 'ReceptionTimeController@destroy');

    Route::post('doctors', 'ReceptionTimeController@api_doctors');

    Route::get('time/{date1}/{date2}/{doctor_id}', 'ReceptionTimeController@api_shifts_interval');

    Route::post('doctors/{id?}', 'ReceptionTimeController@api_doctors');
    Route::post('sameusers', 'ReceptionTimeController@queryUser');

}); // END RECEPTON API

// DOCTOR API
Route::group(['prefix'=>'/api/doctor'],function(){
    Route::get('/', function(){
        return 'api test index web.php';
    });

}); // END DOCTOR API

// ACCOUNTANT API
Route::group(['prefix'=>'/api/accountant'],function(){
    Route::get('/', function(){
        return 'api test index web.php';
    });

}); // END ACCOUNTANT API

///////////////// API END /////////////////////
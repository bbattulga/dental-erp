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
// $api_prefix = '/api/';

// ACCESSIBLE TO ANYONE
Route::group(['middleware' => 'auth',
            'namespace' => $namespace,
            'prefix'=>'/api/'],function(){
});

Route::group(['middleware' => 'reception',
            'namespace' => $namespace,
            'prefix'=>'/api/'],function(){

    
});

///// GENERAL end(array)


// ADMIN API
Route::group(['middleware' => 'admin',
            'namespace' => $namespace,
            'prefix'=>'/api/'], function(){

    // treatment
    Route::get('treatments', 'TreatmentController@index');
    Route::get('treatments/{id}', 'TreatmentController@show');
    Route::post('treatments/create', 'TreatmentController@store');
    Route::put('treatments/update', 'TreatmentController@update');
    Route::delete('treatments/delete/{id}', 'TreatmentController@destroy');

    //treatments selection
    Route::get('treatments-selection', 'TreatmentSelectionController@index');
    Route::get('treatments-selection/{id}', 'TreatmentSelectionController@show');
    Route::post('treatments-selection/create', 'TreatmentSelectionController@store');
    Route::put('treatments-selection/update', 'TreatmentSelectionController@update');
    Route::delete('treatments-selection/delete/{id}', 'TreatmentSelectionController@destroy');

}); // ADMIN API END

// RECEPTION API
Route::group(['middleware'=>'reception',
            'namespace' => $namespace, 
            'prefix'=>'/api/'],function(){

    Route::get('appointments', 'AppointmentController@index');
    Route::get('appointments/{id}', 'AppointmentController@show');
    Route::post('appointments/create', 'AppointmentController@store');
    Route::put('appointments/update', 'AppointmentController@update');
    Route::delete('appointments/delete/{id}', 'AppointmentController@destroy');
    Route::post('appointments/cancel', 'AppointmentController@cancel');

    Route::get('appointments/date/today', 'AppointmentController@today');
    Route::get('appointments/date/{date}', 'AppointmentController@showDate');
    Route::post('appointments/date/datebetween', 'AppointmentController@showDateBetween');

    Route::get('checkins', 'CheckInController@index');
    Route::get('checkins/{id}', 'CheckInController@show');
    Route::post('checkins/create', 'CheckInController@store');
    Route::put('checkins/update', 'CheckInController@update');
    Route::delete('checkins/delete/{id}', 'CheckInController@destroy');

    Route::post('doctors', 'DoctorController@index');

    Route::get('shifts', 'ShiftController@index');
    Route::get('shifts/{id}', 'ShiftController@show');
    Route::post('shifts/create', 'ShiftController@store');
    Route::put('shifts/update', 'ShiftController@update');
    Route::delete('shifts/delete/{id}', 'ShiftController@destroy');
    Route::get('shifts/date/today', 'ShiftController@today');
    Route::get('shifts/date/{date}', 'ShiftController@showDate');
    Route::post('shifts/date/datebetween', 'ShiftController@showDateBetween');
    
    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::post('users/create', 'UserController@store');
    Route::put('users/update', 'UserController@update');
    Route::delete('users/delete/{id}', 'UserController@destroy');
    Route::post('users/query', 'UserController@query');
}); // END RECEPTON API

// DOCTOR API
Route::group(['namespace' => $namespace, 'prefix'=>'/api/'],function(){
    
    Route::get('user-treatments', 'UserTreatmentController@index');
    Route::get('user-treatments/{id}', 'UserTreatmentController@show');
    Route::post('user-treatments/create', 'UserTreatmentController@store');
    Route::put('user-treatments/update', 'UserTreatmentController@update');
    Route::delete('user-treatments/delete/{id}', 'UserTreatmentController@destroy');
}); // END DOCTOR API

// ACCOUNTANT API
Route::group(['namespace' => $namespace, 'prefix'=>'/api/accountant'],function(){
    Route::get('/', function(){
        return 'api test index web.php';
    });

}); // END ACCOUNTANT API

///////////////// API END /////////////////////
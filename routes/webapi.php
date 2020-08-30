<?php

//////////////// API START //////////////////

// only authenticated users can access the api

/*
the reason why it is called webapi is 
it is essentially web.php but act like an api.

it is simpler than api_token e.t.c
and fits the legacy code
*/

/////// NOTICE THE PREFIXES OF ROUTE GROUPS

/////  GENERAL START /////


$namespace = 'Api';
// $api_prefix = '/api/';

// ACCESSIBLE TO AUTHENTiCATED
Route::group(['middleware' => 'auth',
            'namespace' => $namespace,
            'prefix'=>'/api/'],function(){

        // auth middleware has bug.
});

// ADMIN API
Route::group(['middleware' => 'admin',
            'namespace' => $namespace,
            'prefix'=>'/api/'], function(){

    // treatment
    Route::post('treatments/create', 'TreatmentController@store');
    Route::put('treatments/update', 'TreatmentController@update');
    Route::delete('treatments/delete/{id}', 'TreatmentController@destroy');

    //treatments selection
    Route::post('treatments-selections/create', 'TreatmentSelectionController@store');
    Route::put('treatments-selections/update', 'TreatmentSelectionController@update');
    Route::delete('treatments-selections/delete/{id}', 'TreatmentSelectionController@destroy');

    Route::get('tailan/treatments', 'TreatmentTailanController@index');
    Route::get('tailan/treatments/{category_id}/{start_date}/{end_date}', 'TreatmentTailanController@test');
    Route::post('tailan/treatments/month', 'TreatmentTailanController@showMonth');
    Route::post('tailan/treatments/datebetween', 'TreatmentTailanController@showDateBetween');

}); // ADMIN API END

// DOCTOR API
Route::group([ 'middleware' => 'doctor',
            'namespace' => $namespace, 
            'prefix'=>'/api/'],function(){
    
    Route::post('treatment-categories', 'TreatmentCategoryController@index');
    Route::get('treatment-categories/treatments/{id}', 'TreatmentCategoryController@withTreatments');

    Route::post('treatments', 'TreatmentController@index');
    Route::get('treatments/{id}', 'TreatmentController@show');
    Route::get('treatments/category/{id}', 'TreatmentController@showByCategory');

    Route::post('treatments-selections', 'TreatmentSelectionController@index');
    Route::get('treatments-selections/{id}', 'TreatmentSelectionController@show');
    
    Route::get('user-treatment', 'UserTreatmentController@index');
    Route::get('user-treatment/{id}', 'UserTreatmentController@show');
    Route::post('user-treatment/query', 'UserTreatmentController@query');
    Route::post('user-treatment/create', 'UserTreatmentController@store');
    Route::post('user-treatment/update', 'UserTreatmentController@update');
    Route::delete('user-treatment/delete/{id}', 'UserTreatmentController@destroy');

    Route::put('user-treatment/finish', 'UserTreatmentController@finish');

    Route::post('xray', 'UserTreatmentController@xray');
    Route::post('xray/create', 'UserTreatmentController@xrayStore');
    Route::delete('xray/delete/{id}', 'UserTreatmentController@xrayDestroy');

    Route::post('user-tooth', 'UserToothController@index');
    Route::get('user-tooth/{id}', 'UserToothController@show');
    Route::post('user-tooth/create', 'UserToothController@store');
    Route::put('user-tooth/update', 'UserToothController@update');
    Route::delete('user-tooth/delete/{id}', 'UserToothController@destroy');
    Route::delete('user-tooth/{user_id}/delete/{tooth_code}', 'UserToothController@destroByUserTooth'); 

    Route::get('paint', 'PaintController@index');
    Route::post('paint/user', 'PaintController@show');
    Route::post('paint/create', 'PaintController@store');
    Route::put('paint/update', 'PaintController@update');
    Route::delete('paint/delete/{id}', 'PaintController@destroy');

}); // END DOCTOR API

// RECEPTION API
Route::group(['middleware'=>'reception',
            'namespace' => $namespace, 
            'prefix'=>'/api/'],function(){

    Route::post('doctors', 'DoctorController@index');

    Route::post('appointments', 'AppointmentController@index');
    Route::get('appointments/{id}', 'AppointmentController@show');
    Route::post('appointments/create', 'AppointmentController@store');
    Route::put('appointments/update', 'AppointmentController@update');
    Route::delete('appointments/delete/{id}', 'AppointmentController@destroy');
    Route::post('appointments/cancel', 'AppointmentController@cancel');

    Route::get('appointments/date/today', 'AppointmentController@today');
    Route::get('appointments/date/{date}', 'AppointmentController@showDate');
    Route::post('appointments/date/datebetween', 'AppointmentController@showDateBetween');

    Route::post('checkins', 'CheckInController@index');
    Route::get('checkins/{id}', 'CheckInController@show');
    Route::post('checkins/create', 'CheckInController@store');
    Route::put('checkins/update', 'CheckInController@update');
    Route::delete('checkins/delete/{id}', 'CheckInController@destroy');

    Route::post('shifts', 'ShiftController@index');
    Route::get('shifts/{id}', 'ShiftController@show');
    Route::post('shifts/create', 'ShiftController@store');
    Route::put('shifts/update', 'ShiftController@update');
    Route::delete('shifts/delete/{id}', 'ShiftController@destroy');
    Route::get('shifts/date/today', 'ShiftController@today');
    Route::get('shifts/date/{date}', 'ShiftController@showDate');
    Route::post('shifts/date/datebetween', 'ShiftController@showDateBetween');

    Route::get('shifts/types/all', 'ShiftController@showShiftTypes');
    Route::get('shifts/types/{id}', 'ShiftController@showShiftType');

    Route::post('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::post('users/create', 'UserController@store');
    Route::put('users/update', 'UserController@update');
    Route::delete('users/delete/{id}', 'UserController@destroy');
    Route::post('patients/query', 'UserController@queryPatient');

    Route::post('promotions', 'PromotionController@index');
    Route::get('promotions/{id}', 'PromotionController@show');
    Route::get('promotions/code/{code}', 'PromotionController@showByCode');

    Route::post('promotions/create', 'PromotionController@store');
    Route::put('promotions/update', 'PromotionController@update');
    Route::delete('promotions/delete/{id}', 'PromotionController@destroy');

}); // END RECEPTON API

// ACCOUNTANT API
Route::group([ 'middleware' => 'accountant',
            'namespace' => $namespace, 
            'prefix'=>'/api/accountant'],function(){
    Route::get('/', function(){
        return 'api test index web.php';
    });

}); // END ACCOUNTANT API

///////////////// API END /////////////////////
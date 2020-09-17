<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', 'ReceptionShiftsController@index');


////////////// WEB ROUTES START ////////
Route::get('/', function () {
	return redirect('/login');
});
Route::get('emchilgeenuud', function () {
    return view('emchilgeenuud');
});
Route::get('huuhdiinemchilgee', function () {
    return view('huuhdiinemchilgee');
});
Route::get('adulttreatment', function () {
    return view('adulttreatment');
});
Route::get('emchilge', function () {
    return view('emchilge');
});
Route::get('mesemchilgee', function () {
    return view('mesemchilgee');
});

Route::get('/time', function () {
    return view('admin.time');
});
Route::get('/user','UserController@index')->name('user');

Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');  


//--ADMIN STARTING--
// contollers have admin middleware
Route::group(['prefix' => '/admin'], function() {

	Route::get('dashboard', 'AdminController@dashboard')->name('dash');
	Route::get('dashboard/{date1}/{date2}', 'AdminController@show_between');
	Route::get('shifts', 'AdminTimeController@index');

	Route::get('add_staff/{id}/profile', 'AdminController@profile');
	Route::get('add_staff/fire/{id}','AdminController@fire');
	Route::get('add_staff/edit/{id}','AdminStaffController@edit');
	Route::get('add_staff','AdminController@index');
	Route::post('add_staff','AdminController@add_staff');
	Route::post('update_staff','AdminStaffController@update');
	Route::get('staff_check/{id}/{start_date}/{end_date}', 'AdminStaffController@search');
	Route::post('staff/by_month', 'AdminStaffController@by_month');
	Route::post('staff/date', 'AdminStaffController@date');

	// for ajax
	Route::delete('staff/delete', 'AdminStaffController@delete');

	Route::get('promotion','AdminPromotionController@index');
	Route::post('promotion/add','AdminPromotionController@store');
	Route::get('promotion_check/{id}','AdminPromotionController@promotion_check');
	Route::get('promotion_edit_index/{id}','AdminPromotionController@promotion_edit_index');
	Route::post('promotion_edit_index/{id}','AdminPromotionController@promotion_edit_index');
	Route::get('promotion_edit/{id}','AdminPromotionController@promotion_edit');
	Route::post('promotion_edit/{id}','AdminPromotionController@promotion_edit');

	Route::get('product','AdminProductController@product');
	Route::get('product/{id}','AdminProductController@show');
	Route::post('add_product','AdminProductController@add_product');
	Route::post('edit_product','AdminProductController@edit_product');
	Route::post('decrease_product','AdminProductController@decrease_product');
	Route::get('delete_product/{id}','AdminProductController@delete_product');

	Route::get('time', 'AdminTimeController@time');
	Route::get('time/{i}/{doctor_staff_id}/{shift_id}','AdminTimeController@store');
	Route::get('time/week/{id}', 'AdminTimeController@timeWeek');
	Route::post('time/add', 'AdminTimeController@storeAppointment');
	Route::get('time/cancel','AdminTimeController@cancelAppointment');

	Route::post('transaction/date', 'AdminTransactionController@date');
	Route::get('transaction', 'AdminTransactionController@index');
	Route::get('transaction/{start_date}/{end_date}', 'AdminTransactionController@search');
	Route::post('transaction/by_month','AdminTransactionController@by_month');

	Route::post('transactions/salary', 'AdminTransactionController@salary');
	Route::post('transactions/add', 'AdminTransactionController@store');
	Route::post('transactions/income', 'AdminTransactionController@income');
	Route::post('transactions/outcome/type', 'AdminTransactionController@outcomeCategory');

	Route::get('hospital','AdminHospitalController@index');
	Route::get('hospital/{from}/{to}', 'AdminHospitalController@date');
	Route::post('hospital/by_month','AdminHospitalController@by_month');
	Route::post('hospital/by_date','AdminHospitalController@by_date');

	Route::get('logs','AdminController@logs');
	Route::get('users','AdminController@users');
	Route::get('user_check/{id}','AdminController@user_check');
	Route::get('search', 'AdminController@search');

	Route::get('treatment', 'AdminTreatmentController@index');
	Route::post('treatment/store', 'AdminTreatmentController@store');
	Route::post('treatment/storeTreatmentSelection', 'AdminTreatmentController@storeTreatmentSelection');
	Route::post('treatment/updateTreatmentSelection', 'AdminTreatmentController@updateTreatmentSelection');
	Route::post('treatment/update', 'AdminTreatmentController@update');
	Route::get('treatment/{id}', 'AdminTreatmentController@edit');
	Route::get('treatment/{id}/{s_id}', 'AdminTreatmentController@editTreatmentSelection');
});

//--ACCOUNTANT STARTING--

Route::group(['prefix'=>'/accountant'], function(){

	// /acountant/transactions
	Route::group(['prefix'=>'transactions'], function(){
		Route::post('date', 'AccountantTransactionController@date');
		Route::get('', 'AccountantTransactionController@index');
		Route::post('edit', 'AccountantTransactionController@edit');
		Route::post('delete','AccountantTransactionController@delete');
		Route::get('{start_date}/{end_date}', 'AccountantTransactionController@search');
		Route::post('by_month','AccountantTransactionController@by_month');

		Route::post('salary', 'AccountantTransactionController@salary');
		Route::post('add', 'AccountantTransactionController@store');
		Route::post('income', 'AccountantTransactionController@income');
		Route::post('outcome/type', 'AccountantTransactionController@outcomeCategory');
	});

	// /accountant/products
	Route::group(['prefix'=>'products'], function(){
		Route::get('','AccountantProductController@product');
		Route::get('{id}','AccountantProductController@show');
		Route::post('create','AccountantProductController@store');
		Route::post('update','AccountantProductController@update');
		Route::post('delete/{id}', 'AccountantProductController@delete');
		Route::post('add', 'AccountantProductController@add');
		Route::post('decrease', 'AccountantProductController@decrease');
	});
	Route::post('/change_product/{id}','AccountantProductController@change_product');
	Route::post('/change_product','AccountantProductController@change_product');
	Route::get('/change_product_index/{id}','AccountantProductController@change_product_index');
	Route::post('/change_product_index/{id}','AccountantProductController@change_product_index');
	Route::post('/decrease_product','AccountantProductController@decrease_product');
	Route::get('/delete_product/{id}','AccountantProductController@delete_product');
	// accountant's product section end

	// /accountant/items
	Route::group(['prefix'=>'items'], function(){
		Route::get('','AccountantItemController@index');
		Route::get('{id}','AccountantItemController@show');
		Route::post('create', 'AccountantItemController@store');
		Route::post('update', 'AccountantItemController@update');
		Route::post('add', 'AccountantItemController@add');
		Route::post('decrease', 'AccountantItemController@decrease');
		Route::delete('delete/{id}', 'AccountantItemController@delete');
	});
	Route::post('/add_item','AccountantItemController@add_item');
	Route::post('/edit_item','AccountantItemController@edit_item');
	Route::get('/change_item_index/{id}','AccountantItemController@change_item_index');
	Route::post('/change_item_index/{id}','AccountantItemController@change_item_index');
	Route::get('/change_item/{id}','AccountantItemController@change_item');
	Route::post('/change_item/{id}','AccountantItemController@change_item');
	// accountant's item section end


	Route::get('/staffs', 'AccountantStaffController@index');
	Route::get('/staff_check/{id}','AccountantStaffController@staff_check');
	Route::get('/staff_check/{id}/{start_date}/{end_date}', 'AccountantStaffController@search');
	Route::post('/staff/by_month', 'AccountantStaffController@by_month');
	Route::post('/staff/date', 'AccountantStaffController@date');

	Route::get('/hospital', 'AccountantHospitalController@index');
	Route::get('/hospital/{from}/{to}', 'AccountantHospitalController@date');
	Route::post('/hospital/by_month','AccountantHospitalController@by_month');
	Route::post('/hospital/by_date','AccountantHospitalController@by_date');
});

//--RECEPTION STARTING--
Route::group(['prefix'=>'reception'], function(){
	Route::get('/user', 'ReceptionUserController@index');
	Route::post('/user/store','ReceptionUserController@store');
	Route::post('/user/update','ReceptionUserController@update');
	Route::get('/user/register/{name}/{phone}/{appointment_id}', 'ReceptionUserController@fromAppointment');

	Route::get('/search', 'ReceptionUserController@search');
	Route::get('/time', 'ReceptionTimeController@time');
	Route::get('/time2', 'ReceptionTimeController@time2');

	Route::get('/time/week/{id}', 'ReceptionTimeController@timeWeek');
	Route::get('/time/week/{id}/{user_id}', 'ReceptionTimeController@timeWeekAppointment');
	Route::post('/time/add', 'ReceptionTimeController@store');
	Route::post('/time/cancel','ReceptionTimeController@cancel');
	Route::get('/time/{id}','ReceptionTimeController@appointment');
	Route::get('/user_check/{id}','ReceptionUserController@user_check');
	Route::get('/user_check/{id}/update','ReceptionUserController@user_update');
	Route::post('/user_check/{id}','ReceptionUserController@user_check_edit');
	Route::get('/user_check/{user_id}/{appointment_id}/check_in','ReceptionTimeController@check_in');
	Route::get('/shifts', 'ReceptionShiftsController@index');
	Route::post('/shifts/cancel','ReceptionShiftsController@cancel');
	Route::get('/shifts/{i}/{doctor_staff_id}/{shift_id}','ReceptionShiftsController@store');
	Route::get('/payment', 'ReceptionPaymentController@index');
	Route::post('/payment/store','ReceptionPaymentController@store');
	Route::get('/lease','ReceptionPaymentController@lease');
	Route::post('/lease/store','ReceptionPaymentController@lease_store');
	Route::get('/lease/store','ReceptionPaymentController@lease_store');
	Route::get('/product','ReceptionPaymentController@product');
	Route::get('/product/{id}','ReceptionPaymentController@show');
	Route::post('/decrease_product','ReceptionPaymentController@decrease_product');
});

//--DOCTOR STARTING--
Route::group(['prefix'=>'/doctor'], function(){
	Route::get('','DoctorController@index');
	Route::get('dash','DoctorController@dash');
	Route::get('treatment/{user_id}','DoctorTreatmentController@index');
	Route::get('treatment/{user_id}/gajig','DoctorTreatmentController@gajig');
	Route::get('treatment/{user_id}/sogog','DoctorTreatmentController@sogog');
	Route::get('treatment/{user_id}/mes','DoctorTreatmentController@mes');
	Route::post('treatment/store','DoctorTreatmentController@store');
	Route::post('treatment/finish','DoctorTreatmentController@finish');
	Route::post('treatment/xray','DoctorTreatmentController@xray');
	Route::get('treatment/history/{id}','DoctorTreatmentController@delete_history');

	Route::get('dashboard/','DoctorController@dashboard');
	Route::get('dashboard/{start_date}/{end_date}', 'DoctorController@search');
	Route::post('dashboard/by_month', 'DoctorController@by_month');
	Route::post('dashboard/date', 'DoctorController@date');
});
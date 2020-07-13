<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\User;
use App\Checkin;


class AppointmentController extends Controller
{
    //
    public function index(){
    	$appointments = Appointment::all();
    	return $appointments;
    }

    public function store(Request $request) {
        
        $request->validate([
        	'name' => 'required|string|max:60',
        	'phone' => 'required|string|max:50',
        	'created_by' => 'required|integer',
        	'shift_id' => 'required|integer',
        	'user_id' => 'required|integer'
        ]);

        $appointment = Appointment::create([
                'shift_id'=>$request['shift_id'],
                'user_id'=>0,
                'name'=>$request['name'], 
                'phone'=>$request['phone'], 
                'start'=>$request['start'], 
                'end'=>$request['end'], 
                'created_by'=> Auth::user()->id
            ]);
        return $appointment->id;
    }

    public function show($id){
    	$request->validate([
    		'id' => 'required|integer'
    	]);
    	return Appointment::findOrFail($id);
    }

    public function destroy($id){
    	$request->validate([
    		'id' => 'required|integer'
    	]);
    	return App::destroy($id);
    }

    public function update(Request $request){
    	$request->validate([
        	'name' => 'string|max:60',
        	'phone' => 'string|max:50',
        	'created_by' => 'integer',
        	'shift_id' => 'integer',
        	'user_id' => 'integer',
        ]);

    	$id = $request['id'];
    	return Appointment::findOrFail($id)->update($request->all());
    }
}

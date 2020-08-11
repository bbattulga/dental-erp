<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Log;
use App\Appointment;
use App\User;
use App\CheckIn;
use App\Shift;



class AppointmentController extends Controller
{   


    //
    public function index(){
        // return all appointments with relations
        return Appointment::with(['shift', 'checkin' ,'shift.doctor'])->get();
    }

    public function store(Request $request) {
        // validate then create
        /*
        $request->validate([
        	'name' => 'required|max:60',
        	'phone' => 'required|max:50',
        	'shift_id' => 'required|integer',
        	'user_id' => 'required|integer'
        ]);
        */

        $appointment = Appointment::create([
                'shift_id'=>$request['shift_id'],
                'user_id'=> !empty($request['user_id'])? $request['user_id']:0,
                'checkin_id'=> 0,
                'name'=>$request['name'], 
                'phone'=>$request['phone'], 
                'start'=>$request['start'], 
                'end'=>$request['end'], 
                'created_by'=> Auth::user()->id
            ]);
        return $appointment;
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'max:60',
            'phone' => 'max:50',
            'shift_id' => 'integer',
            'user_id' => 'integer',
        ]);
        $id = $request['id'];
        return Appointment::findOrFail($id)->update($request->all());
    }

    public function show($id){
        if ($id){
            return Appointment::with(['shift', 'checkin' ,'shift.doctor'])
                                ->where('id', $id)
                                ->first();
        }
        if ($date){
            return Shift::with('appointments', 'appointments.user', 'appointments.checkin' ,'doctor')
                ->where('shifts.date', $date)
                ->get();  
        }
        return $date;
    }

    public function showDate($date){
        if ($date == null){
            $date = Date('Y-m-d');
        }
        return Shift::with('appointments', 'appointments.user', 'appointments.checkin' , 'appointments.checkin', 'doctor')
            ->where('shifts.date', $date)
            ->get();
    }
    public function today(){
        return Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date', Date('Y-m-d'))
            ->get();    
    }
    
    public function showDateBetween(Request $request){
        $request->validate([
            'date1' => 'string|max:10',
            'date2' => 'string|max:10',
            'user_id' => 'integer',
        ]);

        $date1 = $request['date1'];
        $date2 = $request['date2'];
        $user_id = $request['doctor_id'];

        if ($user_id == null){
            $shifts =  Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->get();
            return $shifts;
        }

        $shifts =  Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->where('shifts.user_id', '=', $user_id)
            ->get();
        return $shifts;
    }
    
    public function destroy($id){
        $appointment = Appointment::findOrFail($id);
        if ($appointment->checkin){
            $appointment->checkin->delete();
        }
        return Appointment::destroy($id);
    }

    public function cancel(Request $request){

        if ($request['code'] != '1111'){
            return back();
        }

        $id = $request['appointment_id'];
        $appointment = Appointment::findOrFail($id);
        if (!$appointment){
            return 0;
        }
        $d = 0;

        $d = $appointment->delete();
        // delete checkin
        if ($appointment->checkin){
            $checkin_id = $appointment->checkin->id;
            CheckIn::destroy($id);
        }
        Log::create(['type'=>2,
                    'type_id'=>$id,
                    'user_id'=>Auth::user()->id,
                    'action_id'=>0,
                    'description'=>$request['description']
                ]);
        return $d;
    }
}

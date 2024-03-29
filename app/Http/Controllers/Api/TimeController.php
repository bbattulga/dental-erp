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



class TimeController extends Controller
{   


    //
    public function index(){
        // return all appointments with relations
        return Appointment::with(['shift', 'shift.doctor'])->get();
    }

    public function store(Request $request) {
        
        // validate then create
        
        $request->validate([
        	'name' => 'required|max:60',
        	'phone' => 'required|max:50',
        	'shift_id' => 'required|integer',
        	'user_id' => 'required|integer'
        ]);
        
        // create checkin if user_id is given.
        $checkin = null;
        if (!empty($request['user_id'])){
        	$checkin = CheckIn::create([
        		'user_id' => $request['user_id'],
        		'shift_id' => $request['shift_id'],
        		'state' => 0,
        		'created_by' => Auth::user()->id
        	]);
        }

        $appointment = Appointment::create([
                'shift_id'=>$request['shift_id'],
                'user_id'=> $request['user_id']? $request['user_id']:0,
                'checkin_id' => $checkin? $checkin->id:0,
                'name'=>$request['name'], 
                'phone'=>$request['phone'], 
                'start'=>$request['start'], 
                'end'=>$request['end'], 
                'created_by'=> Auth::user()->id
            ]);
        // pass new create checkin object too
        // checkin\'s state might be needed...
        if ($checkin){
        	$appointment->checkin = $checkin;
        }
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
        if ($id)
            return Appointment::findOrfail($id);
        if ($date){
            return Shift::with('appointments', 'appointments.user', 'doctor')
                ->where('shifts.date', $date)
                ->get();  
        }
        return $date;
    }

    public function showDate($date){
        if ($date == null){
            $date = Date('Y-m-d');
        }
        return Shift::with('appointments', 'appointments.user', 'doctor')
            ->where('shifts.date', $date)
            ->get();
    }
    public function today(){
        return Shift::with('appointments', 'appointments.user', 'doctor')
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
            $shifts =  Shift::with('appointments', 'appointments.user', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->get();
            return $shifts;
        }

        $shifts =  Shift::with('appointments', 'appointments.user', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->where('shifts.user_id', '=', $user_id)
            ->get();
        return $shifts;
    }
    
    public function destroy($id){
        return Appointment::destroy($id);
    }

    public function cancel(Request $request){

        if ($request['code'] != '1111'){
            return back();
        }

        $id = $request['appointment_id'];
        $d = Appointment::destroy($id);
        Log::create(['type'=>2,'type_id'=>$id,'user_id'=>Auth::user()->id,'action_id'=>0,'description'=>$request['description']]);

        // cancel checkin too
        if (($user_id = $request['user_id'])
            && $shift_id=$request['shift_id']){
            CheckIn::where('user_id', $user_id)
                    ->where('shift_id', $shift_id)
                    ->delete();
        }
        return $d;
    }
}

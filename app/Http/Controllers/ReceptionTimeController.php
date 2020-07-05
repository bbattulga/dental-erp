<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Log;
use App\CheckIn;
use App\UserRole;
use App\Shift;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Roles;


class ReceptionTimeController extends Controller
{
    //

    public function __construct()
    {
       // $this->middleware('reception');
    }
    public function time() {
        $shifts = Shift::all()->where('date', date('Y-m-d'));
        return view('reception.time', compact('shifts'));
    }
    public function appointment($id) {
        $user = User::find($id);
        $shifts = Shift::all()->where('date', date('Y-m-d'));
        return view('reception.time', compact('shifts', 'user'));
    }

    public function timeWeek($id) {
        $role = UserRole::find($id);
        $roles = UserRole::where('role_id', Roles::doctor()->id);
        $shifts = $role->shifts->where('date', '>=', date('Y-m-d'));
        return view('reception.time_week', compact('role', 'roles', 'shifts'));

    }
    public function timeWeekAppointment($id, $user_id) {
        $user = User::find($user_id);
        $role = UserRole::find($id);
        $roles = UserRole::where('role_id', Roles::doctor()->id);
        $shifts = $role->shifts->where('date', '>=', date('Y-m-d'));
        return view('reception.time_week', compact('shifts', 'user','role', 'roles'));
    }


//    public function date(Request $request) {
//        $shifts = Time::all()->where('date', date('Y-m-d'));
//        return view('reception.time', compact('shifts'));
//    }


    public function store(Request $request) {

        /*
        $shift = Time::find($request['shift_id']);
        if ($shift->shift_id == 2) {
            $times = [15, 16, 17, 18, 19, 20];
        } elseif ($shift->shift_id == 1) {
            $times = [9, 10, 11, 12, 13, 14];
        } else {
            $times = [];
        }

        //Generating database's array

        $appointments = $shift->appointments->sortBy('start');
        foreach ($appointments as $appointment) {
            $start = $appointment->start;
            $end = $appointment->end;
            for ($i = $start; $i<$end; $i++) {
                array_push($times, $i);
            }
        }

        //Generating input's array
        $time = [];
        $start = $request['time'];
        $end = $request['time']+$request['hours'];
        for ($i = $start; $i<$end; $i++) {
            array_push($time, $i);
        }

        //Checking appointment
        for ($i = 0; $i<count($time); $i++) {
            for ($c = 0; $c<count($times); $c++) {
                if ($times[$c] == $time[$i]) {
                    //Return validation message
                    return 'shit';
                }
            }
        }
        */

      //  return 'a';
        // trivial add
        
        $id = -1;
        if($request['user_id'] == 0) {
            $id = Appointment::create([
                'shift_id'=>$request['shift_id'],
                'user_id'=>0,
                'name'=>$request['name'], 
                'phone'=>$request['phone'], 
                'start'=>$request['start'], 
                'end'=>$request['end'], 
                'created_by'=>2])->id;
            } else {
            $user = User::find($request['user_id']);
            Appointment::create([
                'shift_id'=>$request['shift_id'], 
                'user_id'=>$request['user_id'], 
                'name'=>$user->name,
                'phone'=>$request['phone'],
                'start'=>$request['time'], 
                'end'=>$request['end'], 
                'created_by'=>Auth::user()->id]);
        }
        return $id;
    }


    public function cancel(Request $request){

        if($request['code'] == '1111'){
            $id = $request['appointment_id'];
            $d = Appointment::find($id)->delete();
            Log::create(['type'=>2,'type_id'=>$id,'user_id'=>2,'action_id'=>0,'description'=>$request['description']]);
            return $d;
        }
        else{
            return back();
        }
    }
    public function check_in($user_id, $appointment_id){
        $user = User::find($user_id);
        $shift_id = Appointment::find($appointment_id)->shift_id;
        CheckIn::create(['shift_id'=>$shift_id, 'user_id'=>$user->id, 'state'=>0, 'created_by'=>Auth::user()->id,'nurse_id'=>0]);
        return redirect('/reception/time');
    }

    // for ajax requests
    public function raw_appointments(){
        $appointments = Shift::with('appointments', 'doctor')->get();
        return $appointments;
    }
}

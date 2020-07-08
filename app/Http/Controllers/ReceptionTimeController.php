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
use Illuminate\Support\Facades\DB;
use App\Roles;


class ReceptionTimeController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('reception');
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
        
        $id = -1;
        if($request['user_id'] == 0) {
            $id = Appointment::create([
                'shift_id'=>$request['shift_id'],
                'user_id'=>0,
                'name'=>$request['name'], 
                'phone'=>$request['phone'], 
                'start'=>$request['start'], 
                'end'=>$request['end'], 
                'created_by'=> Auth::user()->id
            ])->id;
            } else {
            $user = User::find($request['user_id']);
            Appointment::create([
                'shift_id'=>$request['shift_id'], 
                'user_id'=>$request['user_id'], 
                'name'=>$user->name,
                'phone'=>$request['phone'],
                'start'=>$request['time'], 
                'end'=>$request['end'
            ], 
                'created_by'=>Auth::user()->id]);
        }
        return $id;
    }


    public function cancel(Request $request){

        if($request['code'] == '1111'){
            $id = $request['appointment_id'];
            $d = Appointment::find($id)->delete();
            Log::create(['type'=>2,'type_id'=>$id,'user_id'=>Ath::user()->id,'action_id'=>0,'description'=>$request['description']]);
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
    public function api_shift(Request $request){
        // $date is optional.
        $date = $request['date'];
        if ($date == null){
            $date = Date('Y-m-d');
        }
        $shifts = Shift::with('appointments', 'appointments.user', 'doctor')
            ->where('shifts.date' , '=', $date)
            ->get();
        return $shifts;
    }

    public function api_doctors(){
         $doctors = DB::table('user_role')
                    ->join('users', function($join){
                        $join->on('users.id', '=', 'user_role.user_id')
                            ->where('user_role.role_id', '=', Roles::doctor()->id);
                    })->get();
        return $doctors;
    }

    public function api_shifts_interval(Request $request){

        $date1 = $request['date1'];
        $date2 = $request['date2'];
        $user_id = $request['user_id'];

        $shifts =  Shift::with('appointments', 'appointments.user', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->where('shifts.user_id', '=', $user_id)
            ->get();
        return $shifts;
    }
    public function api_shift_today(){
        $shifts =  Shift::with('appointments', 'appointments.user', 'doctor')
            ->where('shifts.date',Date('Y-m-d'))
            ->get();
        return $shifts;
    }
}

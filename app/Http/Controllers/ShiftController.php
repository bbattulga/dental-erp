<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;

class ShiftController extends Controller
{
    //


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

<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ShiftType;


class DoctorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('doctor');
    }
    public function index(){
        $doctor = Auth::user();
        $shifts = Shift::all()->where('date', date('Y-m-d'))->where('user_id',$doctor->id)->first();

        if(empty($shifts)) {
            $checkins = null;
        } else {
            $checkins = $shifts->checkins->where('state', '<=', 1);
        }
        return view('doctor.check_in',compact('checkins'));
    }
    public function dashboard() {
        $user = Auth::user();
        $start_date = Date('Y-m-01');
        $end_date = Date('Y-m-t', strtotime('first day of this month'));

        $shifts =  Shift::where('user_id', $user->id)->where('date','>=', date('Y-m-d', strtotime('first day of this month')))->orderBy('id', 'desc')->get();

        $count_full = 0;
        $count_half = 0;
        foreach($shifts as $shift){
                if ($shift->shift_type_id == ShiftType::full())
                    $count_full++;
                else
                    $count_half++;
            }
        return view('doctor.dashboard',compact('user', 'shifts', 'count_full', 'count_half', 
                                            'start_date', 'end_date'));
    }
        
    public function search($start_date, $end_date) {
        $user = Auth::user();
        $shifts = null;
        $shifts =  Shift::all()->where('user_id', Auth::user()->id)
                ->whereBetween('date', [$start_date, $end_date])->sortByDesc('id');

        $count_full = 0;
        $count_half = 0;
        foreach($shifts as $shift){
                if ($shift->shift_type_id == ShiftType::full())
                    $count_full++;
                else
                    $count_half++;
            }
        return view('doctor.dashboard', compact('user', 'shifts','start_date', 'end_date', 'count_full', 'count_half'));
    }
    public function by_month(Request $request){
        $month = $request['month'];
        $year = $request['year'];
        $end_month = $request['month']+1;
        $start_date = Date('Y-m-d', strtotime("$year-$month-01"));
        $end_date = Date('Y-m-t', strtotime($start_date));
        return redirect('/doctor/dashboard/' . $start_date.'/'.$end_date);
    }
    public function date(Request $request) {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        return redirect('/doctor/dashboard/' . $start_date.'/'.$end_date);
    }

}

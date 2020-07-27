<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\UserRole;
use App\Shift;
use App\User;
use Illuminate\Http\Request;
use App\Roles;


class AccountantStaffController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('accountant');
    }
    public function index() {
        $roles = UserRole::whereIn('role_id', [1, 2, 3, 4, 5]);
        return view('accountant.staffs', compact('roles'));
    }
    public function staff_check($id){
        $user = User::find($id);
        if($user->role->role_id == Roles::doctor()->id) {
            $shifts = Shift::where('user_id', $user->id)
                        ->where('date','>=', date('Y-m-d', strtotime('first day of this month')))
                        ->orderBy('id', 'desc')
                        ->get();
            return view('accountant.staff_profile',compact('user', 'shifts'));
        } else if($user->role->role_id == Roles::nurse()->id) {
            $checkins = CheckIn::where('nurse_id', $user->id)
                                ->where('created_at','>=', date('Y-m-d', strtotime('first day of this month')))
                                ->orderBy('id', 'desc')
                                ->get();
            return view('accountant.staff_profile', compact('user', 'checkins'));
        }
    }
    public function search($id, $start_date, $end_date) {
        $user = User::find($id);
        if($user->role->role_id == Roles::doctor()->id) {
            $shifts = Shift::all()->where('user_id', $user->id)->whereBetween('date', [date('Y-m-d', $start_date), date('Y-m-d', $end_date)])->sortByDesc('id');
            return view('accountant.staff_profile', compact('user', 'shifts', 'start_date', 'end_date'));
        } else if($user->role->role_id == Roles::nurse()->id) {
            $checkins = CheckIn::where('nurse_id', $user->id)->whereBetween('created_at', [date('Y-m-d', $start_date), date('Y-m-d', $end_date)])->orderBy('id', 'desc')->get();
            return view('accountant.staff_profile', compact('user', 'checkins', 'start_date', 'end_date'));
        }
    }
    public function by_month(Request $request){
        $month = $request['month'];
        $year = $request['year'];
        $end_month = $request['month']+1;
        $start_date= strtotime($year .'-'.$month.'-'.'1');
        if($end_month == 12){
            $end_month = 1;
        }
        $end_date = strtotime($year.'-'.$end_month.'-'.'1');
        return redirect('/accountant/staff_check/' . $request['staff_id']. '/'  . $start_date.'/'.$end_date);
    }
    public function date(Request $request) {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $start_date = explode('/', $start_date);
        $start_date = strtotime($start_date[2] . '-' . $start_date[0] . '-' . $start_date[1]);
        $end_date = explode('/', $end_date);
        $end_date = strtotime($end_date[2] . '-' . $end_date[0] . '-' . $end_date[1]);;
        return redirect('/accountant/staff_check/'. $request['staff_id']. '/'  . $start_date.'/'.$end_date);
    }
}

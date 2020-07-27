<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\Shift;

use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Roles;


class AdminStaffController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function edit($id){
        $user = User::find($id);
        //Admin->5
        //Reception->2
        //Doctor->3
        //Assistant->1
        //Accountant->4
        $update = ['Админ','Ресепшн','Эмч','Сувилагч','Нягтлан','Бусад'];
        return view('admin.staff_profile', compact('user', 'update'));
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'last_name' => 'required|max:255',
            'name'=>'required|max:255',
            'sex'=>'required',
        ]);
        $user = User::find($request['user_id']);
        if(empty($user)) {
            return redirect()->back();
        }
        $birth_date = explode('/', $request['birth_date']);
        $birth_date = $birth_date[2] . '-' . $birth_date[0] . '-' . $birth_date[1];
        $user->last_name = $request['last_name'];
        $user->name = $request['name'];
        $user->sex = $request['sex'];
        $user->register = $request['register'];
        $user->phone_number = $request['phone_number'];
        $user->email = $request['email'];
        $user->birth_date = $birth_date;
        $user->location = $request['location'];
        $user->description = $request['info'];

        if ($image = $request->file(['image'])){
            $image_name = ''.time().$image->getClientOriginalName();
            $image->move('img/staffs', $image_name);
            $user->photos()->create(['path'=>$image_name]);
        }
        if(!empty($request['password']))
            $user->password = bcrypt($request['password']);
        $role = UserRole::where('role_id', $request['role_id'])->first();
        $user->role_id = $request['role_id'];
        $role->role_id = $request['role_id'];
        $role->save();
        $user->save();
        return redirect()->back();
    }

    public function search($id, $start_date, $end_date) {
        $user = User::find($id);
        if($user->role->role_id == Roles::doctor()->id) {
            $checkins = array();
            $shifts = Shift::with('checkins')
                            ->where('doctor_id', $user->id)
                            ->whereBetween('date', [date('Y-m-d', $start_date), date('Y-m-d', $end_date)])
                            ->get();
            foreach($shifts as $shift){
                foreach($shift->checkins as $checkin){
                    array_push($checkins, $checkin);
                }
            }
            return view('admin.staff_profile', compact('user', 'shifts', 'start_date', 'end_date', 'checkins'));
        } else if($user->role->role_id == Nurse::doctor()->id) {
            $checkins = CheckIn::where('user_id', $user->id)
                    ->whereBetween('created_at', [date('Y-m-d', $start_date), date('Y-m-d', $end_date)])
                    ->orderBy('id', 'desc')
                    ->get();
            return view('admin.staff_profile', compact('user', 'checkins', 'start_date', 'end_date'));
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
        return redirect('/admin/staff_check/' . $request['staff_id']. '/'  . $start_date.'/'.$end_date);
    }
    public function date(Request $request) {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $start_date = explode('/', $start_date);
        $start_date = strtotime($start_date[2] . '-' . $start_date[0] . '-' . $start_date[1]);
        $end_date = explode('/', $end_date);
        $end_date = strtotime($end_date[2] . '-' . $end_date[0] . '-' . $end_date[1]);
        return redirect('/admin/staff_check/'. $request['staff_id']. '/'  . $start_date.'/'.$end_date);
    }

    public function delete(Request $request){
        $id = $request['id'];
        $user = User::find($id);
        return $user;
    }
}

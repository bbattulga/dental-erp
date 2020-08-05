<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\CheckIn;
use App\Lease;
use App\Log;
use App\ProductHistory;
use App\Products;
use App\UserRole;
use Aloha\Twilio\Support\Laravel\Facade as Twilio;

use App\Shift;
use App\UserTreatments;

use App\Transaction;
use App\User;
use App\Patient;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ShiftType;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //-------------
    //STAFF SECTION
    //-------------
    public function index(){
        $roles = UserRole::all();
        return view('admin.add_staff',compact('roles'));
    }
    public function add_staff(Request $request){
//        $pass = str_random('6');
//        Twilio::message('+976'.$request['phone_number'],'MonFamily шүдний эмнэлгийн систем. Таны нэвтрэх нэр:'.$request['email'].' '.'Таны нууц үг:'.$pass.'');
        $pass = $request['password'];
        $pass = bcrypt($pass);
        $validatedData = $request->validate([
            'last_name' => 'required|max:255',
            'email'=>'required|unique:users|max:255',
            'name'=>'required|max:255',
            'sex'=>'required',
            'register'=>'required|unique:users|max:255',
        ]);
        $date = explode('/', $request['birth_date']);
        $birth_date = $date[2] . '-' . $date[0] . '-' . $date[1];
        $user = User::create(['last_name'=>$request['last_name'],'name'=>$request['name'],'register'=>$request['register'],'phone_number'=>$request['phone_number'],'email'=>$request['email'],'birth_date'=>$birth_date,'location'=>$request['location'],'description'=>$request['info'],'password'=>$pass,'sex'=>$request['sex'],
            'role_id'=>$request['role']
        ]);

        if ($image = $request->file(['image'])){
            $image_name = ''.time().$image->getClientOriginalName();
            $image->move('img/staffs', $image_name);
            $user->photos()->create(['path'=>$image_name]);
        }
        $role = UserRole::create(['user_id'=>$user->id, 'role_id'=>$request['role'],'state'=>1]);
        return redirect('/admin/add_staff');
    }

    public function profile($id){
        $user = User::find($id);
        $checkins = array();

        $start_date = Date('Y-m-01');
        $end_date = Date('Y-m-t', strtotime('first day of this month'));
        if($user->role_id == Roles::doctor()->id) {
            $shifts = Shift::with('checkins')
                    ->where('user_id', $user->id)
                    ->where('date','>=', date('Y-m-d', strtotime('first day of this month')))
                    ->orderBy('id', 'desc')
                    ->get();
            $count_full = 0;
            $count_half = 0;
            foreach($shifts as $shift){
                if ($shift->shift_type_id == ShiftType::full())
                    $count_full++;
                else
                    $count_half++;
            }
            return view('admin.staff_profile',compact('user', 'shifts', 'count_full', 
                                        'count_half', 'start_date', 'end_date'));
        } else if($user->role_id == Roles::nurse()->id) {
            $checkins = CheckIn::where('nurse_id', $user->id)->where('created_at','>=', date('Y-m-d', strtotime('first day of this month')))->orderBy('id', 'desc')->get();
            return view('admin.staff_profile', compact('user', 'checkins'));
        }
        return view('admin.staff_profile', compact('user', 'checkins'));
    }
    public function fire($id){
        $user=User::find($id);
        UserRole::where('user_id', $user->id)
                ->update(['state'=>0]);
        return redirect('/admin/add_staff/'.$id.'/profile');
    }
    //--------------
    //DASHBOARD
    //--------------
    public function dashboard() {
        $users = Patient::all()->count();
        $roles = UserRole::all()->count();
        $users_number = $users;
        $shifts_day = Shift::where('date', Date('Y-m-d'))->get();
        $appointments = 0;
        $checkins = 0;
        foreach($shifts_day as $shift){
            $appointments += $shift->appointments->count();
            $checkins += $shift->checkins->count(); 
        }

        // find workload of the week
        $workloads = [];
        for ($i=6; $i>=0; $i--){
            $date = date('Y-m-d', strtotime('-'.$i.' Days'));
            $shifts = Shift::where('date', $date)->get();
            $workload = 0;
            foreach($shifts as $shift){
                $workload += $shift->checkins->count();
            }
            array_push($workloads, $workload);
        }
        $workloads = json_encode($workloads);
        return view('admin.dashboard',compact('users_number','roles','appointments','checkins', 'workloads'));
    }
    public function logs(){
        $logs=Log::all();
        return view('admin.logs',compact('logs'));
    }
    public function users(){
        $users = Patient::all();
        return view('admin.users',compact('users'));
    }
    public function user_check($id){
        $user = User::find($id);
        $check_ins = CheckIn::where('state','>=',3)
                            ->where('user_id',$id)
                            ->orderBy('id', 'desc')
                            ->get();

        return view('admin.user_check',compact('user','check_ins'));

    }

    public function hospital(){

        return view('admin.hospital');
    }

    public function search(Request $request){
        $input = $request->key;
        $results = User::where('email', 'like', '%'.$input.'%')
            ->orWhere('phone_number', 'like', '%'.$input.'%')
            ->orWhere('name', 'like', '%'.$input.'%')
            ->orWhere('last_name', 'like', '%'.$input.'%')
            ->limit('25');

        return view('admin.search', compact('results', 'input'));
    }


}

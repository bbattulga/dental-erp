<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\UserTreatments;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('reception');
    }

    public function index() {
            $checkin_all = CheckIn::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            $last_checkin = CheckIn::where('user_id',Auth::user()->id)->get()->last();
//            if($last_checkin->whereBetween('created_at', array(Carbon::now()->subMonth(6)->toDateTimeString(), Carbon::now()->toDateTimeString()))){
//                return 'hellp world';
//            }
            $user_treatments = UserTreatments::where('user_id',  Auth::user()->id)->orderBy('id', 'DESC')->get();
            return view('user.user_profile',compact( 'treatments','user_treatments', 'checkin_all'));
    }

    public function query(Request $request){
    	$phone = $request['phone'];
    	$name = $request['name'];
    	$results = User::where('phone_number', '=', $phone)
    				->orWhere('name','=', $name)
    				->get();
    	return $results;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tooth;
use App\UserTooth;
use App\ToothType;


class UserToothController extends Controller
{
    //
     public function index(){
		return UserTooth::with('tooth_type')->get();
	}

	public function show($id){
		return UserTooth::findOrFail($id);
	}

	public function store(Request $request){
		$tooth_code = $request['tooth_code'];
		$user_id = $request['user_id'];
		$tooth_type_id = $request['tooth_type_id'];

		$tooth_id = Tooth::where('code', $tooth_code)->first()->id;
		$user_tooth = UserTooth::create([
			'user_id'=>$user_id,
			'tooth_id'=>$tooth_id,
			'tooth_type_id'=>$tooth_type_id
		]);
		return $user_tooth->id;
	}
	
	public function update(Request $request){
		return UserTooth::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
		return UserTooth::destroy($id);
	}

	public function destroByUserTooth($user_id, $tooth_code){
		$tooth_id = Tooth::where('code', $tooth_code)->first()->id;
		return UserTooth::where('user_id', $user_id)
							->where('tooth_id', $tooth_id)
							->delete();
	}
}

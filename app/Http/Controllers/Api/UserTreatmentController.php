<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserTreatments;


class UserTreatmentController extends Controller
{
    public function index(){
		return UserTreatments::with([
				'user', 
				'checkin',
				'treatment', 
				'treatment_selection'
			])
			->get();
	}

	public function show($id){
		return UserTreatments::with([
				'user', 
				'checkin',
				'treatment', 
				'treatment_selection'
			])
			->where('id', $id)
			->get();
	}

	public function store(Request $request){
		$user_treatment = UserTreatments::create($request->all());
		return $user_treatment->id;
	}
	
	public function update(Request $request){
		return UserTreatments::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
        
		return UserTreatments::destroy($id);
	}
}

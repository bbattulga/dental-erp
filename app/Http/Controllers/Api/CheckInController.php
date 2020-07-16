<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CheckIn;


class CheckInController extends Controller
{
    public function index(){
		return CheckIn::with('shift', 'shift.type', 'shift.doctor','user', 
			'treatments', 'treatments.treatment', 'treatments.treatmentSelection')
				->get();
	}

	public function show($id){
		$request->validate(['id'=>'required|integer']);
		return CheckIn::with('shift', 'shift.type', 'shift.doctor','user',
			'treatments',
			'treatments.treatment', 'treatments.treatmentSelection')
				->where('id', $id)
				->get();
	}

	public function store(Request $request){
		$checkin = CheckIn::create([
			'shift_id' => $request['shift_id'],
			'user_id' => $request['user_id'],
			'state' => 0,
			'created_by' => Auth::user()->id,
			'nurse_id' => 0
		]);
		return $checkin->id;
	}

	public function update(Request $request){
		$request->validate([
			'id' => 'integer',
			'shift_id' => 'integer',
			'user_id' => 'integer',
			'state' => 'integer',
			'created_by' => 'integer'
		]);
		return CheckIn::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
		$request->validate([
    		'id' => 'required|integer'
    	]);
		return CheckIn::destroy($id);
	}
}

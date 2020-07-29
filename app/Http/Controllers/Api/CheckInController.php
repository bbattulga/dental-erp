<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\CheckIn;
use App\Shift;



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
		if (!empty($request['doctor_id'])){
			return $this->toDoctor($request);
		}

		$checkin = CheckIn::create([
			'shift_id' => $request['shift_id'],
			'user_id' => $request['user_id'],
			'state' => 0,
			'created_by' => Auth::user()->id,
			'nurse_id' => 0
		]);
		return $checkin;
	}

	public function toDoctor(Request $request){
		if (!empty($request['date'])){
			// handle specified doctor's shift at date
			return;
		}

		$shift = Shift::where('user_id', $request['doctor_id'])
						->where('date', Date('Y-m-d'))
						->first();
		if (!$shift){
			return "Эмчийн ээлж тавигдаагүй байна";
		}
		$checkin = CheckIn::create([
			'user_id' => $request['user_id'],
			'shift_id' => $shift->id,
			'state' => 0,
			'nurse_id' => 0,
			'created_by' => Auth::user()->id
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

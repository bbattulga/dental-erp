<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CheckIn;


class CheckInController extends Controller
{
    public function index(){
		return CheckIn::all();
	}

	public function show($id){
		$request->validate(['id'=>'required|integer']);
		return CheckIn::findOrFail($id);
	}

	public function store(Request $request){
		$request->validate([
			'shift_id' => 'required|integer',
			'user_id' => 'required|integer',
			'state' => 'required|integer',
			'created_by' => 'required|integer'
		]);
		$checkin = CheckIn::create($request->all());
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

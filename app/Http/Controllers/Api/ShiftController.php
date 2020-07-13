<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shift;


class ShiftController extends Controller
{
    //

	public function index(){
		return Shift::all();
	}

	public function show($id){
		return Shift::findOrFail($id);
	}

	public function update(Request $request){
		return Shift::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
		return Shift::destroy($id);
	}
}

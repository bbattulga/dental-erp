<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class UserController extends Controller
{
    //
    public function index(){
		return User::all();
	}

	public function show($id){
		return User::findOrFail($id);
	}

	public function update(Request $request){
		return User::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
		return User::destroy($id);
	}
}

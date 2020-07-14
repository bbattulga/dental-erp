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

	public function store(Request $request){
		$validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
//            'email'=>'max:255',
            'name'=>'required|string|max:255',
            'sex'=>'required',
            'register'=>'required|unique:users|max:255',
            ]);

        if(empty($request['email']))
            $request['email'] = 'nomail@gmail.com';
        if(empty($request['password'])){
            $request['password'] = 'secret';
        }
        $user = User::create($request->all());
        return $user->id;
	}

	public function update(Request $request){
		return User::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){

		return User::destroy($id);
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

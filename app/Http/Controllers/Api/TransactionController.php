<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;


class TransactionController extends Controller
{
    
    public function index(){
		return Transaction::all();
	}

	public function show($id){
		return Transaction::findOrFail($id);
	}

	public function store(Request $request){
		$validatedData = $request->validate([
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
            ]);
		return $userRole->id;
	}
	
	public function update(Request $request){
		return Transaction::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
        
		return Transaction::destroy($id);
	}
}

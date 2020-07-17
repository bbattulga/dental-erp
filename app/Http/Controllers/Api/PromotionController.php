<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Promotion;


class PromotionController extends Controller
{
    //

    
    public function index(){
		return Promotion::all();
	}

	public function show($id){
		return Promotion::findOrFail($id);
	}

	public function store(Request $request){
		$validatedData = $request->validate([
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
            ]);
		$userRole = UserRole::create($request->all());
		return $userRole->id;
	}

	public function showByCode($code){
		$promotion = Promotion::where('promotion_code', $code)->limit(1)->get();
		return $promotion;
	}
	
	public function update(Request $request){
		return Promotion::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
        
		return Promotion::destroy($id);
	}
}

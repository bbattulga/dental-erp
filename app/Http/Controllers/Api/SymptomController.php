<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Patient;
use App\Symptom;



class SymptomController extends Controller
{
    //
    public function index(){
		return Symptom::all();
	}

	public function show($id){
		return Symptom::findOrFail($id);
	}

	public function store(Request $request){
		$symptom = Symptom::create($request->all());
		return $symptom->id;
	}
	
	public function update(Request $request){
		return Symptom::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
        
		return Symptom::destroy($id);
	}
}

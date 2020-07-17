<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Treatment;


class TreatmentController extends Controller
{
    //
    public function index(){
		return Treatment::with('category', 'treatment_selections')->get();
	}

	public function show($id){
		return Treatment::with('category', 'treatment_selections')
				->where('id', $id)
				->get();
	}

	public function showByCategory($categoryId){
		return Treatment::with('treatment_selections')
				->where('category', $categoryId)
				->get();
	}

	public function store(Request $request){
		$validatedData = $request->validate([
            'name' => 'required|max:100'
            ]);
        $treatment = Treatment::create($request->all());
        return $treatment->id;
	}

	public function update(Request $request){
		return Treatment::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
        
		return Treatment::destroy($id);
	}
}

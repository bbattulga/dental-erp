<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TreatmentCategory;


class TreatmentCategoryController extends Controller
{
    //

    public function index(){
    	return TreatmentCategory::with(['treatments'])->get();
    }

    
	public function show($id){
		return TreatmentCategory::findOrFail($id);
	}

	public function store(Request $request){
		// validate and store

        $treatmentCategory = TreatmentCategory::create($request->all());
        return $treatmentCategory->id;
	}

	public function update(Request $request){
		return TreatmentCategory::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){

		return TreatmentCategory::destroy($id);
	}
}

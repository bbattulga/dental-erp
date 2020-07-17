<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TreatmentSelections;


class TreatmentSelectionController extends Controller
{
    
    public function index(){
		return TreatmentSelections::with(['treatment'])
				->get();
	}

	public function show($id){
		return TreatmentSelections::with(['treatment'])
				->where('id', $id)
				->get();
	}

	public function store(Request $request){
		$validatedData = $request->validate([
            'name' => 'required|string|max:100'
            ]);
        $treatmentSelections = TreatmentSelections::create($request->all());
        return $treatmentSelections->id;
	}

	public function update(Request $request){
		return TreatmentSelections::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
        
		return TreatmentSelections::destroy($id);
	}
}

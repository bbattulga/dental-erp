<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\CheckIn;
use App\UserRole;
use App\Transaction;
use App\Treatment;
use App\TreatmentSelections;
use App\TreatmentCategory;
use App\User;
use App\UserTreatments;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Roles;
use App\ToothType;
use App\UserTooth;
use App\CheckInState;
use App\Symptom;
use App\TreatmentNote;


class DoctorTreatmentController extends Controller
{
    //

    public function show($checkin_id){
    	$checkin = CheckIn::find($checkin_id);
    	$checkin_all = CheckIn::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
    	$treatments = Treatment::where('category', $category)->get();
        $treatmentCategories = TreatmentCategory::all();
        $user_treatments = UserTreatments::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
        $nurses = User::where('role_id', Roles::nurse()->id)->get();
        $tooth_types = ToothType::all();
        $user_tooths = UserTooth::with('tooth_type', 'tooth')
                        ->where('user_id', $checkin->user_id)
                        ->get();

        // udpate checkin state
        $checkin->update([
            'state' => CheckInState::treatment_started()
        ]);

        $symptoms = Symptom::where('user_id', $checkin->user_id)->get();
        return compact('checkin', 'treatments','user_treatments', 
                        'checkin_all', 'nurses', 'category', 'treatmentCategories',
                        'tooth_types',
                        'user_tooths',
                        'symptoms');
    }

    public function store(Request $request){
        
    }
}

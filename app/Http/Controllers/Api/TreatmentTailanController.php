<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use App\Patient;
use App\Shift;
use App\CheckIn;
use App\TreatmentCategory;
use App\UserTreatments;
use App\Treatment;


class TreatmentTailanController extends Controller
{
    //
    public function index() {
        $start = Date('Y-m-d', strtotime('- 7 Days'));
        $end = Date('Y-m-d');
        $users = Patient::all();
        return $users;
    }
    
    public function showMonth(Request $request){

    }

    public function showDateBetween(Request $request){
        ini_set('max_execution_time', 60*5); // 5 min timetout
        $category_id = $request['category_id'];
        return $this->getTreatmentData($category_id, 
                    $request['start_date'], $request['end_date']);
    }

    public function test($category_id, $start, $end){
        return $this->getTreatmentData($category_id, $start, $end);
    }

    // obtain data about patients and treatment
    // such as total number of treatments, first time or not and ages...
    // and returns key value pair using compact function.
    private function getTreatmentData($category_id, $start_date, $end_date){
        ini_set('max_execution_time', 60*30); // 5 min timetout
    	
        $count_male = 0;
        $count_female = 0;

        $count_total = 0;
        $count_first = 0;   
        $count_again = 0;

        $age_male = array();
        $age_female = array();
        for ($i=0;$i<=16;$i++) {
            array_push($age_male, 0);
            array_push($age_female, 0);
        }

        // eager load with treatments in given interval
        $interval = [$start_date . ' 00:00:00', $end_date . ' 23:59:59'];
        $user_treatments = UserTreatments::with('user', 'treatment')
                              ->whereBetween('created_at', $interval)->get();

        $treatments = Treatment::all();
        $checked_users = array();
        foreach($user_treatments as $user_treatment){
            if ($category_id && ($user_treatment->treatment->category != $category_id)){
                continue;
            }
            $count_total++;
            $patient = $user_treatment->user;
            if ($patient->male){
                $count_male++;
                $age_male[(int)($patient->age/4)]++;
            }
            else{
                $count_female++;
                $age_female[(int)($patient->age/4)]++;
            }

            // first time or not
            if (in_array($patient->id, $checked_users)){
                continue;
            }

            $treatment_count = 0;
            foreach($user_treatments as $_user_treatment){
                if ($_user_treatment->user_id == $patient->id &&
                    ($_user_treatment->tooth_id == $user_treatment->tooth_id) &&
                    ($_user_treatment->treatment->id == $user_treatment->treatment->id)){
                    $treatment_count++;
                }
            }
            if ($treatment_count == 1){
                $count_first++;
            }else if($treatment_count > 1){
                $count_again++;
            }
        }

        return compact(
                        'count_total', 'count_again', 'count_first',
                        'count_male', 'count_female',
                        'age_male', 'age_female'
                );
    }

    private function allCategories($start, $end){
        $categories = TreatmentCategory::all();
    }

    private function validation(Request $request){
        $request->validate([
            'category_id'=>'required|integer',
            'start_date'=>'string|max:10',
            'end_date'=>'string|max:10'
        ]);
    }
}

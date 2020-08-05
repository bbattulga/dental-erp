<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use App\Patient;
use App\Shift;
use App\CheckIn;


class TreatmentTailanController extends Controller
{
    //
    public function index() {
        $start = Date('Y-m-d', strtotime('- 7 Days'));
        $end = Date('Y-m-d');
        $users = Patient::with('checkins', 'checkins.shift')->get();
        return $users;
    }
    
    public function showMonth(Request $request){
        $shifts = array();
        if (empty($request['month'])){
            $shifts = Shift::whereBetween('date', 
                                                [
                                                    Date('Y-m-01'), 
                                                    Date('Y-m-t', strtotime('first day of this month'))
                                                ])->get();
        }
        return $this->getTreatmentData($request['category_id'], $shifts);
    }

    public function showDateBetween(Request $request){

        $category_id = $request['category_id'];
         // user.checkins for determine first or again...
        $patients = Patient::all();
        return $this->getTreatmentData($category_id, $patients, 
                    $request['start_date'], $request['end_date']);
    }

    // obtain data about patients and treatment
    // such as total number of treatments, first time or not and ages...
    // and returns key value pair using compact function.
    private function getTreatmentData($category_id, $users, $start_date, $end_date){
    	
        $count_male = 0;
        $count_female = 0;

        $count_total = 0;
        $count_first = 0;   
        $count_again = 0;

        $age_male = array();
        $age_female = array();
        for ($i=0;$i<=16;$i++) {
            $age_male[$i] = 0;
            $age_female[$i] = 0;
        }

        foreach($users as $user){
        	$checkins = $user->checkins;
            foreach($checkins as $checkin){
                if ($checkin->shift->date < $start_date ||
                    ($checkin->shift->date > $end_date)){
                    continue;
                }
            	// escape  checkins that does not have recorded treatment yet
            	if (!$checkin->treatments){
            		continue;
            	}
                $treatment_count = 0;
                // escape case that does not match category_id
                foreach($checkin->treatments as $user_treatment){
                	if ($category_id != null && ($user_treatment->treatment->category != $category_id)){
                		continue;
                	}
                    $count_total++;
                    $treatment_count++;
	                // calculates user's age at that time...
	                $age = date_diff(date_create($checkin->shift->date), date_create($user->birth_date))->y;
                	// count gender and age
	                if ($user->male){
	                    $count_male++;
	                    $age_male[(int)($age/4)]++;
	                }else{
	                    $count_female++;
	                    $age_female[(int)($age/4)]++;
	                }
                }
                if ($treatment_count == 1){
                    $count_first++;
                }else ($treatment_count > 1){
                    $count_again += $treatment_count-1;
                }
            }
        }
        return compact(
                        'count_total', 'count_again', 'count_first',
                        'count_male', 'count_female',
                        'age_male', 'age_female'
                );
    }

    private function validation(Request $request){
        $request->validate([
            'category_id'=>'required|integer',
            'start_date'=>'string|max:10',
            'end_date'=>'string|max:10'
        ]);
    }
}

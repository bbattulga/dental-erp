<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Patient;
use App\Shift;


class TreatmentTailanController extends Controller
{
    //
    public function index() {
         // user.checkins for determine first or again...
        $shifts = Shift::with('checkins', 'checkins.user', 
	        				'checkins.treatments',
	        				'checkins.treatments.treatment',
	        				'checkins.user.checkins')
                        ->get();
        return $this->getTreatmentData(1, $shifts);
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
        $shifts = Shift::with('checkins', 'checkins.user', 
	        				'checkins.treatments',
	        				'checkins.treatments.treatment',
	        				'checkins.user.checkins')
                        ->where('date', '>=', $request['start_date'])
                        ->where('date', '<=', $request['end_date'])
                        ->get();
        return $this->getTreatmentData($category_id, $shifts);
    }

    // obtain data about patients and treatment
    // such as total number of treatments, first time or not and ages...
    // and returns key value pair using compact function.
    private function getTreatmentData($category_id, $shifts){
    	
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

        foreach($shifts as $shift){
        	$checkins = $shift->checkins;
            foreach($checkins as $checkin){
            	// escape  checkins that does not have recorded treatment yet
            	if (!$checkin->treatments){
            		continue;
            	}
                // escape case that does not match category_id
                foreach($checkin->treatments as $user_treatment){
                	if ($category_id != null && ($user_treatment->treatment->category != $category_id)){
                		continue;
                	}
                	$user = $checkin->user;
	                // calculates user's age at that time...
	                $age = date_diff(date_create($shift->date), date_create($user->birth_date))->y;
                	// count gender and age
	                if ($user->male){
	                    $count_male++;
	                    $age_male[(int)($age/4)]++;
	                }else{
	                    $count_female++;
	                    $age_female[(int)($age/4)]++;
	                }
	                // first time or not
	                if ($user->checkins->count() == 1){
	                    $count_first++;
	                }else{
	                    $count_again++;
	                }
	                break; // we need only one case that matches the category
                }
            }
        }
        $count_total = $count_first + $count_again;
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

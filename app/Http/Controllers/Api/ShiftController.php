<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shift;
use App\ShiftType;


class ShiftController extends Controller
{
    //

	public function index(Request $request){

        // return all shifts
        $shifts = Shift::with('appointments', 'appointments.user', 'appointments.checkin' ,'doctor')
            ->get();
        return $shifts;
	}

	public function show(Request $request){

		// show shifts of $date.
		// expects date format YYYY-mm-dd


		$date = $request['date'];

		// give default value
		if (!$date)
			$date = Date('Y-m-d');

		$shifts = Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date' , '=', $date)
            ->get();

		return $shifts;
	}

    public function store(Request $request){
        return Shift::create($request->all());
    }

	public function showBetween(Request $request){

		// show shifts between date1 and date2
		
		// expects date format YYYY-mm-dd
		// has optional doctor_id parameter

		$request->validate(['date1'=>'required|string|max:10',
							'date2'=>'required|string|max:10',
							'id' => 'integer']);

		$date1 = $request['date1'];
		$date2 = $request['date2'];

		// show doctor's shifts data between date1 and date2
		if ($doctor_id = $request['doctor_id']){
			$shifts =  Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
			->where('shifts.user_id', '=', $doctor_id)
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->get();
		}else{
			// show all shifts data between date1 and date2
			$shifts =  Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->get();
		}

		return $shifts;
	}

	public function update(Request $request){
		return Shift::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
		return Shift::destroy($id);
	}


	public function showDate($date){
        if ($date == null){
            $date = Date('Y-m-d');
        }
        return Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date', $date)
            ->get();
    }
    public function today(){
        return Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date', Date('Y-m-d'))
            ->get();    
    }
    public function showDateBetween(Request $request){
        $request->validate([
            'date1' => 'string|max:10',
            'date2' => 'string|max:10',
            'user_id' => 'integer',
        ]);

        $date1 = $request['date1'];
        $date2 = $request['date2'];
        $user_id = $request['doctor_id'];

        if ($user_id == null){
            $shifts =  Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->get();
            return $shifts;
        }

        $shifts =  Shift::with('appointments', 'appointments.user', 'appointments.checkin', 'doctor')
            ->where('shifts.date','>=',$date1)
            ->where('shifts.date', '<=',$date2)
            ->where('shifts.user_id', '=', $user_id)
            ->get();
        return $shifts;
    }

    public function showShiftTypes(){
        return ShiftType::all();
    }

    public function showShiftType($id){
        return ShiftType::findOrFail($id);
    }
}

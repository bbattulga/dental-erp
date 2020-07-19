<?php

use Illuminate\Database\Seeder;
use App\Shift;
use App\ShiftType;
use App\Appointment;
use App\Patient;
use Faker\Factory as Faker;


class AppointmentDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // assign appointments to existing shifts
        $shifts = Shift::where('date', '=', Date('Y-m-d'))->get();
        $faker = Faker::create();

        // appointments interval
        $min = 3;
        $max = 5;

        foreach($shifts as $shift){

        	// number of appointments to each shift
        	$size = $faker->numberBetween($min, $max)  ;

        	$shift_type = $shift->shift_type_id;

        	// initial start time, end time
        	if ($shift_type != ShiftType::evening()){
        		$start = 9;
        		$end = 10;
        	}else{
        		$start = 15;
        		$end = 16;
        	}

        	// assign appointments to shift
        	for($i=0; $i<$size; $i++){

        		// make registered or not
        		 $register = 0;

        		// uncomment this line to create some registered users
        		// $register = $faker->numberBetween(0, 1);

        		if ($register == 1){

        			$patient = factory(Patient::class)->create();
        			$appointment = factory(Appointment::class,1)
        				->create([
        					'shift_id' => $shift->id,
        					'user_id' => $patient->id,
        					'name' => $patient->name,
        					'phone' => $patient->phone_number,
        					'start' => $start,
        					'end' => $end,
        					'created_by' => 2
        				]);
        		}else{
	        		$appointment = factory(Appointment::class, 1)
	        			->create([
	        				'user_id' => 0,
	        				'shift_id' => $shift->id,
	        				'start' => $start,
	        				'end' => $end,
	        				'created_by' => 2
	        			]);
        		}

        		$deltatime = $faker->numberBetween(1, 3);
        		$start = $end;
        		$end += $deltatime;

        		if ($end >= 21)
        			break;

        		if($shift_type == ShiftType::morning() && ($end >= 15))
        			break;
        	}
        }
    }
}

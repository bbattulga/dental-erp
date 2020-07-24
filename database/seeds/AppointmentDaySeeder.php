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

    public static $date;
    public static $min = 5;
    public static $max = 8;

    public function run()
    {
        if (!isset(self::$date)){
            $date = Date('Y-m-d');
        }
        
        // assign appointments to existing shifts
        $shifts = Shift::where('date', '=', self::$date)->get();
        $faker = Faker::create();

        // appointments interval
        $min = self::$min;
        $max = self::$max;

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
        		 $register = $faker->numberBetween(0, 1);

        		if ($register == 1){

        			$patient = factory(Patient::class)->create();
        			$appointment = factory(Appointment::class)
        				->create([
        					'shift_id' => $shift->id,
        					'user_id' => $patient->id,
        					'name' => $patient->name,
        					'phone' => $patient->phone_number,
        					'start' => $this->floatToTime($start),
        					'end' => $this->floatToTime($end)
        				]);
        		}else{
	        		$appointment = factory(Appointment::class)
	        			->create([
	        				'user_id' => 0,
	        				'shift_id' => $shift->id,
	        				'start' => $this->floatToTime($start),
	        				'end' => $this->floatToTime($end)
	        			]);
        		}

        		$deltatime = $faker->numberBetween(1, 4);
                // add random half time
                $deltatime += $faker->numberBetween(0, 1)/2;
        		$start = $end;
        		$end += $deltatime;

        		if ($end >= 21)
        			break;

        		if($shift_type == ShiftType::morning() && ($end >= 15))
        			break;
        	}
        }
    }

    // 9.5 -> 09:30
    private function floatToTime($time){
        $hour = (int) $time;
        $min = $time-$hour;
        $min = 60*$min;

        if ($hour < 10)
            $hour = '0'.$hour;
        if ($min<10)
            $min = '0'.$min;

        return $hour.':'.$min;
    }

}

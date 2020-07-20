<?php

use Illuminate\Database\Seeder;
use App\Shift;
use App\Patient;
use App\Appointment;
use App\CheckIn;
use App\UserTreatments;

use Faker\Factory as Faker;


class WorkLoadDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	// has 50% chance to create new patient
    	// if new patient is created - that is registered
    	// and checkin will be created also
    	// else
    	// only appointment will be created

        $shifts = Shift::where('date', Date('Y-m-d'))->get();

   		$min_patients = 3;
   		$max_patients = 10;

   		$faker = Faker::create();

   		$min_hours = 1;
   		$max_hours = 5;

      $numberoftreatments_min = 2;
      $numberoftreatments_max = 12;

   		foreach($shifts as $shift){

   			$n = $faker->numberBetween($min_patients, $max_patients);
   			$shift_type = $shift->shift_type_id;

   			if ($shift_type == 2)
   				$start = 15;
   			else //full day or morning
   				$start = 9;

   			for($i=0; $i<$n; $i++){

   				$hours = $faker->numberBetween($min_hours, $max_hours);
   				$end = $start+$hours;
   				// exceeds doctor's shift time?
   				if (($shift_type == 1) &&
   					$end > 15)
   					break;
   				else if ($end > 20)
   					break;

   				$patient = factory(Patient::class)->create();

   				$appointment = factory(Appointment::class)->create([
   					'name' => $patient->name,
   					'phone' => $patient->phone_number,
   					'user_id' => $patient->id,
   					'shift_id' => $shift->id,
   					'start' => $start,
   					'end' => $end
   				]);

  				// calc next patient's time
  				$hours = $faker->numberBetween($min_hours, $max_hours);
  				$tinyBreak = $faker->numberBetween(0, 2);
   				$start = $end+$tinyBreak;
   				$end += $hours;

   				// create checkin then treatments and payments
   				$checkin = factory(CheckIn::class)->create([
   					'shift_id' => $shift->id,
   					'user_id' => $patient->id,
   					'state' => 0,
   					'nurse_id' => 0
   				]);

   				$user_treatments = factory(UserTreatments::class)->create([
     					'user_id' => $patient->id,
     					'checkin_id' => $checkin->id
     				],
            $faker->numberBetween($numberoftreatments_min, $numberoftreatments_max)
          );

   				// queue for payment
   				$checkin->update(['state' => 2]);
   			}
   		}
    }
}

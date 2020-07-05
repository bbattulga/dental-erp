<?php

use Illuminate\Database\Seeder;
use App\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        $time_index = 9;
        $hours = 1;
        $start = $time_index;
        $end = $time_index+$hours;

        for ($i=0; $i<10; $i++){

        	 Appointment::create([
	        	'shift_id' => 9,
	        	'user_id' => 0,
	        	'created_by' => 2,
	        	'name' => $faker->name,
	        	'phone' => $faker->numberBetween(80000000, 95000000),
	        	'start' => $start,
	        	'end' => $end
        	]);
        	 $start = $end;
        	 $end += $hours;
        }
    }
}

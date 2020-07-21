<?php

use Illuminate\Database\Seeder;
use App\Patient;
use App\Doctor;
use App\Shift;
use App\CheckIn;
use App\Appointment;
use Faker\Factory as Faker;


class WorkLoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	// make dummies for date1 to date2

        $date2 = Date('Y-m-d');
        $days_before = 6;
        $date1 = Date('Y-m-d', strtotime("- $days_before Days"));

        $doctors = Doctor::all();

        while ($date1 < $date2){

        	
        	
        	$days_before++;
        	$date1 = Date('Y-m-d', strtotime("- $days_before Days"));
        }
    }


}

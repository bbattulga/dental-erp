<?php

use Illuminate\Database\Seeder;

use App\Shift;
use App\Doctor;


class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	$doctors = Doctor::all();

    	// creates current month's 1-30th days
    	// shifts of doctors
    	foreach($doctors as $doctor){

    		$day = 1;
    		$date = Date('Y-m-01');

    		for ($i=1; $i<=7; $i++){
    			$shift = factory(Shift::class)
    				->create([
    					'user_id' => $doctor->id,
    					'date' => $date
    				]);
    			$date = date('Y-m-d', strtotime($date . "+$i days"));
    		}
    	}
    }
}

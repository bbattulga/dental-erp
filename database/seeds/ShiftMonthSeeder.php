<?php

use Illuminate\Database\Seeder;

use App\Shift;
use App\Doctor;


class ShiftMonthSeeder extends Seeder
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

    		$date = Date('Y-m-01', strtotime('+ 1 Months'));

    		for ($i=1; $i<30; $i++){
    			$shift = factory(Shift::class)
    				->create([
    					'user_id' => $doctor->id,
    					'date' => $date
    				]);
    			$date = date('Y-m-d', strtotime($date . "+ 1 Days"));
    		}
    	}
    }
}

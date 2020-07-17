<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Shift;
use App\Patient;


class CheckInsDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create $quantity checkins for shifts of the date
        $quantity = 5;
        $date = Date('Y-m-d');


        $shifts = Shift::where('date', $date)->get();

        foreach($shifts as $shift){
        		factory(CheckIn::class, $quantity)->create([
	        	'shift_id' => $shift->id,
	        	'user_id' => factory(Patient::class)->create()
	        	]);
        	}
        
    }
}

<?php

use Illuminate\Database\Seeder;

use App\Doctor;
use App\Shift;


class ShiftDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors = Doctor::all();

    	// shifts of doctors where date=today
    	$date = Date('Y-m-d');
    	foreach($doctors as $doctor){
			$shift = factory(Shift::class)
				->create([
					'user_id' => $doctor->id,
					'date' => $date
				]);
    	}
    }
}

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

    public static $date;

    public function run()
    {
        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
        
        $doctors = Doctor::all();
        
    	foreach($doctors as $doctor){
			$shift = factory(Shift::class)
				->create([
					'user_id' => $doctor->id,
					'date' => self::$date
				]);
    	}
    }
}

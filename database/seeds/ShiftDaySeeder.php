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
    private static $doctors;

    public function run()
    {
        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
            self::$doctors = Doctor::all();
        
        $doctors = self::$doctors;
        
    	foreach($doctors as $doctor){
			$shift = factory(Shift::class)
				->create([
					'user_id' => $doctor->id,
					'date' => self::$date
				]);
    	}
    }
}

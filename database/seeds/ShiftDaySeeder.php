<?php

use Illuminate\Database\Seeder;

use App\Doctor;
use App\Shift;
use Faker\Factory as Faker;


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
        $faker = Faker::create();
        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
            self::$doctors = Doctor::all();
        
        $doctors = self::$doctors;
        $c = 3;
        if ($faker->numberBetween(1, 4) < 2){
            $c = $faker->numberBetween(1, 2);
        }
    	foreach($doctors as $doctor){
			$shift = factory(Shift::class)
				->create([
					'user_id' => $doctor->id,
					'date' => self::$date,
                    'shift_type_id' => $c
				]);
    	}
    }
}

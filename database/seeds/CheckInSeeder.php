<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Shift;
use Faker\Factory as Faker;
use App\Patient;


class CheckInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static $patients_min = 5;
    public static $patients_max = 6;

    public static $date;
    public function run()
    {
        $faker = Faker::create();

        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
        
        $min = self::$patients_min;
        $max = self::$patients_max;

        $shifts = Shift::where('date', self::$date)->get();

        foreach($shifts as $shift){

            $n = $faker->numberBetween($min, $max);
            $patients = factory(Patient::class, $n)->create();
            foreach($patients as $patient){
                $checkin = factory(CheckIn::class)
                        ->create([
                            'user_id' => $patient->id,
                            'shift_id' => $shift->id,
                            'state' => 0
                        ]);
            }
        }
    }
}

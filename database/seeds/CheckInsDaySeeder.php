<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Shift;
use App\Patient;
use Faker\Factory as Faker;


class CheckInsDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static $date;

    public static $min = 5;
    public static $max = 12;

    // has 15% to pick random when not null
    public static $patients = null;
    public static $treatment_again_chance = 10;

    public function run()
    {
        if (!isset(self::$date)){
            $date = Date('Y-m-d');
        }
        
        $faker = Faker::create();

        //$quantity - number of checkins for shifts of the date
        $quantity = $faker->numberBetween(self::$min, self::$max);
        $date = self::$date;

        $shifts = Shift::with('appointments', 'appointments.user')
                        ->where('date', $date)
                        ->get();

        foreach($shifts as $shift){

                $appointments = $shift->appointments;
                if (!$appointments){
                    continue; // or may create appointments
                }
                foreach($appointments as $appointment){
                    if ($appointment->user_id != 0){
                        $patient = $appointment->user;
                    }
                    else{
                        // register
                        $patient = factory(Patient::class)->create([
                            'name' => $appointment->name,
                            'phone_number' => $appointment->phone
                        ]);
                        $appointment->update(['user_id'=>$patient->id]);
                    }
                    
                    factory(CheckIn::class)->create([
                        'shift_id' => $shift->id,
                        'user_id' => $patient->id
                    ]);
                    
                    $treatment_again = $faker->numberBetween(1, 100);
                    if ($treatment_again <= self::$treatment_again_chance){
                        $patients = Patient::all();
                        $patient = $patients? $patients->random(): factory(Patient::class)->create();
                        factory(CheckIn::class)->create([
                            'shift_id' => $shift->id,
                            'user_id' => $patient->id
                        ]);
                    }
                }
        	}
        
    }
}

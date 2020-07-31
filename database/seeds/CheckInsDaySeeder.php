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
    public static $shifts;
    public static $chance = 100;

    public static $min = 5;
    public static $max = 12;

    // has 15% to pick random when not null
    public static $patients = null;
    public static $treatment_again_chance = 10;

    public function run()
    {
        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
        
        $faker = Faker::create();

        $date = self::$date;

        self::$shifts = Shift::with('appointments', 'appointments.user')
                        ->where('date', $date)
                        ->get();
        if (!self::$shifts){
            $this->call(AppointmentDaySeeder::class);
            self::$shifts = Shift::with('appointments', 'appointments.user')
                        ->where('date', $date)
                        ->get();
        }
        $shifts = self::$shifts;
        foreach($shifts as $shift){

                $appointments = $shift->appointments;
                if (!$appointments){
                    continue; // or may create appointments
                }
                foreach($appointments as $appointment){

                    $c = $faker->numberBetween(1, 100);
                    if ($c>self::$chance){
                        continue;
                    }
                    if ($appointment->user_id != 0){
                        $patient = $appointment->user;
                    }
                    else{
                        // register
                        $patient = factory(Patient::class)->create([
                            'last_name'=>$faker->lastName,
                            'name' => $appointment->name,
                            'phone_number' => $appointment->phone
                        ]);
                    }
                    $checkin = factory(CheckIn::class)->create([
                        'shift_id' => $shift->id,
                        'user_id' => $patient->id
                    ]);

                    $appointment->update([
                        'checkin_id'=>$checkin->id,
                        'user_id'=>$patient->id
                    ]);
                }
        	}
        
    }
}

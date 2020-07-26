<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Patient;
use App\Shift;
use App\UserTreatments;
use App\Doctor;
use App\Transaction;
use App\Nurse;
use Faker\Factory as Faker;


class DoctorTreatmentDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 

    public static $date;
    public static $treatments_min = 3;
    public static $treatments_max = 10;

    public function run()
    {	
        if (!isset(self::$date)){
            $date = Date('Y-m-d');
        }
        
    	$treatments_min = self::$treatments_min;
    	$treatments_max = self::$treatments_max;

        $faker = Faker::create();

        $nurses = Nurse::all();
    	if (count($nurses) == 0){
    		$nurses = factory(Nurse::class, 3)->create();
    	}

        $shifts = Shift::with('checkins', 'checkins.user')
                        ->where('date', self::$date)
                        ->get();

        foreach($shifts as $shift){
            foreach($shift->checkins as $checkin){
                $user_treatments = factory(UserTreatments::class, $faker->numberBetween($treatments_min, $treatments_max))
                                    ->create([
                                            'user_id'=>$checkin->user->id,
                                            'checkin_id'=>$checkin->id
                                        ]);
                $checkin->update(['state'=>2]);

                
            }
        }
    }
}

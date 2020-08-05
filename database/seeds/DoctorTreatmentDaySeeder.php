<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Patient;
use App\Shift;
use App\UserTreatments;
use App\Doctor;
use App\Transaction;
use App\Nurse;
use App\TreatmentNote;
use Faker\Factory as Faker;


class DoctorTreatmentDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 

    public static $date;
    public static $shifts;
    public static $treatments_min = 2;
    public static $treatments_max = 5;

    public function run()
    {	
        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
            $date = self::$date;
        
        
    	$treatments_min = self::$treatments_min;
    	$treatments_max = self::$treatments_max;

        $faker = Faker::create();

        $nurses = Nurse::all();
    	if (count($nurses) == 0){
    		$nurses = factory(Nurse::class, 3)->create();
    	}

            self::$shifts = Shift::with('checkins', 'checkins.user')
                        ->where('date', self::$date)
                        ->get();
        
        $shifts = self::$shifts;
        foreach($shifts as $shift){
            foreach($shift->checkins as $checkin){
                $user_treatments = factory(UserTreatments::class, $faker->numberBetween($treatments_min, $treatments_max))
                                    ->create([
                                            'user_id'=>$checkin->user->id,
                                            'checkin_id'=>$checkin->id,
                                            'created_at'=>self::$date . ' ' . Date('H:i')
                                        ]);
                foreach($user_treatments as $user_treatment){
                    $treatment_note = factory(TreatmentNote::class)->create([
                        'checkin_id'=>$checkin->id,
                        'user_treatment_id'=>$user_treatment->id
                    ]);
                }
                $checkin->update(['state'=>2]);

                
            }
        }
    }
}

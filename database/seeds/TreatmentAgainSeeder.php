<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Patient;
use App\Shift;
use App\UserTreatments;
use App\Doctor;
use App\Transaction;
use App\Nurse;
use App\CheckInState;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;


class TreatmentAgainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 

    public static $treatment_again_chance = 100;
    public static $date;
    public static $min = 1;
    public static $max = 5;

    public static $treatments_min = 2;
    public static $treatments_max = 5;


    public function run()
    {	
        if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }

        $faker = Faker::create();

        $doctors = Doctor::all();

        $patients = Patient::all();
        foreach($patients as $patient){
          	

          	$chance = $faker->numberBetween(1, 100);
          	if ($chance>self::$treatment_again_chance){
          		continue;
          	}

          	$doctor = $doctors->random();
            $again = $faker->numberBetween(self::$min, self::$max);
            for($i=0; $i<$again; $i++)
                $this->forDoctor($faker, $doctor, $patient, self::$treatments_min, self::$treatments_max);
        }
    }

    private function forDoctor($faker, $doctor, $patient, $treatments_min, $treatments_max){
    	$shift = Shift::where('date', self::$date)
    			->where('user_id', $doctor->id)
    			->first();
    	if (!$shift){
    		$shift = factory(Shift::class)->create([
	    		'user_id'=>$doctor->id,
	    		'date'=>self::$date
	    	]);
    	}

    	$nurses = Nurse::all();
    	if (count($nurses) == 0){
    		$nurses = factory(Nurse::class, 3)->create();
    	}
 	  
        $checkin = factory(CheckIn::class)->create([
            'shift_id'=>$shift->id,
            'user_id'=>$patient->id,
            'state'=>CheckInState::treatment_done(),
            'nurse_id'=>$nurses->random()->id
        ]);

        $user_treatments = factory(UserTreatments::class, 
            $faker->numberBetween($treatments_min, $treatments_max))
                            ->create([
            'user_id'=>$patient->id,
            'checkin_id'=>$checkin->id
        ]);

        $total = 0;
        foreach($user_treatments as $user_treatment){
            $total += $user_treatment->price;
        }

        $transaction = factory(Transaction::class)->create([
            'type'=>4,
            'type_id'=>$checkin->id,
            'price'=>$total
        ]);

        $checkin->update([
            'state' => CheckInState::payment_done()
        ]);
        
    }

    private function forAllDoctors(){

    }
}

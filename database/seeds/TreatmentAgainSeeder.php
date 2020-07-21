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
use Illuminate\Support\Facades\Auth;


class TreatmentAgainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 

    public function run()
    {	
        $faker = Faker::create();

        $doctors = Doctor::all();

        $pmin = $faker->numberBetween(3, 5);
        $pmax = $faker->numberBetween(5, 10);

        $patients = Patient::all();
        foreach($patients as $patient){
          	

          	$chance = $faker->numberBetween(1, 10);
          	// 60% chance
          	if ($chance<3){
          		continue;
          	}
          	$patient = $patients->random();
          	$doctor = $doctors->random();
            $tmin = $faker->numberBetween(3, 6);
            $tmax = $faker->numberBetween(6, 12);
            $this->forDoctor($faker, $doctor, $patient, $tmin, $tmax);
        }
    }

    private function forDoctor($faker, $doctor, $patient, $treatments_min, $treatments_max){
    	$today = Date('Y-m-d');

    	$shift = Shift::where('date', Date('Y-m-d'))
    			->where('user_id', $doctor->id)
    			->first();
    	if (!$shift){
    		$shift = factory(Shift::class)->create([
	    		'user_id'=>$doctor->id,
	    		'date'=>$today
	    	]);
    	}

    	$nurses = Nurse::all();
    	if (count($nurses) == 0){
    		$nurses = factory(Nurse::class, 3)->create();
    	}
 	  
        $checkin = factory(CheckIn::class)->create([
            'shift_id'=>$shift->id,
            'user_id'=>$patient->id,
            'state'=>2,
            'nurse_id'=>$nurses->random()->id
        ]);

        $user_treatments = factory(UserTreatments::class, $faker->numberBetween($treatments_min, $treatments_max))
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
            'state' => 3
        ]);
        
    }

    private function forAllDoctors(){

    }
}

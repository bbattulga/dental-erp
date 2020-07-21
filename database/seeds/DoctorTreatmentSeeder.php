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


class DoctorTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 

    public function run()
    {	
        $faker = Faker::create();
    	// set null to create records for all doctors
        $doctor_id = null;

    	// create n treatment records
        $quantity = 10;
        $doctors = Doctor::all();
        foreach($doctors as $doctor){
            $pmin = $faker->numberBetween(3, 5);
            $pmax = $faker->numberBetween(5, 10);
            $tmin = $faker->numberBetween(3, 6);
            $tmax = $faker->numberBetween(6, 12);

            $patients = factory(Patient::class, $faker->numberBetween($pmin, $pmax))->create();
            $this->forDoctor($faker, $doctor, $patients, $tmin, $tmax);
        }
    }

    private function forDoctor($faker, $doctor, $patients, $treatments_min, $treatments_max){
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
 	  
        foreach($patients as $patient){
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
    }

    private function forAllDoctors(){

    }
}

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

        $patients_min = 3;
        $patients_max = 10;

        $treatments_min = 3;
        $treatments_max = 10;

        if ($doctor_id){
            $doctor = Doctor::where('id', $doctor_id)->first();
            $patients_size = $faker->numberBetween($patients_min, $patients_max);
            $patients = factory(Patient::class, $patients_size)->create();
            $this->forDoctor($faker, $doctor, $patients, $treatments_min, $treatments_max);
            return;
        }
        // create records for all doctors

        $doctors = Doctor::all();
        foreach($doctors as $doctor){

            $patients_size = $faker->numberBetween($patients_min, $patients_max);
            $patients = factory(Patient::class, $patients_size)->create();
            $this->forDoctor($faker, $doctor, $patients, $treatments_min, $treatments_max);
        }
    }

    private function forDoctor($faker, $doctor, $patients, $treatments_min, $treatments_max){

    	$shift = Shift::where('date', Date('Y-m-d'))
    			->where('user_id', $doctor->id)
    			->first();
    	if (!$shift){
    		$shift = factory(Shift::class)->create([
	    		'user_id'=>$doctor->id,
	    		'date'=>Date('Y-m-d')
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
                'state'=>0,
                'nurse_id'=>$nurses->random()->id
            ]);

            $checkin->update(['state'=>1]);
            $user_treatments = factory(UserTreatments::class, $faker->numberBetween($treatments_min, $treatments_max))
                                ->create([
                                        'user_id'=>$patient->id,
                                        'checkin_id'=>$checkin->id
                                    ]);

            $checkin->update(['state'=>2])

            $totalPrice = 0;
            foreach($user_treatments as $user_treatment){
                $totalPrice += $user_treatment->price;
            }

            $transaction = factory(Transaction::class)->create([
                'type'=>4,
                'type_id'=>$checkin->id,
                'price'=>$totalPrice
            ]);

            $checkin->update([
                'state' => 3
            ]);
        }
    }

    private function forAllDoctors(){

    }
}

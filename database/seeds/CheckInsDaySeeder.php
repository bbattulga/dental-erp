<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Shift;
use App\Patient;


class CheckInsDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // set null to assign checkins for all shifts of the day
        // set id for doctor
        $doctor_id = null;


        //$quantity - number of checkins for shifts of the date
        $quantity = 5;
        $date = Date('Y-m-d');
        

        // create checkins for doctor with doctor_id
        if ($doctor_id){
            $shift_id = Shift::where('date', $date)
                            ->where('user_id', $doctor_id)
                            ->first()->id;
            if (!$shift_id){
                error_log("shift not found for doctor with id $doctor_id");
                return;
            }

            for ($i=0; $i<$quantity; $i++){
                $patient = factory(Patient::class)->create();
                factory(CheckIn::class)->create([
                'shift_id' => $shift_id,
                'user_id' => $patient->id
                ]);
            }
            return;
        } // if (doctor_id) end

        $shifts = Shift::where('date', $date)->get();
        foreach($shifts as $shift){

                for ($i=0; $i<$quantity; $i++){
                    factory(CheckIn::class)->create([
                    'shift_id' => $shift->id,
                    'user_id' => factory(Patient::class)->create()->id
                    ]);
                }
        	}
        
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Patient;
use App\Doctor;
use App\Shift;
use App\CheckIn;
use App\Appointment;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $faker = Faker::create();

        // make dummies for date1 to date2
        $date1 = Date('Y-m-d', strtotime(Date('Y-m-d') . ' + 1 Days'));
        $date2 = Date('Y-m-d', strtotime('+ 7 Days'));

        // patients for each doctor a day
        $min_users = 1;
        $max_users = 4;

       // $this->call(Refresh::class);

        $doctors = Doctor::all();
        
        while ($date1 <= $date2){

            ShiftDaySeeder::$date = $date1;
            $this->call(ShiftDaySeeder::class);

            AppointmentDaySeeder::$date = $date1;
            AppointmentDaySeeder::$min = $min_users;
            AppointmentDaySeeder::$max = $max_users;
            $this->call(AppointmentDaySeeder::class);

            CheckInsDaySeeder::$date = $date1;
            if ($date1 == Date('Y-m-d')){
                CheckInsDaySeeder::$chance = 50;
            }
            $this->call(CheckInsDaySeeder::class);
            $date1 = Date('Y-m-d', strtotime($date1. ' + 1 Days'));
            continue;
            DoctorTreatmentDaySeeder::$date = $date1;
            $this->call(DoctorTreatmentDaySeeder::class);

            LeaseDaySeeder::$lease_chance = 3;
            LeaseDaySeeder::$date = $date1;
            $this->call(LeaseDaySeeder::class);

            PaymentDaySeeder::$date = $date1;
            $this->call(PaymentDaySeeder::class);
            
            $date1 = Date('Y-m-d', strtotime($date1. ' + 1 Days'));
        }
    }


}

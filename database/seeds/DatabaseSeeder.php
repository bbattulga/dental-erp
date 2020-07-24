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
        $date2 = Date('Y-m-d');
        $date1 = Date('Y-m-d', strtotime('- 1 Days'));

        // patients for each doctor a day
        $min_users = 5;
        $max_users = 15;

        // [0;2] will ba aded for min_users and max_users
        $delta_users = 2;

        $this->call(Refresh::class);
        while ($date1 <= $date2){

            ShiftDaySeeder::$date = $date1;
            $this->call(ShiftDaySeeder::class);

            AppointmentDaySeeder::$date = $date1;
            AppointmentDaySeeder::$min = $min_users;
            AppointmentDaySeeder::$max = $max_users;
            $this->call(AppointmentDaySeeder::class);

            CheckInsDaySeeder::$date = $date1;
            $this->call(CheckInsDaySeeder::class);

            DoctorTreatmentDaySeeder::$date = $date1;
            $this->call(DoctorTreatmentDaySeeder::class);

            LeaseDaySeeder::$date = $date1;
            $this->call(LeaseDaySeeder::class);

            PaymentDaySeeder::$date = $date1;
            $this->call(PaymentDaySeeder::class);
            
            $date1 = Date('Y-m-d', strtotime($date1. ' + 1 Days'));
        }
    }


}

<?php

use Illuminate\Database\Seeder;
use App\Shift;
use App\ShiftType;
use App\Appointment;
use App\Patient;
use App\Doctor;
use Faker\Factory as Faker;


class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = 5;

        // creates brand new $size appointments
        factory(Appointment::class, $size)->create();
    }
}

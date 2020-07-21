<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(

         	// order matters.
         	DoctorSeeder::class,

         	// shift doctors
         	ShiftDaySeeder::class,

         	// create appointments to shifts
         	AppointmentDaySeeder::class
         );
    }
}

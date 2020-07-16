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
         	ShiftSeeder::class,

         	// create appointments to shifts
         	AppointmentSeeder::class
         );
    }
}

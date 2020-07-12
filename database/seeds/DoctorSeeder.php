<?php

use Illuminate\Database\Seeder;
use App\Doctor;
use App\Roles;


class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Doctor::class, 10)
        	->create()
        	->each(function($doctor){
        		$doctor->role()->save(factory())
        	})
    }
}

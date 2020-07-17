<?php

use Illuminate\Database\Seeder;
use App\Doctor;
use App\UserRole;
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
        $quantity = 2;

        factory(Doctor::class, $quantity)
        	->create()
        	->each(function ($doctor){
        		factory(UserRole::class, 1)
        			->create([
        				'user_id' => $doctor->id,
        				'role_id' => Roles::doctor()->id,
        				'state' => 1
        			]);
        	});
    }
}

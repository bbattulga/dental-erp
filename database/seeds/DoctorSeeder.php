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
        $quantity = 5;

        factory(Doctor::class, $quantity)
        	->create()
        	->each(function ($doctor){
                $doctor->update([
                    'email' => 'doctor'.$doctor->name.'@mail.com'
                ]);
        		factory(UserRole::class, 1)
        			->create([
        				'user_id' => $doctor->id,
        				'role_id' => Roles::doctor()->id,
        				'state' => 1
        			]);
        	});
    }
}

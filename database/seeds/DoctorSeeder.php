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


    private static $i = 1;
    public function run()
    {
        //
        $quantity = 5;

        factory(Doctor::class, $quantity)
        	->create()
        	->each(function ($doctor){
                $doctor->update([
                    'email' => 'doctor'.self::$i.'@mail.com'
                ]);
                self::$i++;
        		factory(UserRole::class)
        			->create([
        				'user_id' => $doctor->id,
        				'role_id' => Roles::doctor()->id,
        				'state' => 1
        			]);
        	});
    }
}

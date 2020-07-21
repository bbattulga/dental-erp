<?php

use Illuminate\Database\Seeder;
use App\Nurse;
use App\UserRole;
use App\Roles;


class NurseSeeder extends Seeder
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

        factory(Nurse::class, $quantity)
        	->create()
        	->each(function ($doctor){
                $doctor->update([
                    'email' => 'nurse'.$doctor->id.'@mail.com'
                ]);
        		factory(UserRole::class, 1)
        			->create([
        				'user_id' => $doctor->id,
        				'role_id' => Roles::nurse()->id,
        				'state' => 1
        			]);
        	});
    }
}

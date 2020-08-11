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

        Doctor::all()->delete();
        $i = 1;
        factory(Doctor::class, $quantity)
        	->create()
        	->each(function ($doctor) use ($i){
                $doctor->update([
                    'email' => 'doctor'.$i.'@mail.com'
                ]);
                $i++;
        		factory(UserRole::class, 1)
        			->create([
        				'user_id' => $doctor->id,
        				'role_id' => Roles::doctor()->id,
        				'state' => 1
        			]);
        	});
    }
}

<?php

use Illuminate\Database\Seeder;
use App\UserRole;
use App\Roles;
use App\ShiftType;
use App\TreatmentCategory;
use App\Treatment;
use App\TreatmentSelections;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {      
        $roles = [
                    ['id'=>1, 'name' => 'nurse'],
                    ['id'=>2, 'name' => 'reception'],
                    ['id'=>3, 'name' => 'doctor'],
                    ['id'=>4, 'name' => 'accountant'],
                    ['id'=>5, 'name' => 'admin']
                ];
        foreach($roles as $role){
            factory(Roles::class)->create($role);
        }

        $shift_types = [
                ['id'=>1, 'name' => 'Өглөө'],
                ['id'=>2, 'name' => 'Орой'],
                ['id'=>3, 'name' => 'Бүтэн']
        ];

         $this->call(

         	// order matters.
         	DoctorSeeder::class,

         	// shift doctors
         	ShiftDaySeeder::class,

         	// create appointments to shifts
         	AppointmentDaySeeder::class,

            ToothSeeder::class,
            ToothTypeSeeder::class
         );
    }
}

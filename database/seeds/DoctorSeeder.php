<?php

use Illuminate\Database\Seeder;
use App\Doctor;

<<<<<<< HEAD
<<<<<<< HEAD:database/seeds/DoctorSeeder.php
class DoctorSeeder extends Seeder
=======
use App\UserRole;


class UserRoleSeeder extends Seeder
>>>>>>> temp:database/seeds/UserRoleSeeder.php
=======

class DoctorSeeder extends Seeder
>>>>>>> temp
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
<<<<<<< HEAD
<<<<<<< HEAD:database/seeds/DoctorSeeder.php
        factory(Doctor::class, 10)->create();
=======
        factory(UserRole::class, 10);
>>>>>>> temp:database/seeds/UserRoleSeeder.php
=======
        $quantity = 5;


        factory(Doctor::class, $quantity)
        	->create();
>>>>>>> temp
    }
}

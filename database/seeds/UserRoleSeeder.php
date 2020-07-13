<?php

use Illuminate\Database\Seeder;
use App\Doctor;

<<<<<<< HEAD:database/seeds/DoctorSeeder.php
class DoctorSeeder extends Seeder
=======
use App\UserRole;


class UserRoleSeeder extends Seeder
>>>>>>> temp:database/seeds/UserRoleSeeder.php
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
<<<<<<< HEAD:database/seeds/DoctorSeeder.php
        factory(Doctor::class, 10)->create();
=======
        factory(UserRole::class, 10);
>>>>>>> temp:database/seeds/UserRoleSeeder.php
    }
}

<?php

use Illuminate\Database\Seeder;

use App\Roles;
use App\User;
use App\UserRole;


class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // doctor's emails - doctor(1-$doctors)@mail.com 
        // password - doctor(1-$doctors)
        $this->call(DoctorSeeder::class);
        
        // create roles with following convention:
        // email => rolename@mail.com
        // password => rolename
        
        $admin = factory(User::class)->create(['email' => 'admin@mail.com', 
        	                                    'password' => bcrypt('admin'),
        	                                    'role_id' => Roles::admin()->id]);
        UserRole::create([
        	'state'=>1,
        	'user_id' => $admin->id,
        	'role_id' => Roles::admin()->id
        ]);

         
        $reception = factory(User::class)->create(['email'=>'reception@mail.com', 
        	                                    'password'=>bcrypt('reception'),
        	                                    'role_id' => Roles::reception()->id]);
        UserRole::create([
        	'state'=>1,
        	'user_id' => $reception->id,
        	'role_id' => Roles::reception()->id
        ]);

        $accountant = factory(User::class)->create(['email'=>'accountant@mail.com', 
        	                                    'password'=>bcrypt('accountant'),
        	                                    'role_id' => Roles::accountant()->id]);
        UserRole::create([
        	'state'=>1,
        	'user_id' => $accountant->id,
        	'role_id' => Roles::accountant()->id
        ]);
    }
}

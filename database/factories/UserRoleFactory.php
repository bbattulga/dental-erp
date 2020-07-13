<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\UserRole;
use App\Roles;
use App\User;


$factory->define(UserRole::class, function (Faker $faker) {

	$users = User::all()->where('role_id', '!=', null);
	$roles = Roles::all();

    return [
        
        // must be overriden...
        'user_id' => $users->random()->id,
        'role_id' => $roles->random()->id,
        'state' => $faker->numberBetween(0, 1)
    ];
});

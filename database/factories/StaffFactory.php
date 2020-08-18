<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Roles;
use App\User;
use App\Staff;



$factory->define(Staff::class, function (Faker $faker) {

	$roles = Roles::all();
    return factory(User::class)->raw([
    	// overwrite this
    	'role_id' => $roles->random()->id
    ]);
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
<<<<<<< HEAD

$factory->define(Model::class, function (Faker $faker) {
    return [
        //
=======
use App\User;
use App\Appointment;
use App\Roles;

$factory->define(Appointment::class, function (Faker $faker) {

	$start = 9;
	$hours = 2;

	$receptions = User::where('role_id', Roles::reception()->id)
			->get();

    return [
        // must be overriden
        'user_id' => 0,
        'shift_id' => 0,
        'created_by' => $receptions->random()->id,

        'name' => $faker->name,
        'phone' => $faker->numberBetween(86000000, 96000000),
        'start' => $start,
        'end' => $start+$hours,

>>>>>>> temp
    ];
});

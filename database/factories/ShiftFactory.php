<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Doctor;
use App\Roles;
use App\User;
use App\Shift;
use App\Reception;


$factory->define(Shift::class, function (Faker $faker) {

	$date = $faker->dateTimeBetween('now', '7 days')->format('Y-m-d');

    return [

        // should be overriden
    	'user_id' => factory(Doctor::class)->create()->id,

    	// should be overriden
    	'date' => $date,
    	'created_by' => factory(Reception::class)->create()->id,

    	'shift_type_id' => $faker->numberBetween(1, 3),
    ];
});

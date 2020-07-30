<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;
use App\Appointment;
use App\Roles;
use App\Reception;
use App\Shift;


$factory->define(Appointment::class, function (Faker $faker) {

	$start = 9;
	$hours = 2;

    $receptions = Reception::all();

    $reception = count($receptions) == 0? factory(Reception::class)->create():$receptions->random();
    return [
        // should be overriden
        'user_id' => 0,
        'shift_id' => 0,
        'checkin_id' => 0,
        
        'created_by' => $reception->id,

        'name' => $faker->firstName,
        'phone' => $faker->numberBetween(86000000, 96000000),
        'start' => $start,
        'end' => $start+$hours,

    ];
});

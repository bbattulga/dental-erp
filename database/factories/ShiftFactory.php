<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Doctor;
use App\Roles;
use App\User;
use App\Shift;
use App\ShiftType;
use App\Reception;

$factory->define(Shift::class, function (Faker $faker) {

	$receptions = Reception::all();
	$date = $faker->dateTimeBetween('now', '7 days')->format('Y-m-d');
	$shift_type = $faker->numberBetween(1, 3);
    if ($shift_type == 2){
        $shift_type--;
    }
    return [

        // should be overriden
    	'user_id' => 0,

    	// should be overriden
    	'date' => $date,
    	'created_by' => $receptions->count()==0?factory(Reception::class)->create()->id : $receptions->random()->id,
    	'shift_type_id' => $shift_type
    ];
});

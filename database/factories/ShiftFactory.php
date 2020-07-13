<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
<<<<<<< HEAD

$factory->define(Model::class, function (Faker $faker) {
    return [
        //
=======
use App\Doctor;
use App\Roles;
use App\User;
use App\Shift;


$factory->define(Shift::class, function (Faker $faker) {

	$doctors = Doctor::all();

	$receptions = User::where('role_id', Roles::reception()->id)
			->get();

	$date = $faker->dateTimeBetween('now', '7 days')->format('Y-m-d');

    return [

        // must be overriden
    	'user_id' => $doctors->random()->id,

    	// should be overriden
    	'date' => $date,
    	'created_by' => $receptions->random()->id,

    	'shift_type_id' => $faker->numberBetween(1, 3),
>>>>>>> temp
    ];
});

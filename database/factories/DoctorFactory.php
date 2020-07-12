<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Roles;
use App\Doctor;
use Faker\Generator as Faker;

$factory->define(Doctor::class, function (Faker $faker) {
	$doctor_id = Roles::doctor()->id;

	$birth_date = $faker->dateTimeBetween($startDate='-50years', $endDate='-24years');
	$birth_date = $birth_date->format('Y-m-d');

    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'register' => 'ДК'.$faker->numberBetween(00000000, 99999999),
        'phone_number' => $faker->numberBetween(86000000, 96000000),
        'role_id' => $doctor_id,
        'birth_date' => $birth_date,
        'sex' => $faker->numberBetween(0, 1),
        'location' => $faker->address,
        'description' => $faker->text(100),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => $faker->text(10)
    ];
});

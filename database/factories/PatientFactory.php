<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Patient;


$factory->define(Patient::class, function (Faker $faker) {
    $birth_date = $faker->datetimeBetween('-50 years', '-5 years')->format('Y-m-d');

    // null role_id is considered as a patient.

    return [
        'name'=> $faker->firstName,
        'last_name' => $faker->lastName,
        'register' => 'ДК'.($faker->numberBetween(11111111, 99999999)),
        'phone_number' => $faker->numberBetween(86000000, 96000000),
        'email' => $faker->email,
        'sex' => $faker->numberBetween(0, 1),
        'birth_date' => $birth_date,
        'location' => $faker->address,
        'description' => $faker->text(100),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'remember_token' => $faker->text(100)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\Roles;
use App\Doctor;

$factory->define(Doctor::class, function (Faker $faker) {
    $birth_date = $faker->datetimeBetween('-50 years', '-24 years');
	$doctor_id = Roles::doctor()->id;

    $phone = $faker->numberBetween(86000000, 96000000);
    return [
        'name'=> $faker->firstName,
        'last_name' => $faker->lastName,
        'register' => 'ДК'.($faker->numberBetween(11111111, 99999999)),
        'phone_number' => $phone,
        'email' => $faker->email,
        'sex' => $faker->numberBetween(0, 1),
        'birth_date' => $birth_date,
        'location' => $faker->address,
        'description' => $faker->text(100),
        'password' => bcrypt($phone),
        'remember_token' => $faker->text(100),

        'role_id' => $doctor_id
    ];
});

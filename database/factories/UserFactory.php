<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
use App\Roles;

$factory->define(App\User::class, function (Faker $faker) {

	$roles = Roles::all();
    $birth_date = $faker->datetimeBetween('-50 years', '-5 years')->format('Y-m-d');
    
    return [
        'name'=> $faker->firstName,
        'last_name' => $faker->lastName,
        'register' => 'ДК'.($faker->numberBetween(11111111, 99999999)),
        'phone_number' => $faker->numberBetween(86000000, 96000000),
        'email' => $faker->numberBetween(0, 1),
        'sex' => $faker->numberBetween(0, 1),
        'birth_date' => $birth_date,
        'location' => $faker->address,
        'description' => $faker->text(100),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', //secret
        'remember_token' => $faker->text(100),
        'role_id' => $roles->random()->id
    ];
});

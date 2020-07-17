<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Promotion;


$factory->define(Promotion::class, function (Faker $faker) {

	$end_date = $faker->dateTimeBetween('+6 months', '+3 years');

    return [
        //
        'promotion_code' => ''.$faker->numberBetween(10000000, 99999999),
        'promotion_name' => $faker->lastName.	' урамшуулал',
        'percentage' => $faker->numberBetween(10, 100),
        'promotion_end_date' => $end_date
    ];
});

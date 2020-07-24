<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Lease;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

$factory->define(Lease::class, function (Faker $faker) {

	$price = $faker->numberBetween(10000, 100000);
	$total = $faker->numberBetween(100000, 300000);

    return [
        'checkin_id' => 0,

        'price' => $price-$price%10,
        'total' => $total-$total%10,
        'created_by' => 2
    ];
});

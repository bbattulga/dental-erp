<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\UserPromotions;
use App\Roles;
use Illuminate\Support\Facades\Auth;


$factory->define(UserPromotions::class, function (Faker $faker) {
    return [
        'checkin_id' => 0,
        'promotion_id' => 0,
        'created_by' => 2
    ];
});

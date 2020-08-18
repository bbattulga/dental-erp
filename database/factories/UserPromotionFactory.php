<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\UserPromotions;
use App\Roles;
use Illuminate\Support\Facades\Auth;
use App\Reception;


$factory->define(UserPromotions::class, function (Faker $faker) {

	$receptions = Reception::all();

    $reception = count($receptions) == 0? factory(Reception::class)->create():$receptions->random();

    return [
        'checkin_id' => 0,
        'promotion_id' => 0,
        'created_by' => $reception->id
    ];
});

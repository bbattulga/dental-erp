<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;
use App\Reception;
use App\Roles;


$factory->define(Reception::class, function (Faker $faker) {

	$rec_id = Roles::reception()->id;

    return factory(User::class)
    	->raw([
    		'role_id' => $rec_id
    	]);
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Reception;
use App\TransactionCategory;

$factory->define(Transaction::class, function (Faker $faker) {

	$price = $faker->numberBetween(20000, 2000000);
	$type = 4;
	$receptions = Reception::all();
	$reception = count($receptions) == 0? factory(Reception::class)->create():$receptions->random();
    return [
        //
        'price' => $price,
        // should be overriden
        'type_id'=>TransactionCategory::treatment()->id,
        'description'=>'',
        'created_by'=>$reception->id
    ];
});

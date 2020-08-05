<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\TreatmentNote;


$factory->define(TreatmentNote::class, function (Faker $faker) {
	$len1 = $faker->numberBetween(20, 50);
	$len2 = $faker->numberBetween(20, 50);
    return [
        // should be overwritten
        'checkin_id'=>0,
        'user_treatment_id'=>0,
        'symptom'=>'Шинж тэмдэг - '.$faker->text($len1),
        'diagnosis'=>'Онош - ' . $faker->text($len2)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\UserTreatments;
use App\TreatmentSelections;
use App\Treatment;
use App\CheckIn;
use App\Tooth;


$factory->define(UserTreatments::class, function (Faker $faker) {

	$treatments = Treatment::all();
	$tooths = Tooth::fromCache();
	$rand_treatment = $treatments->random();
	$rand_treatment_selection = count($rand_treatment->treatment_selections) == null? 0:$rand_treatment->treatment_selections->random();

    $price = $faker->numberBetween($rand_treatment->price, $rand_treatment->limit);
    $price -= $price%10; // make end 0
    return [
        //must be overwritten
        'user_id' => 0,
        'checkin_id' => 0,

        'treatment_id' => $rand_treatment->id,
        'treatment_selection_id' => $rand_treatment_selection == null? 0: $rand_treatment_selection->id,
        'tooth_id' => $tooths->random()->code,
        'value' =>$rand_treatment->id == 1? $faker->numberBetween(1, 31): 0,
        'decay_level'=>$faker->numberBetween(1,4),
        'price' => $price
    ];
});

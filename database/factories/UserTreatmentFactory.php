<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\UserTreatments;
use App\TreatmentSelections;
use App\Treatment;
use App\CheckIn;
use App\Patient;


$factory->define(UserTreatments::class, function (Faker $faker) {

	$treatments = Treatment::all();
	$tooth_ids = range(11, 38);
	$decay_value_ids = array();
	$decays = $faker->numberBetween(1, 7);
	for ($i=0; $i<$decays; $i++){
		array_push($decay_value_ids, pow(2, 1+($faker->numberBetween(0, 5)%32)));
	}

	$rand_treatment = $treatments->random();
	$rand_treatment_selection = count($rand_treatment->treatment_selections) == null? 0:$rand_treatment->treatment_selections->random();

    return [
        //should be overriden
        'user_id' => factory(Patient::class)->create()->id,
        'checkin_id' => factory(CheckIn::class)->create()->id,
        'treatment_id' => $rand_treatment->id,
        'treatment_selection_id' => $rand_treatment_selection == null? 0: $rand_treatment_selection->id,
        'tooth_id' => array_rand($tooth_ids),
        'value' => array_rand($decay_value_ids),
        'price' => $rand_treatment->price
    ];
});

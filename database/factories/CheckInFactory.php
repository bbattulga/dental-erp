<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Doctor;
use App\Shift;
use App\Patient;
use App\ShiftType;
use App\Reception;
use App\CheckIn;

$factory->define(CheckIn::class, function (Faker $faker) {

	$receptions = Reception::all();
	$reception = $receptions->count() == 0? factory(Reception::class)->create():$receptions->random();

    return [
        //
        'shift_id' => factory(Shift::class)->create([
        	'shift_type_id' => ShiftType::all()->random()->id
        ])->id,
        'user_id' => factory(Patient::class)->create()->id,
        'state' => 0,
        'created_by' => $reception->id,
        'nurse_id' => 0
    ];
});

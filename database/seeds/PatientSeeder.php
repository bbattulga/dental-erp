<?php

use Illuminate\Database\Seeder;

use App\Patient;


class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $quantity = 10;


        factory(Patient::class, $quantity);
    }
}

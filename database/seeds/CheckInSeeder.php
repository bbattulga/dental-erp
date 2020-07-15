<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\Shift;
use App\Patient;


class CheckInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $quantity = 5;
        factory(CheckIn::class, $quantity)->create([
        	'shift_id' => 820
        ]);
        
    }
}

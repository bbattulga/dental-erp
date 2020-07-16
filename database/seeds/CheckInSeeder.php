<?php

use Illuminate\Database\Seeder;
use App\CheckIn;


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
        factory(CheckIn::class, $quantity)->create();
        
    }
}

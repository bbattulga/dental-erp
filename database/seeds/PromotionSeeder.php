<?php

use Illuminate\Database\Seeder;
use App\Promotion;


class PromotionSeeder extends Seeder
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
        factory(Promotion::class, $quantity)->create();
    }
}

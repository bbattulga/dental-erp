<?php

use Illuminate\Database\Seeder;
use App\Tooth;


class TempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call(PromotionSeeder::class);
    }
}

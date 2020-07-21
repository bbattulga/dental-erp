<?php

use Illuminate\Database\Seeder;
use App\Tooth;


class ToothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tooth_codes = range(11, 38);
        foreach($tooth_codes as $tooth_code){
        	Tooth::create([
        		'code' => $tooth_code,
        		'name' => 'Шүд '.$tooth_code
        	]);
        }
    }
}

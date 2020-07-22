<?php

use Illuminate\Database\Seeder;
use App\ToothType;


class ToothTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type_names = ['Сүүн шүд', 'Ясан шүд', 'Байхгүй шүд'];

        foreach($type_names as $type_name){
        	ToothType::create([
        		'name' => $type_name
        	]);
        }
    }
}

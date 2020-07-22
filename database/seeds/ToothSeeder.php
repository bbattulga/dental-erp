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
        $tooth_codes_arrays = [
            range(11, 18),
            range(21, 28),
            range(31, 38),
            range(41, 48)
        ];

        foreach($tooth_codes_arrays as $tooth_codes){
            foreach($tooth_codes as $tooth_code){
                Tooth::create([
                    'code' => $tooth_code,
                    'name' => 'Шүд '.$tooth_code
                ]);
            }
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\TransactionCategory;

class TransactionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
	     * Run the database seeds.
	     *
	     * @return void
	     */
	        //
	        //1->Tsalin
	        //2->Material
	        //3->Busad
	        //4->Emchilgee - orlogo
	        //5->Busad - orlogo
	        //6->item orlogo
	        //7->item zarlaga

        // order kinda matters.
        $type_names = [
            'Цалин',
            'Материал',
            'Эмчилгээ',
            'Бараа',
            'Бусад'
        ];
        $transaction_types = [];
        for ($i=0; $i<count($type_names); $i++){
            array_push($transaction_types, ['id'=>$i+1, 'name'=>$type_names[$i]]);
        }

        foreach ($transaction_types as $type){
            TransactionCategory::firstOrCreate($type);
        }
    }
}

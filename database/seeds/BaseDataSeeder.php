<?php

use Illuminate\Database\Seeder;
use App\UserRole;
use App\Roles;
use App\ShiftType;
use App\TreatmentCategory;
use App\Treatment;
use App\TreatmentSelections;
use App\ToothType;
use App\Tooth;


class BaseDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {      
        $roles = [
                    ['id'=>1, 'name' => 'nurse'],
                    ['id'=>2, 'name' => 'reception'],
                    ['id'=>3, 'name' => 'doctor'],
                    ['id'=>4, 'name' => 'accountant'],
                    ['id'=>5, 'name' => 'admin']
                ];
        foreach($roles as $role){
            Roles::create($role);
        }

        $shift_types = [
                ['id'=>1, 'name' => 'Өглөө'],
                ['id'=>2, 'name' => 'Орой'],
                ['id'=>3, 'name' => 'Бүтэн']
        ];
        foreach($shift_types as $st){
            ShiftType::create($st);
        }   

        $treatment_categories = [
            ['id' => 1, 'name' =>  'Эмчилгээ'],
            ['id' => 2, 'name' =>  'Гажиг засал'],
            ['id' => 3, 'name' =>  'Согог засал'],
            ['id' => 4, 'name' =>  'Мэс засал'],
        ];
        foreach($treatment_categories as $tc){
            TreatmentCategory::create($tc);
        }

        $this->call(ToothSeeder::class);
        $this->call(PromotionSeeder::class);
        $this->class(DoctorSeeder::class);

        $treatments = [
            ['id' => 1, 'name'=>'Ломбо', 'selection_type'=>1, 'category'=>1, 'price'=>12000, 'limit'=>500000],
            ['id' => 3, 'name'=>'Бүрээс', 'selection_type'=>1, 'category'=>1, 'price'=>12000, 'limit'=>200000],
            ['id' => 4, 'name'=>'Шүд авах', 'selection_type'=>1, 'category'=>2, 'price'=>200000, 'limit'=>1000000],
            ['id' => 5, 'name'=>'Шүд суулгах', 'selection_type'=>1, 'category'=>2, 'price'=>200000, 'limit'=>3000000],
            ['id' => 6, 'name'=>'Паалан', 'selection_type'=>1, 'category'=>1, 'price'=>200000, 'limit'=>2500000],
            ['id' => 7, 'name'=>'Post', 'selection_type'=>1, 'category'=>1, 'price'=>20000, 'limit'=>200000],
            ['id' => 8, 'name'=>'Post cast', 'selection_type'=>0, 'category'=>2, 'price'=>200000, 'limit'=>3000000],
            ['id' => 9, 'name'=>'Сувгийн эмчилгээ', 'selection_type'=>1, 'category'=>1, 'price'=>50000, 'limit'=>150000],
            ['id' => 24, 'name'=>'Шүд цайруулах', 'selection_type'=>0, 'category'=>1, 'price'=>100000, 'limit'=>500000],
        ];
        foreach($treatments as $t){
            Treatment::create($t);
        }

        $treatment_selections = [
            ['id'=>1, 'treatment_id'=>4, 'name'=>'Орос мэдээ алдуулагчтай', 'price'=>200000, 'limit'=>1000000],
            ['id'=>2, 'treatment_id'=>3, 'name'=>'Энгийн', 'price'=>200000, 'limit'=>1000000],
            ['id'=>3, 'treatment_id'=>5, 'name'=>'Энгийн', 'price'=>200000, 'limit'=>1000000],
            ['id'=>4, 'treatment_id'=>1, 'name'=>'Орос ломбо', 'price'=>200000, 'limit'=>1000000],
            ['id'=>5, 'treatment_id'=>1, 'name'=>'Япон ломбо', 'price'=>200000, 'limit'=>1000000],
            ['id'=>6, 'treatment_id'=>9, 'name'=>'Энийн', 'price'=>200000, 'limit'=>1000000],
            ['id'=>7, 'treatment_id'=>8, 'name'=>'Энгийн', 'price'=>200000, 'limit'=>1000000],
        ];
        foreach($treatment_selections as $ts){
            TreatmentSelections::create($ts);
        }

        $tooth_types = [
            ['id'=>1, 'name'=>'Сүүн шүд'],
            ['id'=>2, 'name'=>'Ясан шүд'],
            ['id'=>3, 'name'=>'Байхгүй шүд'],
        ];
        foreach($tooth_types as $tt){
            ToothType::create($tt);
        }
    }
}

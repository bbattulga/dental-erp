<?php

use Illuminate\Database\Seeder;
use App\CheckIn;
use App\UserTreatments;
use App\Lease;
use App\Transaction;
use App\Promotion;
use App\UserPromotions;
use App\Shift;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;


class PaymentDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static $date;
    public static $shifts;


    public function run()
    {
    	if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
        
    	$faker = Faker::create();

    		self::$shifts = Shift::with('checkins')
    					->where('date', self::$date)
    					->get();
    	
    	$shifts = self::$shifts;

        foreach($shifts as $shift){
        	if ($shift->date == Date('Y-m-d')){
        		if ($faker->numberBetween(50, 100) > 70){
        			continue;
        		}
        	}
        	$checkins = $shift->checkins;
        	foreach($checkins as $checkin){
	        	$this->checkinPayment($checkin, $faker);
        	}
        }
    }

    private function checkinPayment($checkin, $faker){
    	$user_treatments = UserTreatments::where('checkin_id', $checkin->id)->get();
	        	$total = 0;
	        	foreach($user_treatments as $user_treatment){
	        		$total += $user_treatment->price;
	        	}
		$promotion_percentage = 0;
		$promotion_chance = $faker->numberBetween(1, 10);
		if ($promotion_chance == 1){
			$promotions = Promotion::where('promotion_end_date', '>=', Date('Y-m-d'))->get();
			$promotion = factory(Promotion::class)->create();
			$promotion_percentage = $promotion->percentage;

			factory(UserPromotions::class)->create([
				'checkin_id' => $checkin->id,
				'promotion_id' => $promotion->id
			]);
		}

		if ($checkin->lease && $checkin->lease->price > 0){
			$this->solveLease($checkin);
			return;
		}
		$checkin->update(['state'=>3]);
		$payment = $total-$total*$promotion_percentage/100;
		factory(Transaction::class)->create([
			'price' => (int)$payment,
			'type' => 4,
			'type_id' => $checkin->id,
			'description' => $promotion_percentage == 0? '':'Урамшуулал ашиглаж төлбөр төлсөн',
			'created_at' => 
		]);
    }


    private function solveLease($checkin, $promotion_percentage){

    	$lease = $checkin->lease;
    	if ($lease->price >= 30000){
			$paid = $lease->price*$faker->numberBetween(50, 60)/100;
			$paid = intval($lease-$paid);
			$lease->update('price',(int) $paid);
			factory(Transaction::class)->create([
				'price'=>(int) $paid,
				'type'=>4,
				'type_id'=>$checkin->id,
				'description'=>$promotion_percentage==0? 'Зээлтэй төлбөр төлөгдсөн': 'Зээлтэй. Урамшуулал ашиглаж төлбөр төлсөн'
			]);
			$checkin->update(['state'=>3]);
			return;
		}

		$paid = $lease->price-$lease->price*$promotion_percentage;
		$lease->update('price', 0);
		factory(Transaction::class)->create([
			'price'=>(int) $paid,
			'type'=>4,
			'type_id'=>$checkin->id,
			'description'=>$promotion_percentage==0? 'Зээлтэй төлбөр төлөгдсөн': 'Зээлтэй. Урамшуулал ашиглаж төлбөр төлсөн'
		]);
		$checkin->update(['state'=>4]);
    }
}

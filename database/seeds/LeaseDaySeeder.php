<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Lease;
use App\Transaction;
use App\CheckIn;
use App\Shift;


class LeaseDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static $date;
    public static $shifts;
    public static $lease_chance;

    public function run()
    {
    	if (!isset(self::$date)){
            self::$date = Date('Y-m-d');
        }
        
        $faker = Faker::create();

        if (!isset(self::$shifts)){
            self::$shifts = Shift::with('checkins', 'checkins.treatments')
                    ->where('date', self::$date)
                    ->get();
        }
        $shifts = self::$shifts;

        foreach($shifts as $shift){
        	foreach($shift->checkins as $checkin){
        		$this->dummyLease($checkin, $faker);
        	}
        }
    }

    private function dummyLease($checkin, $faker){
        if (!isset(self::$lease_chance)){
            self::$lease_chance = 10;
        }
        
    	$lease_chance = $faker->numberBetween(1, 100);
    	if ($lease_chance > self::$lease_chance){
    		return;
    	}

        $total = 0;
        foreach($checkin->treatments as $user_treatments){
            $total += $user_treatments->price;
        }
		$lease = $total*$faker->numberBetween(20, 60)/100;
        $lease = (int) $lease;
		$lease -= $lease%10;
		factory(Lease::class)->create([
			'total' => $total,
			'price' => (int)$lease,
			'checkin_id' => $checkin->id
		]);

		factory(Transaction::class)->create([
			'price'=>(int)$total,
			'type'=>4,
			'type_id'=>$checkin->id,
			'description'=>'Зээлийн урьдчилгаа төлбөр'
		]);

        $checkin->update(['state'=>3]);
    }
}

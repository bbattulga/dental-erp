<?php

use Illuminate\Database\Seeder;
use App\Patient;
use App\Doctor;
use App\Shift;
use App\CheckIn;
use App\ShiftType;
use App\Reception;
use App\Appointment;
use App\UserTreatments;
use App\TreatmentNote;
use Illuminate\Support\Facades\Auth;
use App\Lease;
use App\Transaction;
use App\Promotion;
use App\UserPromotions;
use Faker\Factory as Faker;


class DateBetweenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private static $treatments_min = 1;
    private static $treatments_max = 3;

    private static $min_users = 2;
    private static $max_users = 4;

    private static $lease_chance = 3;

    private static $faker;

    private static $as;
    private static $ae;

    private static $register_chance = 50;
    private static $treatment_again_min = 1;
    private static $treatment_again_max = 2;

    public static $date1;
    public static $date2;

    // current date1 in loop
    public static $current_date;

    // show some lease, appointments
    // if 7, then start record lease, appointments from $date2-7 date.
    public static $real_date = 7;


    public function run()
    {   
        self::$faker = Faker::create();

        // make dummies for date1 to date2
        if (empty(self::$date1)){
            $date1 = Date('Y-m-d', strtotime('- 7 Days'));
        }
        if (empty(self::$date2)){
            $date2 = Date('Y-m-d');
        }

        $date1 = self::$date1;
        $date2 = self::$date2;

        // patients for each doctor a day
        $min_users = 2;
        $max_users = 4;

        $doctors = Doctor::all();
        $patients = Patient::all();
        while ($date1 <= $date2){

            self::$current_date = $date1;

            // escape saturday sunday
            $w = Date('w', strtotime($date1));
            if ($w%6 == 0){
                $date1 = Date('Y-m-d', strtotime($date1. ' + 1 Days'));
                continue;
            }
        	// escape sunday
            foreach($doctors as $doctor){

                $shift_type = self::$faker->numberBetween(1, 100) < 10? ShiftType::evening():ShiftType::full();
                $day_start = '09:00';
                if ($shift_type == ShiftType::evening()){
                    $day_start = '15:00';
                }

                $shift = factory(Shift::class)->create([
                    'user_id' => $doctor->id,
                    'shift_type_id'=>$shift_type,
                    'date'=>$date1
                ]);

                // initial start time, end time
                if ($shift_type != ShiftType::evening()){
                    self::$as = 9 + self::$faker->numberBetween(0, 2);
                    self::$ae = self::$as+self::$faker->numberBetween(1, 2);
                }else{
                    self::$as = 15 + self::$faker->numberBetween(0, 1);
                    self::$ae = 16 + self::$faker->numberBetween(0, 1);
                }

                if ($this->delta_days($date1, $date2) <= self::$real_date)
                    $n_patients = self::$faker->numberBetween(self::$min_users, self::$max_users);
                else
                    $n_patients = self::$faker->numberBetween(0, 1);

                $patients = factory(Patient::class, $n_patients)
                    ->create()->each(function($patient) use ($shift){

                        if (self::$ae >= 21)
                            return;

                        $this->new_patient(self::$faker, $patient, $shift,$this->floatToTime(self::$as), 
                                                                            $this->floatToTime(self::$ae));



                        $deltatime = self::$faker->numberBetween(2, 4);
                        // add random half time
                        $deltatime += self::$faker->numberBetween(0, 1)/2;
                        $gap = self::$faker->numberBetween(0, 2)/2;
                        self::$as = self::$ae;
                        self::$as += $gap;
                        self::$ae += $deltatime;

                        // if($shift_type == ShiftType::morning() && ($end >= 15))
                        //     break;
                    });
            }
            $date1 = Date('Y-m-d', strtotime($date1. ' + 1 Days'));
        }

        // treatment again
        $patients = Patient::all();
        $shifts = Shift::whereBetween('date', [self::$date1, self::$date2])->get();
    }

    private function new_patient($faker, $patient, $shift , $as, $ae){

        // make some appointments and others...
        if ($shift->date > Date('Y-m-d')){
            if (self::$faker->numberBetween(1, 100) > self::$register_chance){
                $appointment = factory(Appointment::class)->create([
                    'user_id'=>0,
                    'shift_id'=>$shift->id,
                    'checkin_id'=>0,
                    'start'=>$as,
                    'end'=>$ae
                ]);
            }else{
                $checkin = factory(CheckIn::class)->create([
                            'user_id'=>$patient->id,
                            'shift_id'=>$shift->id,
                            'state'=>0
                        ]);
                $appointment = factory(Appointment::class)->create([
                    'user_id'=>$patient->id,
                    'shift_id'=>$shift->id,
                    'checkin_id'=>$checkin->id,
                    'start'=>$as,
                    'end'=>$ae
                ]);
            }
            return;
        }

        if ($shift->date >= Date('Y-m-d')){
            factory(Patient::class, 10)->create()
                    ->each(function($patient) use ($shift){
                        factory(CheckIn::class, 1)->create([
                        'user_id'=>$patient->id,
                        'shift_id'=>$shift->id,
                        'state'=>0,
                    ]);
                });
        }
        $treatments_count = $faker->numberBetween(self::$treatment_again_min, self::$treatment_again_max);
        $checkins = factory(CheckIn::class, $treatments_count)->create([
                            'user_id'=>$patient->id,
                            'shift_id'=>$shift->id,
                            'state'=>2
        ]);

        foreach($checkins as $checkin){

            if ($this->delta_days(self::$current_date, self::$date2) <= self::$real_date){
                $appointment = factory(Appointment::class)->create([
                    'user_id'=>$patient->id,
                    'shift_id'=>$shift->id,
                    'checkin_id'=>$checkin->id,
                    'start'=>$as,
                    'end'=>$ae
                ]);
            }

            $user_treatments = factory(UserTreatments::class, 
                                $faker->numberBetween(self::$treatments_min, self::$treatments_max))
                                    ->create([
                                            'user_id'=>$checkin->user->id,
                                            'checkin_id'=>$checkin->id,
                                            'created_at'=>$shift->date . ' ' . Date('H:i')
                                        ]);
            foreach($user_treatments as $user_treatment){
                $treatment_note = factory(TreatmentNote::class)->create([
                    'checkin_id'=>$checkin->id,
                    'user_treatment_id'=>$user_treatment->id
                ]);
            }
            
            if ($this->delta_days(self::$current_date, self::$date2)<= self::$real_date){
                if ($faker->numberBetween(1, 100) > 50){
                    $this->checkin_payment($checkin, self::$faker);
                }
                continue;
            }
            $this->dummy_lease($checkin, self::$lease_chance, self::$faker);
            $this->checkin_payment($checkin, self::$faker);
        }
    }

    private function dummy_lease($checkin, $chance, $faker){
        
        $lease_chance = $faker->numberBetween(1, 100);
        if ($lease_chance < $chance){
            return;
        }

        $total = 0;
        foreach($checkin->treatments as $user_treatments){
            $total += $user_treatments->price;
        }
        $lease = $total*$faker->numberBetween(20, 60)/100;
        $lease = intval($lease);
        $lease -= $lease%10;
        factory(Lease::class)->create([
            'total' => $total,
            'price' => $lease,
            'checkin_id' => $checkin->id
        ]);

        factory(Transaction::class)->create([
            'price'=>(int)$total,
            'type'=>4,
            'type_id'=>$checkin->id,
            'description'=>'Зээлийн урьдчилгаа төлбөр',
            'created_at'=>'' . $checkin->shift->date . ' ' . Date('H:i')
        ]);

        $checkin->update(['state'=>3]);
    }

    private function checkin_payment($checkin, $faker){
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
                'promotion_id' => $promotion->id,
                'created_by' =>2
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
            'created_at'=>'' . $checkin->shift->date . ' ' . Date('H:i')
        ]);
    }


    private function solveLease($checkin, $promotion_percentage){

        $lease = $checkin->lease;
        if ($lease->price >= 100000){
            $paid = $lease->price*$faker->numberBetween(50, 60)/100;
            $paid = intval($lease-$paid);
            $lease->update('price',(int) $paid);
            factory(Transaction::class)->create([
                'price'=>(int) $paid,
                'type'=>4,
                'type_id'=>$checkin->id,
                'description'=>$promotion_percentage==0? 'Зээлтэй төлбөр төлөгдсөн': 'Зээлтэй. Урамшуулал ашиглаж төлбөр төлсөн',
                'created_at'=>'' . $checkin->shift->date . ' ' . Date('H:i')
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
            'description'=>$promotion_percentage==0? 'Зээлтэй төлбөр төлөгдсөн': 'Зээлтэй. Урамшуулал ашиглаж төлбөр төлсөн',
            'created_at'=>'' . $checkin->shift->date . ' ' . Date('H:i')
        ]);
        $checkin->update(['state'=>4]);
    }

    // 9.5 -> 09:30
    private function floatToTime($time){
        $hour = (int) $time;
        $min = $time-$hour;
        $min = 60*$min;

        if ($hour < 10)
            $hour = '0'.$hour;
        if ($min<10)
            $min = '0'.$min;

        return $hour.':'.$min;
    }

    private function delta_days($date1, $date2){
        $datediff = strtotime($date2) - strtotime($date1);
        return round($datediff / (60 * 60 * 24));
    }

}

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


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {   
        $this->call(BaseDataSeeder::class);
        $this->call(Refresh::class);

        DateBetweenSeeder::$date1 = Date('Y-m-d', strtotime('- 1 Days'));
        DateBetweenSeeder::$date2 = Date('Y-m-d', strtotime('+ 1 Days'));
        $this->call(DateBetweenSeeder::class);
    }

}

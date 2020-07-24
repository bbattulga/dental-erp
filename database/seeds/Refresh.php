<?php

use Illuminate\Database\Seeder;

use App\Shift;
use App\Patient;
use App\UserTreatments;
use App\Appointment;
use App\CheckIn;
use App\UserPromotions;
use App\Lease;
use App\Transaction;


class Refresh extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Appointment::whereNotNull('id')->delete();
        UserPromotions::whereNotNull('id')->delete();
        UserTreatments::whereNotNull('id')->delete();
        Lease::whereNotNull('id')->delete();
        Transaction::whereNotNull('id')->delete();
        CheckIn::whereNotNull('id')->delete();
        Shift::whereNotNull('id')->delete();
        Patient::whereNotNull('id')->delete();
    }
}

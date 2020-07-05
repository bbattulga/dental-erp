<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFksToDoctorShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_shifts', function (Blueprint $table) {
            //
            $table->index('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');

            $table->index('shift_type_id');
            $table->foreign('shift_type_id')->references('id')->on('shift_types');

            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_shifts', function (Blueprint $table) {
            //
        });
    }
}

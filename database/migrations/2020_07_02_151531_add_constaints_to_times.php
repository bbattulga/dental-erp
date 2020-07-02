<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConstaintsToTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('times', function (Blueprint $table) {
            //
            $table->foreign('shift_id')->references('id')->on('shift_types');

            $table->foreign('created_by')->references('id')->on('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('times', function (Blueprint $table) {
            //
        });
    }
}

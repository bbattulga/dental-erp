<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('times', function (Blueprint $table) {
            $table->increments('id');
            $table->index('doctor_id');
            $table->integer('doctor_id')->unsigned()->default(10);
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->date('date');
            $table->tinyInteger('shift_id');

            $table->integer('created_by')->unsigned()->default(10);
            
            $table->timestamps();
        });


        //
        Schema::table('times', function($table){
            $table->integer('shift_id')->unsigned()->default(10)->change();
            $table->integer('created_by')->unsigned()->default(10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

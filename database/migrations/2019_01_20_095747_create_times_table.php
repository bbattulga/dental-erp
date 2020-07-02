<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesTable extends Migration
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
            $table->integer('doctor_id')->unsigned();
            $table->foreign('doctor_id')->references('id')->on('users');
            
            $table->date('date');

            $table->index('shift_id');
            $table->integer('shift_id')->unsigned();
            $table->foreign('shift_id')->references('id')->on('shift_types');

            $table->index('created_by');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('times');
    }
}

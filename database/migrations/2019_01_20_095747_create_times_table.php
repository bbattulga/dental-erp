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
            $table->integer('doctor_id')->unsigned()->default(10);
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->date('date');
            $table->tinyInteger('shift_id');
            $table->integer('created_by');
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
        Schema::table('times', function($table){
            $table->dropForeign('doctor_id');
            $table->dropIndex('doctor_id');
        });
        
        Schema::dropIfExists('times');
    }
}

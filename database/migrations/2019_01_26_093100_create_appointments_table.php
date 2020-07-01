<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->index('shift_id');
            $table->integer('shift_id')->unsigned()->default(10);
            $table->foreign('shift_id')->references('id')->on('times');

            $table->index('user_id');
            $table->integer('user_id')->unsigned()->default(10);
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name');
            $table->string('phone');
            $table->tinyInteger('start');
            $table->tinyInteger('end');
            $table->integer('created_by'); //the after method is optional.
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

        Schema::table('appointments', function($table){
            $table->dropForeign('shift_id');
            $table->dropIndex('shift_id');

            $table->dropForeign('user_id');
            $table->dropIndex('user_id');
        });
        
        Schema::dropIfExists('appointments');
    }
}

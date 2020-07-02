<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->increments('id');

            $table->index('checkin_id');
            $table->integer('checkin_id')->unsigned();
            $table->foreign('checkin_id')->references('id')->on('check_ins');

            $table->integer('price');
            $table->integer('created_by');
            $table->integer('total');
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
        Schema::table('leases', function($table){
            $table->dropForeign('checkin_id');
        $table->dropIndex('checkin_id');
        });

        Schema::dropIfExists('leases');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatmentSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_selections', function (Blueprint $table) {
            $table->increments('id');

            $table->index('treatment_id');
            $table->integer('treatment_id')->unsigned();
            $table->foreign('treatment_id')->references('id')->on('treatments');

            $table->string('name', 65);
            $table->integer('price');
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
        Schema::table('treatment_selections', function($table){
             $table->dropForeign('treatment_id');
            $table->dropIndex('treatment_id');
        });

        Schema::dropIfExists('treatment_selections');
    }
}

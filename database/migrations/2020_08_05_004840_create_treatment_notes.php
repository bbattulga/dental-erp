<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('checkin_id')->unsigned();
            $table->integer('user_treatment_id')->unsigned();
            $table->string('symptom', 100);
            $table->string('diagnosis', 100);
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
        Schema::dropIfExists('treatment_notes');
    }
}

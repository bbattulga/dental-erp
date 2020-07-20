<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_treatments', function (Blueprint $table) {
            $table->increments('id');

            $table->index('user_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->index('checkin_id');
            $table->integer('checkin_id')->unsigned();
            $table->foreign('checkin_id')->references('id')->on('check_ins');

            $table->index('treatment_id');
            $table->integer('treatment_id')->unsigned();
            $table->foreign('treatment_id')->references('id')->on('treatments');

            $table->integer('treatment_selection_id')->nullable()->unsigned();

            $table->integer('tooth_id')->nullable()->unsigned();
            $table->integer('value')->nullable();
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
        Schema::table('user_treatments', function($table){
             $this->drops($table, ['user_id', 'checkin_id', 'treatment_id', 'treatment_selection_id']);
        });

        
        Schema::dropIfExists('user_treatments');
    }

    private function drops($table, $list){
        foreach($list as $item){
            $table->dropForeign($item);
            $table->dropIndex($item);
        }
    }
}

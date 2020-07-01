<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_promotions', function (Blueprint $table) {
            $table->increments('id');

            $table->index('checkin_id');
            $table->integer('checkin_id')->unsigned()->default(10);
            $table->foreign('checkin_id')->references('id')->on('check_ins');

            $table->index('promotion_id');
            $table->integer('promotion_id')->unsigned()->default(10);
            $table->foreign('promotion_id')->references('id')->on('promotions');

            $table->index('created_by');
            $table->integer('created_by')->unsigned()->default(10);
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
        Schema::table('user_promotions', function($table){
             $table->dropForeign('checkin_id');
        $table->dropIndex('checkin_id');

        $table->dropForeign('promotion_id');
        $table->dropIndex('promotion_id');

        $table->dropForeign('user_id');
        $table->dropIndex('user_id');
        });

        Schema::dropIfExists('user_promotions');
    }
}

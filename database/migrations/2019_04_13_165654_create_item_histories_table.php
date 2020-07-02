<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_histories', function (Blueprint $table) {
            $table->increments('id');

            $table->index('item_id');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');

            $table->integer('quantity');
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
        Schema::table('item_histories', function($table){
             $table->dropForeign('item_id');
        $table->dropIndex('item_id');
        });

        Schema::dropIfExists('item_histories');
    }
}

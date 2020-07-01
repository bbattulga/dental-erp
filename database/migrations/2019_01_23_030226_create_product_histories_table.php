<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_histories', function (Blueprint $table) {
            $table->increments('id');

            $table->index('product_id');
            $table->integer('product_id')->unsigned()->default(10);
            $table->foreign('product_id')->references('id')->on('products');

            $table->index('user_id');
            $table->integer('user_id')->unsigned()->default(10);
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('quantity');
            $table->text('description');
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

        Schema::table('product_histories', function($table){
             $table->dropForeign('product_id');
        $table->dropIndex('product_id');

        $table->dropForeign('user_id');
        $table->dropIndex('user_id');
        });

       

        Schema::dropIfExists('product_histories');
    }
}

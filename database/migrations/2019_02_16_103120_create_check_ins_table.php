<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->increments('id');

            $table->index('shift_id');
            $table->integer('shift_id')->unsigned()->default(10);
            $table->foreign('shift_id')->references('id')->on('times');

            $table->index('user_id');
            $table->integer('user_id')->unsigned()->default(10);
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('state');
            //Emchilgeend oruulsan - 0
            //Emchilgeend duussan - 1
            //Emchilgeenii tulbur tulsun - 2
            $table->integer('created_by');

            $table->index('nurse_id');
            $table->integer('nurse_id')->unsigned()->default(10);
            $table->foreign('nurse_id')->references('id')->on('users');

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
        Schema::table('check_ins', function($table){
             $table->dropForeign('shift_id');
        $table->dropIndex('shift_id');

        $table->dropForeign('user_id');
        $table->dropIndex('user_id');

        $table->dropForeign('nurse_id');
        $table->dropIndex('nurse_id');
        });

        

        Schema::dropIfExists('check_ins');
    }
}

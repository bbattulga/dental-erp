<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConstraintsToTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('times', function (Blueprint $table) {
            //

            $table->integer('shift_id')->unsigned()->nullable()->change();
            $table->index('shift_id');
            $table->foreign('shift_id')->references('id')->on('shift_types')
                ->onDelete('SET NULL');

            $table->integer('created_by')->unsigned()->nullable()->change();
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('times', function (Blueprint $table) {
            //
        });
    }
}

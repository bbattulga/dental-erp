<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColFromShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            //
            $driver = env('DB_CONNECTION');
            if (!($driver === 'sqlite')){
                $table->dropForeign('times_doctor_id_foreign');
                $table->dropIndex('times_doctor_id_index');
            }
            $table->renameColumn('doctor_id', 'user_id');
            
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            //
        });
    }
}

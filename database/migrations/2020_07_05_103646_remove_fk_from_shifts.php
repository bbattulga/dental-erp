<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFkFromShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            
            $driver = env('DB_CONNECTION');
            if (!($driver === 'sqlite')){
                $table->dropForeign('times_doctor_id_foreign');
                $table->dropIndex('times_doctor_id_index');

                $table->dropForeign('times_shift_id_foreign');
                $table->dropIndex('times_shift_id_index');

                $table->dropForeign('times_created_by_foreign');
                $table->dropIndex('times_created_by_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_shifts', function (Blueprint $table) {
            //
        });
    }
}

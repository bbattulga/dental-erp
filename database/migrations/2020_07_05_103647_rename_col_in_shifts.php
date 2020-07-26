<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColInShifts extends Migration
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
             //   $table->dropForeign('times_shift_id');
            if(!Schema::hasColumn('shifts', 'shift_id'))
                return;

            $table->dropForeign('times_shift_id_foreign');
            $table->dropIndex('times_shift_id_index');
            $table->renameColumn('shift_id', 'shift_type_id');
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

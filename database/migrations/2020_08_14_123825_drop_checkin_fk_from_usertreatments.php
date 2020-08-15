<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCheckinFkFromUsertreatments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_treatments', function (Blueprint $table) {
            //
            if (env('DB_CONNECTION') !== 'sqlite'){
                $table->dropForeign('user_treatments_checkin_id_foreign');
                $table->dropIndex('user_treatments_checkin_id_index');
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
        Schema::table('user_treatments', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    at this time, we had no nurse
    so removed nurse_id fk constraint from check_ins
*/
class RemoveNurseIdFkFromCheckIns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_ins', function (Blueprint $table) {
            //
            $table->dropForeign('check_ins_nurse_id_foreign');
            $table->dropIndex('check_ins_nurse_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_ins', function (Blueprint $table) {
            //
        });
    }
}

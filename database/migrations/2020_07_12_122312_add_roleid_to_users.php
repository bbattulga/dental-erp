<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleidToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->index('role_id');
            $table->integer('role_id')->default(1);
            $table->foreign('role_id')->references('id')->on('Roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropIndex('users_index_role_id');
            $table->dropForeign('users_foreign_role_id');
            $table->dropColumn('role_id');
        });
    }
}

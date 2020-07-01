<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();

            $table->index('user_id');
            $table->integer('user_id')->unsigned()->default(10);
            $table->foreign('user_id')->references('id')->on('users');

            $table->index('role_id');
            $table->integer('role_id')->unsigned()->default(10);
            $table->foreign('role_id')->references('id')->on('roles');

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
        Schema::table('user_role', function($table){
            $table->dropForeign('user_id');
            $table->dropIndex('user_id');

            $table->dropForeign('role_id');
            $table->dropIndex('role_id');
        });

        Schema::dropIfExists('user_role');
    }
}

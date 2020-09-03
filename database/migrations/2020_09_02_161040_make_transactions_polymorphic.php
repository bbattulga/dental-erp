<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTransactionsPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('transactions', function($table){
            $table->integer('type_id')->after('id')->unsigned()->change();
            $table->integer('transactionable_id')->after('price')->unsigned();
            $table->renameColumn('type', 'transactionable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('transactions', function($table){
            $table->dropColumn('transactionable_id');
            $table->renameColumn('transactionable_type', 'type');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionBeforeAndAfter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_opname_lists', function (Blueprint $table) {
            $table->integer('condition_before')->after('status');
            $table->integer('condition_after')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_opname_lists', function (Blueprint $table) {
            $table->dropColumn('condition_before');
            $table->dropColumn('condition_after');
        });
    }
}

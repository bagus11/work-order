<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationOnStockOpnameHeaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_opname_headers', function (Blueprint $table) {
            $table->integer('location_id')->after('ticket_code');
            $table->integer('department_id')->after('ticket_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_opname_headers', function (Blueprint $table) {
            $table->dropColumn('location_id');
            $table->dropColumn('department_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestTypeOnDistributionLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution_logs', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->integer('request_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution_logs', function (Blueprint $table) {
            $table->dropColumn('request_type');
            $table->integer('type');
        });
    }
}

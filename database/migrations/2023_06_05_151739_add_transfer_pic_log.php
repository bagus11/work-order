<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferPicLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_order_logs', function (Blueprint $table) {
            $table->integer('transfer_pic');
            $table->string('request_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_order_logs', function (Blueprint $table) {
            $table->dropColumn('transfer_pic');
            $table->dropColumn('request_id');
        });
    }
}

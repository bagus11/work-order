<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAtatchmentColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfp_transaction', function (Blueprint $table) {
            $table->string('attachment')->nullable();
            $table->integer('teamId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfp_transaction', function (Blueprint $table) {
            $table->dropColumn('attachment');
            $table->dropColumn('teamId');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnPicIdOnDistributionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution_details', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->integer('pic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution_details', function (Blueprint $table) {
            $table->dropColumn('pic_id');
            $table->integer('user_id');
        });
    }
}

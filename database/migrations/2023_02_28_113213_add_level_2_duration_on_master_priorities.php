<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevel2DurationOnMasterPriorities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_priorities', function (Blueprint $table) {
            $table->integer('duration_lv2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_priorities', function (Blueprint $table) {
            $table->dropColumn('duration_lv2');
        });
    }
}

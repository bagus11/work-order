<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionOnMasterAssetLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_asset_log', function (Blueprint $table) {
            $table->integer('condition')->default(0)->after('is_active'); // 0: good, 1: damaged, 2: lost
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_asset_log', function (Blueprint $table) {
            $table->dropColumn('condition');
        });
    }
}

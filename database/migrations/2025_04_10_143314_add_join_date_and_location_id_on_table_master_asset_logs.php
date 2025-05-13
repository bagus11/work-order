<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJoinDateAndLocationIdOnTableMasterAssetLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_asset_log', function (Blueprint $table) {
            $table->id()->before('asset_code');
            $table->integer('location_id')->default(1)->after('nik');
            $table->date('join_date')->nullable()->after('nik');
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
            $table->dropColumn('location_id');
            $table->dropColumn('join_date');
            $table->dropColumn('id');
        });
    }
}

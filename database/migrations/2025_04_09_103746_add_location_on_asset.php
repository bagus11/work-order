<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationOnAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_asset', function (Blueprint $table) {
            $table->integer('location_id')->default(1)->after('nik');
            $table->id()->before('asset_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_asset', function (Blueprint $table) {
            $table->dropColumn('location_id');
            $table->dropColumn('id');
        });
    }
}

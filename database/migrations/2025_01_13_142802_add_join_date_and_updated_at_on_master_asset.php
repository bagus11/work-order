<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJoinDateAndUpdatedAtOnMasterAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_asset', function (Blueprint $table) {
            $table->date('join_date')->after('is_active');
            $table->timestamp('updated_at');
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
            $table->dropColumn('join_date');
            $table->dropColumn('updated_at');
        });
    }
}

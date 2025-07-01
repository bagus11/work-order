<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestCodeOnWoNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_notifications', function (Blueprint $table) {
            $table->string('request_code')->after('link');
            $table->integer('type')->default(0)->after('request_code');
            $table->string('table_name')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_notifications', function (Blueprint $table) {
            $table->dropColumn('request_code');
            $table->dropColumn('type');
            $table->dropColumn('table_name');
        });
    }
}

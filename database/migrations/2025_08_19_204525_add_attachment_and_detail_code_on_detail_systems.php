<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentAndDetailCodeOnDetailSystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_systems', function (Blueprint $table) {
            $table->string('detail_code')->after('ticket_code');
            $table->string('attachment')->after('remark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_systems', function (Blueprint $table) {
            $table->dropColumn('detail_code');
            $table->dropColumn('attachment');
        });
    }
}

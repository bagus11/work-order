<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentBeforeOnFileSharingLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_sharing_logs', function (Blueprint $table) {
            $table->string('attachment_before')->after('attachment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_sharing_logs', function (Blueprint $table) {
            $table->dropColumn('attachment_before');
        });
    }
}

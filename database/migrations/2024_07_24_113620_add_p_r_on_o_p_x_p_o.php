<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPROnOPXPO extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opxpo', function (Blueprint $table) {
            $table->string('pr')->after('po');
            $table->integer('user_id')->after('po');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opxpo', function (Blueprint $table) {
            $table->dropColumn('pr');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelegramIdOnMasterDepartement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_departements', function (Blueprint $table) {
            $table->string('telegram_id')->nullable()->after('initial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_departements', function (Blueprint $table) {
            $table->dropColumn('telegram_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartDateOnServiceModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_models', function (Blueprint $table) {
            $table->dateTime('end_date')->nullable();
            $table->dateTime('start_date')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_models', function (Blueprint $table) {
            $table->dropColumn('end_date');
            $table->dropColumn('start_date');
        });
    }
}

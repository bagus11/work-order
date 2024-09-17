<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOfficeAndCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_counting', function (Blueprint $table) {
            $table->integer('officeId');
            $table->integer('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_counting', function (Blueprint $table) {
            $table->dropColumn('officeId');
            $table->dropColumn('categories');
        });
    }
}

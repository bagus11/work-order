<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdOnDistributionnLlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution_logs', function (Blueprint $table) {
            $table->integer('location_id')->nullable()->after('id');
           
            $table->dropColumn('locaton_id'); // Assuming 'location' column is being removed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution_logs', function (Blueprint $table) {
            $table->dropColumn('location_id');
           
            // If you need to restore 'locaton_id', uncomment the next line
            $table->integer('locaton_id')->nullable()->after('id');
        });
    }
}

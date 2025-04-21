<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_details', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->string('detail_code')->unique();
            $table->string('asset_code');
            $table->integer('user_id');
            $table->integer('receiver_id');
            $table->integer('condition');
            $table->integer('status')->default(0);
            $table->string('attachment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribution_details');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRFPDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfp_details', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->integer('user_id');
            $table->string('title');
            $table->string('description');
            $table->integer('status');
            $table->string('detail_code');
            $table->integer('percentage');
            $table->timestamp('dateline');
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
        Schema::dropIfExists('rfp_details');
    }
}

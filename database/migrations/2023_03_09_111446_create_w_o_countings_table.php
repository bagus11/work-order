<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWOCountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_counting', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('done');
            $table->integer('unfinished');
            $table->string('request_for');
            $table->integer('wo_total');
            $table->integer('duration');
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
        Schema::dropIfExists('wo_counting');
    }
}

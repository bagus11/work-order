<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_logs', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->integer('locaton_id');
            $table->integer('des_location_id');
            $table->integer('user_id');
            $table->integer('pic_id');
            $table->integer('receiver_id');
            $table->integer('approval_id');
            $table->integer('status')->default(0);
            $table->integer('type');
            $table->text('notes')->nullable(); 
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
        Schema::dropIfExists('distribution_logs');
    }
}

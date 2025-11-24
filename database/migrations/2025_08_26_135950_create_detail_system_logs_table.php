<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSystemLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->string('detail_code');
            $table->integer('user_id');
            $table->string('remark')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('detail_system_logs');
    }
}

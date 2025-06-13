<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnameLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(0); // 0: draft, 1: submitted, 2: completed
            $table->integer('user_id');
            $table->integer('location_id');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('stock_opname_logs');
    }
}

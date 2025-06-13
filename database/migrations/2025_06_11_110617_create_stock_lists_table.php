<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_lists', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->string('asset_code');
            $table->integer('status');
            $table->integer('condition')->default(0); // 0: good, 1: damaged, 2: lost
            $table->string('attachment')->nullable();
            $table->integer('user_id');
            $table->integer('location_id');
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
        Schema::dropIfExists('stock_lists');
    }
}

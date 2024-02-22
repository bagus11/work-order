<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpexDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opex_detail', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->string('detail_code');
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('is_payment');
            $table->integer('is_taxt');
            $table->integer('is_negotiate');
            $table->integer('is_discount');
            $table->integer('status');
            $table->integer('percentage');
            $table->integer('payment_status');
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
        Schema::dropIfExists('opex_detail');
    }
}

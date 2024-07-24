<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringOPXESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_opx', function (Blueprint $table) {
            $table->id();
            $table->integer('location');
            $table->integer('user_id');
            $table->integer('category');
            $table->integer('product');
            $table->longText('note');
            $table->string('po');
            $table->string('is');
            $table->float('price');
            $table->float('ppn');
            $table->float('dph');
            $table->float('pph');
            $table->date('start_date');
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
        Schema::dropIfExists('monitoring_opx');
    }
}

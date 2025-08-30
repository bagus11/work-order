<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_systems', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->integer('aspect');
            $table->integer('module');
            $table->integer('data_type');
            $table->integer('type');
            $table->string('subject');
            $table->text('remark');
            $table->integer('user_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('status');
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
        Schema::dropIfExists('detail_systems');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpexChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opex_chat', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('request_code');
            $table->integer('detail_code');
            $table->integer('subdetail_code');
            $table->longText('remark');
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
        Schema::dropIfExists('opex_chat');
    }
}

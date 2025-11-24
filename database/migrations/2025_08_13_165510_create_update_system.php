<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_systems', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->integer('user_id');
            $table->string('approval_code');
            $table->integer('step');
            $table->integer('status');
            $table->integer('approval_id');
            $table->integer('pic');
            $table->string('subject');
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
        Schema::dropIfExists('update_systems');
    }
}

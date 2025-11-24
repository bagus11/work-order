<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRFPSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfp_subdetails', function (Blueprint $table) {
            $table->id();
            $table->string('detail_code');
            $table->string('subdetail_code');
            $table->string('title');
            $table->string('description');
            $table->integer('user_id');
            $table->integer('status');
            $table->timestamp('dateline');
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
        Schema::dropIfExists('rfp_subdetails');
    }
}

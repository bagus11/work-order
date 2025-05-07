<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_headers', function (Blueprint $table) {
            $table->id();
            $table->string('request_code')->unique();
            $table->integer('location_id'); 
            $table->integer('des_location_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pic_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('approval_id');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type');
            $table->text('notes')->nullable(); 
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('distribution_headers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->string('request_type');
            $table->string('departement_id');
            $table->string('problem_type');
            $table->string('add_info');
            $table->string('user_id');
            $table->string('assignment');
            $table->string('status_wo');
            $table->string('category');
            $table->string('follow_up');
            $table->string('status_approval');
            $table->string('user_id_support');
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
        Schema::dropIfExists('work_orders');
    }
}

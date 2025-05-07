<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_headers', function (Blueprint $table) {
            $table->id();
            $table->string('incident_code');
            $table->integer('incident_category');
            $table->integer('incident_problem');
            $table->integer('user_id');
            $table->integer('status');
            $table->string('subject');
            $table->longText('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('kode_kantor');
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
        Schema::dropIfExists('incident_headers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnameListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname_lists', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->string('asset_code');
            $table->integer('location_id');
            $table->integer('updated_by')->nullable();
            $table->string('attachment')->nullable();
            $table->text('notes')->nullable();
            $table->integer('status')->default(0); // 0: pending, 1: completed
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
        Schema::dropIfExists('stock_opname_lists');
    }
}

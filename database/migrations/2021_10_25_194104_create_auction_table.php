<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item')->nullable()->index('item_fk');
            $table->tinyInteger('is_open');
            $table->tinyInteger('is_selling');
            $table->tinyInteger('is_approved')->default(0);
            $table->float('starting_price', 10, 0);
            $table->string('bid_constraint', 64)->nullable();
            $table->dateTime('start_time')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->float('closing_price', 10, 0)->nullable();
            $table->dateTime('time_limit')->nullable();
            $table->tinyInteger('is_finished')->nullable()->default(0);
            $table->unsignedInteger('seller')->nullable()->index('seller_fk');
            $table->unsignedInteger('buyer')->nullable()->index('buyer_fk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction');
    }
}

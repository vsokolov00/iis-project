<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item')->index('item_fk');
            $table->tinyInteger('is_open');
            $table->tinyInteger('is_selling');
            $table->tinyInteger('is_approved')->nullable();
            $table->float('starting_price', 10, 0);
            $table->unsignedInteger('bid_min')->nullable();
            $table->unsignedInteger('bid_max')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->float('closing_price', 10, 0)->nullable();
            $table->dateTime('time_limit')->nullable();
            $table->tinyInteger('results_approved')->nullable();
            $table->unsignedInteger('winner')->nullable()->index('winner_fk');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}

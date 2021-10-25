<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAuctioneerOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctioneer_of', function (Blueprint $table) {
            $table->foreign(['auction'], 'auction_fk')->references(['id'])->on('auction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user'], 'auctioneer_fk')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctioneer_of', function (Blueprint $table) {
            $table->dropForeign('auction_fk');
            $table->dropForeign('auctioneer_fk');
        });
    }
}

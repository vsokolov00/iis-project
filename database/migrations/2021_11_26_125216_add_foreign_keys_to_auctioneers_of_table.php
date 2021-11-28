<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAuctioneersOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctioneers_of', function (Blueprint $table) {
            $table->foreign(['auction'], 'auction_fk')->references(['id'])->on('auctions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['user'], 'auctioneer_fk')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctioneers_of', function (Blueprint $table) {
            $table->dropForeign('auction_fk');
            $table->dropForeign('auctioneer_fk');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auction', function (Blueprint $table) {
            $table->foreign(['buyer'], 'buyer_fk')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['item'], 'item_fk')->references(['id'])->on('auction_item')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['seller'], 'seller_fk')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auction', function (Blueprint $table) {
            $table->dropForeign('buyer_fk');
            $table->dropForeign('item_fk');
            $table->dropForeign('seller_fk');
        });
    }
}

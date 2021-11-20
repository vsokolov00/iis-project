<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->foreign(['item'], 'item_fk')->references(['id'])->on('auction_items')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['winner'], 'winner_fk')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropForeign('item_fk');
            $table->dropForeign('winner_fk');
        });
    }
}

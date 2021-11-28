<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToParticipantsOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants_of', function (Blueprint $table) {
            $table->foreign(['participant'], 'part_fk')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['auction'], 'part_of_fk')->references(['id'])->on('auctions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants_of', function (Blueprint $table) {
            $table->dropForeign('part_fk');
            $table->dropForeign('part_of_fk');
        });
    }
}

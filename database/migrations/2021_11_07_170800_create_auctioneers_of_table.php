<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctioneersOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctioneers_of', function (Blueprint $table) {
            $table->unsignedInteger('user');
            $table->unsignedInteger('auction')->index('auction_fk');

            $table->primary(['user', 'auction']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctioneers_of');
    }
}

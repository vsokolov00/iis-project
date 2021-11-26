<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_of', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('participant');
            $table->unsignedInteger('auction')->index('part_of_fk');
            $table->dateTime('registered_at')->nullable();
            $table->tinyInteger('is_approved')->nullable()->default(1);
            $table->decimal('last_bid', 10, 0)->nullable();
            $table->dateTime('date_of_last_bid')->nullable();

            $table->unique(['participant', 'auction'], 'participant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants_of');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_of', function (Blueprint $table) {
            $table->unsignedInteger('participant');
            $table->unsignedInteger('auction')->index('part_of_fk');
            $table->tinyInteger('is_approved')->nullable();
            $table->decimal('last_bid', 10, 0)->nullable();
            $table->dateTime('date_of_last_bid')->nullable();

            $table->primary(['participant', 'auction']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_of');
    }
}

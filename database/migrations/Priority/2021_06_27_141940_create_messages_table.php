<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->morphs('send_to');
            $table->unsignedBigInteger('user_id'); // who is that response to ticket
            $table->unsignedTinyInteger('status_id');
            $table->boolean('seen')->default(false);
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('ticket_statuses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_replays');
    }
}

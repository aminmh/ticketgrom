<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->string('subject', 100);
            $table->unsignedBigInteger('user_id'); // customer (who is that send ticket)
            $table->unsignedBigInteger('department_id');
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('status');
            $table->string('bcc', 200)->nullable();
            $table->string('cc', 200)->nullable();
            $table->unsignedBigInteger('inbox_id');
            $table->unsignedSmallInteger('priority'); // (0 => None | 1 => Low | 2 => Medium | 3 => Hight)
            $table->string('attached', 150)->nullable();
            $table->boolean('seen')->nullable()->default(false);
            $table->float('score', 1, 1, true)->nullable();
            $table->softDeletes();
            $table->timestamp('must_close_at')->nullable();
            $table->timestamps();

            $table->foreign('type')->references('id')->on('ticket_types')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->foreign('inbox_id')->references('id')->on('inboxes')->cascadeOnDelete();
            $table->foreign('status')->references('id')->on('ticket_statuses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}

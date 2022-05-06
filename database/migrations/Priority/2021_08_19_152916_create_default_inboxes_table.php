<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultInboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_inboxes', function (Blueprint $table) {

            $table->morphs('owner');
            $table->unsignedBigInteger('inbox_id');

            $table->foreign('inbox_id')->references('id')->on('inboxes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_inboxes_default');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsMessegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversations_id');
            $table->text('message');
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->tinyInteger('type');
            $table->timestamps();

            $table->foreign('conversations_id')
                  ->references('id')
                  ->on('conversations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations_messeges');
    }
}

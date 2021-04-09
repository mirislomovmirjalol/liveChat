<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_id');
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->timestamp('operator_expire_at');
            $table->string('client_id');
            $table->string('client_ip');
            $table->boolean('client_is_online');
            $table->string('client_staying_page');
            $table->string('client_location')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_phone')->nullable();
            $table->timestamps();

            $table->foreign('website_id')
                  ->references('id')
                  ->on('user_website')
                  ->onDelete('cascade');

            $table->foreign('operator_id')
                  ->references('user_id')
                  ->on('website_operators')
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
        Schema::dropIfExists('conversations');
    }
}

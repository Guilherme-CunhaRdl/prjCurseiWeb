<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user1');
            $table->foreign('id_user1')->references('id')->on('tb_user')->onDelete('cascade');
            $table->unsignedBigInteger('id_user2');
            $table->foreign('id_user2')->references('id')->on('tb_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_chat');
    }
};

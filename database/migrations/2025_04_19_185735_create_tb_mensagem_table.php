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
        Schema::create('tb_mensagem', function (Blueprint $table) {
            $table->id();
            $table->longText('conteudo_mensagem')->nullable();
            $table->boolean('status_mensagem');
            $table->string('img_mensagem', 300)->nullable();
            $table->unsignedBigInteger('id_user_enviador');
            $table->unsignedBigInteger('id_chat');
            $table->unsignedBigInteger('id_post')->nullable();
            $table->foreign('id_post')->references('id')->on('tb_post')->onDelete('cascade');
            $table->foreign('id_chat')->references('id')->on('tb_chat')->onDelete('cascade');
            $table->foreign('id_user_enviador')->references('id')->on('tb_user')->onDelete('cascade');
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
        Schema::dropIfExists('tb_mensagem');
    }
};

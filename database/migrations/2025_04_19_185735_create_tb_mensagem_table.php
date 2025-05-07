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
            $table->longText('conteudo_mensagem');
            $table->enum('status_mensagem',['enviado', 'recebido','visto']);
            $table->unsignedBigInteger('id_user_enviador');
            $table->unsignedBigInteger('id_chat');
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

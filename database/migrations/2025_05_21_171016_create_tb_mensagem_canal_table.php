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
        Schema::create('tb_mensagem_canal', function (Blueprint $table) {
            $table->id();
            $table->longText('conteudo_mensagem_canal');
            $table->string('img_mensagem_canal', 300);
            $table->unsignedBigInteger('id_user_enviador');
            $table->foreign('id_user_enviador')->references('id')->on('tb_user')->onDelete('cascade');
            $table->unsignedBigInteger('id_canal');
            $table->foreign('id_canal')->references('id')->on('tb_canal')->onDelete('cascade');            
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
        Schema::dropIfExists('tb_mensagem_canal');
    }
};

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
        Schema::create('tb_curtei', function (Blueprint $table) {
            $table->id();
            //$table->string('titulo_curtei', 100);
            //$table->longText('descricao_curtei')->nullable();

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tb_user')->onDelete('cascade');

            //$table->unsignedBigInteger('id_conteudo_curtei');
           // $table->foreign('id_conteudo_curtei')->references('id')->on('tb_conteudo_curtei')->onDelete('cascade'); Eu acho que essa tabela não e tão necessaria galera, mas não vou excluir pq sou burro

            $table->string('caminho_curtei');
            $table->string('caminho_curtei_thumb');
            $table->string('legenda_curtei', 220)->nullable();
            

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
        Schema::dropIfExists('tb_curtei');
    }
};

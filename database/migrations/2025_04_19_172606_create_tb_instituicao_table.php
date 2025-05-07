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
        Schema::create('tb_instituicao', function (Blueprint $table) {
            $table->id();
            $table->string('nome_representante', 100);
            $table->string('telefone', 25);
            $table->string('documentos_representante', 25);
            $table->string('cnpj_instituicao', 18);
            $table->boolean('verificado_instituicao');
            $table->string('logradouro_instituicao');
            $table->string('num_logradouro_instituicao', 50);
            $table->string('bairro_instituicao');
            $table->string('cidade_instituicao');
            $table->string('estado_instituicao', 2);
            $table->string('cep_instituicao', 9);
            $table->string('complemento_instituicao')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tb_user')->OnDelete('cascade');
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
        Schema::dropIfExists('tb_instituicao');
    }
};

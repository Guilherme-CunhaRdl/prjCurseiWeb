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
        Schema::create('tb_denuncia', function (Blueprint $table) {
            $table->id();
            $table->string('motivo_denuncia');
            $table->longText('descricao_denuncia')->nullable();
            $table->unsignedBigInteger('id_user_denunciador')->nullable();
            $table->foreign('id_user_denunciador')->references('id')->on('tb_user')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_denunciado')->nullable();
            $table->foreign('id_user_denunciado')->references('id')->on('tb_user')->onDelete('cascade');
            $table->unsignedBigInteger('id_post_denunciado')->nullable();
            $table->foreign('id_post_denunciado')->references('id')->on('tb_post')->onDelete('cascade');
            $table->unsignedBigInteger('id_storyes_denunciado')->nullable();
            $table->foreign('id_storyes_denunciado')->references('id')->on('tb_storyes')->onDelete('cascade');
            $table->unsignedBigInteger('id_curtei_denunciado')->nullable();
            $table->foreign('id_curtei_denunciado')->references('id')->on('tb_curtei')->onDelete('cascade');
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
        Schema::dropIfExists('tb_denuncia');
    }
};

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
        Schema::create('tb_post', function (Blueprint $table) {
            $table->id();
            $table->boolean('status_post');
            $table->string('titulo_post', 150)->nullable();
            $table->string('conteudo_post', 36)->nullable();
            $table->string('descricao_post')->nullable();
            $table->int('repost_id')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tb_user')->onDelete('cascade');
            $table->foreignId('repost_id')->nullable()->constrained('tb_post')->onDelete('cascade');
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
        Schema::dropIfExists('tb_post');
    }
};

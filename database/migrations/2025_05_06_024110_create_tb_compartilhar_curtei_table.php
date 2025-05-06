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
        Schema::create('tb_compartilhar_curtei', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mensagem');
            $table->unsignedBigInteger('id_curtei');
            $table->foreign('id_mensagem')->references('id')->on('tb_mensagem')->onDelete('cascade');
            $table->foreign('id_curtei')->references('id')->on('tb_curtei')->onDelete('cascade');
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
        Schema::dropIfExists('tb_compartilhar_curtei');
    }
};

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
        Schema::create('tb_bloqueado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_bloqueado');
            $table->unsignedBigInteger('id_user_bloqueando');
            $table->foreign('id_user_bloqueado')->references('id')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_user_bloqueando')->references('id')->on('tb_user')->onDelete('cascade');
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
        Schema::dropIfExists('tb_bloqueado');
    }
};

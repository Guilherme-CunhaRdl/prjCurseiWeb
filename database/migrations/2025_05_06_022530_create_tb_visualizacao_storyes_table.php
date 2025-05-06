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
        Schema::create('tb_visualizacao_storyes', function (Blueprint $table) {
            $table->id();
            $table->integer('qtd_visualizacao_storyes')->default(0);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_storyes');
            $table->foreign('id_user')->references('id')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_storyes')->references('id')->on('tb_storyes')->onDelete('cascade');
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
        Schema::dropIfExists('tb_visualizacao_storyes');
    }
};

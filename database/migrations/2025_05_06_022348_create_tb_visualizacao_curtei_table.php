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
        Schema::create('tb_visualizacao_curtei', function (Blueprint $table) {
            $table->id();
            $table->integer('qtd_visualizacao_curtei')->default(0);
            $table->unsignedBigInteger('id_curtei');
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
        Schema::dropIfExists('tb_visualizacao_curtei');
    }
};

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
        Schema::create('tb_storyes', function (Blueprint $table) {
            $table->id();
            $table->string('conteudo_storyes');
            $table->dateTime('data_inicio');
            $table->boolean('status_storyes')->default(true);
            $table->unsignedBigInteger('id_user');
            $table->string('legenda', 220)->nullable();
            $table->string('tipo_midia', 10); 
            $table->timestamps();
    
            $table->foreign('id_user')->references('id')->on('tb_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_storyes');
    }
};

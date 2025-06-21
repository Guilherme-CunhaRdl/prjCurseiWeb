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
         Schema::create('tb_impulsionar', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_post');
            $table->dateTime('data_fim');
            $table->timestamps();

           
         $table->foreign('id_post')->references('id')->on('tb_post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_impulsionar');
    }
};

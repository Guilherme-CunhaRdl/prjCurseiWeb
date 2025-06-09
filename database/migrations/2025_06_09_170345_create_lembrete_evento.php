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
         Schema::create('tb_lembrete_evento', function (Blueprint $table) {
            $table->id();

            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tb_user')->onDelete('cascade');

            
            $table->unsignedBigInteger('id_evento');
            $table->foreign('id_evento')->references('id')->on('tb_evento')->onDelete('cascade');

           

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
        Schema::dropIfExists('lembre_evento');
    }
};

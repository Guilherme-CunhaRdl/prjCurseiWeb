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
        Schema::create('curtida_comentario_curteis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comentario')->constrained('comentario_curteis')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('tb_user')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['id_comentario', 'id_user']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curtida_comentario_curteis');
    }
};

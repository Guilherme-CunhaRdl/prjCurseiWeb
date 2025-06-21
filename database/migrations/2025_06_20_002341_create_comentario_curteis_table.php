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
        Schema::create('comentario_curteis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_curtei')->constrained('tb_curtei')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('tb_user')->onDelete('cascade');
            $table->text('comentario');
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
        Schema::dropIfExists('comentario_curteis');
    }
};

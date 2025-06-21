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
        Schema::create('tb_curtida_curtei', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_curtei');
            $table->timestamps();
        
            $table->foreign('id_user')->references('id')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_curtei')->references('id')->on('tb_curtei')->onDelete('cascade');
            
            $table->unique(['id_user', 'id_curtei']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_curtida_curtei');
    }
};

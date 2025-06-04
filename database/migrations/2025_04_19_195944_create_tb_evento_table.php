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
        Schema::create('tb_evento', function (Blueprint $table) {
            $table->id();
            $table->string('desc_evento', 3000);
            $table->string('link_evento', 3000);
            $table->timestamp('data_inicio_evento');
$table->timestamp('data_fim_evento')->nullable();
            $table->boolean('status_evento');
            $table->unsignedBigInteger('id_post');
            $table->foreign('id_post')->references('id')->on('tb_post');
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
        Schema::dropIfExists('tb_evento');
    }
};

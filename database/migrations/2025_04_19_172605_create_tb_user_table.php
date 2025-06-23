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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id();
            $table->string('nome_user', 100);
            $table->string('email_user', 100)->unique();
            $table->string('senha_user', 100);
            $table->string('img_user', 300)->nullable();
            $table->string('banner_user', 300)->nullable();
            $table->string('token_user', 300)->nullable()->unique();
            $table->boolean('status_user');
            $table->longText('bio_user')->nullable();
            $table->string('arroba_user', 30)->unique();
            $table->boolean('dois_fatores_user')->default(false);
            $table->string('codigo_2fa')->nullable();
            $table->timestamp('codigo_2fa_expira_em')->nullable();
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
        Schema::dropIfExists('tb_user');
    }
};

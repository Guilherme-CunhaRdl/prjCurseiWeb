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
 
        Schema::table('tb_user', function (Blueprint $table) {
            // 1. Remove o nullable()
            $table->string('arroba_user', 30)->nullable(false)->change();
            
            // 2. Adiciona UNIQUE
            $table->unique('arroba_user');
        });
    }

    public function down()
    {
     
        Schema::table('tb_user', function (Blueprint $table) {
            $table->dropUnique(['arroba_user']);
            $table->string('arroba_user', 30)->nullable()->change();
        });
    }
};

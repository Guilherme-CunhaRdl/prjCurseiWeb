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
            Schema::create('destaque_story', function (Blueprint $table) {
                $table->id();
                $table->foreignId('destaque_id')->constrained('tb_destaque')->onDelete('cascade');
                $table->foreignId('story_id')->constrained('tb_storyes')->onDelete('cascade');
                $table->unique(['destaque_id', 'story_id']); // Impede duplicatas
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destaque_story');
    }
};

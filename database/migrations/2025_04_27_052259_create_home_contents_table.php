<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->text('hero_text');
            $table->string('hero_sm_title');
            $table->string('hero_image')->nullable();
            $table->string('card_title');
            $table->text('card_text');
            $table->string('galeri_title');
            $table->string('galeri_sm_title');
            $table->string('video_title');
            $table->string('video_sm_title');
            $table->text('pengantar_title');
            $table->string('pengantar_sm_title');
            $table->text('pengantar_text');
            $table->string('pengantar_image')->nullable();
            $table->string('pengantar_sm_text1');
            $table->string('pengantar_sm_text2');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};

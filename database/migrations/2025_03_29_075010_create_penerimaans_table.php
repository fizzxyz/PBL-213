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
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('dibuka_pada');
            $table->date('ditutup_pada');
            $table->foreignId('unit_pendidikan_id')->constrained()->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('biaya');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaans');
    }
};

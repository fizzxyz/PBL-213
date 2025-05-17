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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('pendaftaran_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('total');
            $table->boolean('is_paid');
            $table->string('metode_pembayaran')->nullable();
            $table->text('bukti_pembayaran')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

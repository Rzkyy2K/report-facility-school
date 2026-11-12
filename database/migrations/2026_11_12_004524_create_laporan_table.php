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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->cascadeOnDelete();
            $table->foreignId('lokasi_id')->constrained('lokasi')->restrictOnDelete();
            $table->foreignId('barang_id')->nullable()->constrained('barang')->nullOnDelete();
            $table->string('nama_barang', 100);
            $table->text('deskripsi_rusak');
            $table->string('foto_kerusakan', 255);
            $table->enum('tingkat_keparahan', ['ringan', 'sedang', 'berat'])->nullable();
            $table->enum('prioritas', ['darurat', 'tinggi', 'menengah', 'rutin'])->nullable();
            $table->enum('status', [
                'menunggu_verifikasi',
                'diajukan_ke_kepsek',
                'disetujui',
                'ditolak',
                'sedang_diperbaiki',
                'selesai',
            ])->default('menunggu_verifikasi')->nullable();
            $table->timestamp('tanggal_lapor')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};

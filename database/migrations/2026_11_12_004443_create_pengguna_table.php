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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('nomor_induk', 30)->unique()->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', [
                'siswa',
                'guru',
                'sarana',
                'kepala_sekolah',
                'teknisi'
            ]);
            $table->string('no_telepon', 20)->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
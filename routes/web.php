<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\PersetujuanController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::get('barang', [BarangController::class, 'index'])->name('barang.index');

    Route::middleware('role:sarana')->group(function () {
        Route::post('lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::put('lokasi/{lokasi}', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('lokasi/{lokasi}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

        Route::post('barang', [BarangController::class, 'store'])->name('barang.store');
        Route::put('barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

        Route::patch('laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    });

    Route::resource('laporan', LaporanController::class)->except(['edit', 'update']);

    Route::middleware('role:kepala_sekolah')->group(function () {
        Route::get('persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::post('laporan/{laporan}/persetujuan', [PersetujuanController::class, 'store'])->name('persetujuan.store');
    });

    Route::get('perbaikan', [PerbaikanController::class, 'index'])
        ->middleware('role:teknisi,sarana')
        ->name('perbaikan.index');

    Route::middleware('role:teknisi')->group(function () {
        Route::post('laporan/{laporan}/perbaikan', [PerbaikanController::class, 'store'])->name('perbaikan.store');
        Route::put('perbaikan/{perbaikan}', [PerbaikanController::class, 'update'])->name('perbaikan.update');
    });
});

require __DIR__.'/settings.php';

<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Laporan;
use App\Models\Lokasi;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the facility reporting dashboard.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        $laporanQuery = Laporan::query()->with(['pengguna', 'lokasi', 'barang']);

        if (in_array($user->role, ['siswa', 'guru'], true)) {
            $laporanQuery->where('pengguna_id', $user->id);
        }

        return Inertia::render('dashboard', [
            'stats' => [
                'total_laporan' => (clone $laporanQuery)->count(),
                'menunggu_verifikasi' => (clone $laporanQuery)->where('status', 'menunggu_verifikasi')->count(),
                'diajukan_ke_kepsek' => (clone $laporanQuery)->where('status', 'diajukan_ke_kepsek')->count(),
                'disetujui' => (clone $laporanQuery)->where('status', 'disetujui')->count(),
                'sedang_diperbaiki' => (clone $laporanQuery)->where('status', 'sedang_diperbaiki')->count(),
                'selesai' => (clone $laporanQuery)->where('status', 'selesai')->count(),
                'total_lokasi' => Lokasi::count(),
                'total_barang' => Barang::count(),
            ],
            'recentLaporan' => $laporanQuery->latest('tanggal_lapor')->limit(5)->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pengguna;
use App\Models\Persetujuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PersetujuanController extends Controller
{
    /**
     * Display reports awaiting approval and approval history.
     */
    public function index(): Response
    {
        return Inertia::render('persetujuan/index', [
            'menungguPersetujuan' => Laporan::query()
                ->with(['pengguna', 'lokasi', 'barang'])
                ->where('status', 'diajukan_ke_kepsek')
                ->latest('tanggal_lapor')
                ->get(),
            'riwayatPersetujuan' => Persetujuan::query()
                ->with(['laporan.lokasi', 'laporan.pengguna', 'pengguna'])
                ->latest('tanggal_persetujuan')
                ->get(),
        ]);
    }

    /**
     * Store a principal approval or rejection for a report.
     */
    public function store(Request $request, Laporan $laporan): RedirectResponse
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        if ($laporan->status !== 'diajukan_ke_kepsek') {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => 'Laporan ini tidak dalam status menunggu persetujuan kepala sekolah.',
            ]);

            return back();
        }

        $validated = $request->validate([
            'status_persetujuan' => ['required', Rule::in(['disetujui', 'ditolak'])],
            'catatan_pimpinan' => ['nullable', 'string'],
            'estimasi_biaya' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
        ]);

        DB::transaction(function () use ($validated, $laporan, $user): void {
            Persetujuan::create([
                'laporan_id' => $laporan->id,
                'pengguna_id' => $user->id,
                'status_persetujuan' => $validated['status_persetujuan'],
                'catatan_pimpinan' => $validated['catatan_pimpinan'] ?? null,
                'estimasi_biaya' => $validated['estimasi_biaya'] ?? 0,
            ]);

            $laporan->update([
                'status' => $validated['status_persetujuan'],
            ]);
        });

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Keputusan persetujuan berhasil disimpan.']);

        return back();
    }
}

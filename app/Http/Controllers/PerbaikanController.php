<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pengguna;
use App\Models\Perbaikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PerbaikanController extends Controller
{
    /**
     * Display approved reports and repair records.
     */
    public function index(): Response
    {
        return Inertia::render('perbaikan/index', [
            'laporanSiapPerbaikan' => Laporan::query()
                ->with(['pengguna', 'lokasi', 'barang', 'persetujuan'])
                ->whereIn('status', ['disetujui', 'sedang_diperbaiki'])
                ->latest('tanggal_lapor')
                ->get(),
            'riwayatPerbaikan' => Perbaikan::query()
                ->with(['laporan.lokasi', 'laporan.barang', 'pengguna'])
                ->latest('tanggal_mulai')
                ->get(),
        ]);
    }

    /**
     * Start a new repair task for an approved report.
     */
    public function store(Request $request, Laporan $laporan): RedirectResponse
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        if (! in_array($laporan->status, ['disetujui', 'sedang_diperbaiki'], true)) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => 'Perbaikan hanya dapat dimulai untuk laporan yang sudah disetujui.',
            ]);

            return back();
        }

        $validated = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'keterangan_tindakan' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $laporan, $user): void {
            Perbaikan::create([
                'laporan_id' => $laporan->id,
                'pengguna_id' => $user->id,
                'tanggal_mulai' => $validated['tanggal_mulai'] ?? now(),
                'keterangan_tindakan' => $validated['keterangan_tindakan'] ?? null,
                'status_pekerjaan' => 'proses',
            ]);

            $laporan->update([
                'status' => 'sedang_diperbaiki',
            ]);
        });

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Proses perbaikan dimulai.']);

        return back();
    }

    /**
     * Update repair progress or mark repair as completed.
     */
    public function update(Request $request, Perbaikan $perbaikan): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_selesai' => ['nullable', 'date'],
            'foto_bukti_selesai' => ['nullable', 'image', 'max:4096'],
            'keterangan_tindakan' => ['nullable', 'string'],
            'status_pekerjaan' => ['required', Rule::in(['proses', 'selesai'])],
        ]);

        $fotoPath = $perbaikan->foto_bukti_selesai;
        $foto = $request->file('foto_bukti_selesai');
        if ($foto instanceof UploadedFile) {
            if ($fotoPath !== null && $fotoPath !== '') {
                Storage::disk('public')->delete($fotoPath);
            }

            $storedPath = $foto->store('perbaikan/bukti', 'public');
            if ($storedPath === false) {
                abort(500, 'Gagal menyimpan foto bukti selesai.');
            }
            $fotoPath = $storedPath;
        }

        $statusPekerjaan = $validated['status_pekerjaan'];
        $tanggalSelesai = $validated['tanggal_selesai']
            ?? ($statusPekerjaan === 'selesai' ? ($perbaikan->tanggal_selesai ?? now()) : null);

        DB::transaction(function () use ($perbaikan, $validated, $fotoPath, $tanggalSelesai, $statusPekerjaan): void {
            $perbaikan->update([
                'tanggal_selesai' => $tanggalSelesai,
                'foto_bukti_selesai' => $fotoPath,
                'keterangan_tindakan' => $validated['keterangan_tindakan'] ?? $perbaikan->keterangan_tindakan,
                'status_pekerjaan' => $statusPekerjaan,
            ]);

            $perbaikan->laporan()->update([
                'status' => $statusPekerjaan === 'selesai' ? 'selesai' : 'sedang_diperbaiki',
            ]);
        });

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Data perbaikan berhasil diperbarui.']);

        return back();
    }
}

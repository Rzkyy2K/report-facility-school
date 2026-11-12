<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Laporan;
use App\Models\Lokasi;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LaporanController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        $query = Laporan::query()
            ->with(['pengguna', 'lokasi', 'barang'])
            ->latest('tanggal_lapor');

        if (in_array($user->role, ['siswa', 'guru'], true)) {
            $query->where('pengguna_id', $user->id);
        }

        $status = $request->query('status');
        if (is_string($status) && $status !== '') {
            $query->where('status', $status);
        }

        return Inertia::render('laporan/index', [
            'laporan' => $query->get(),
            'filters' => [
                'status' => is_string($status) ? $status : null,
            ],
        ]);
    }

    /**
     * Show the form for creating a new report.
     */
    public function create(): Response
    {
        return Inertia::render('laporan/create', [
            'lokasi' => Lokasi::query()->orderBy('nama_ruangan')->get(),
            'barang' => Barang::query()->orderBy('nama_barang')->get(),
        ]);
    }

    /**
     * Store a newly created report.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        $validated = $request->validate([
            'lokasi_id' => ['required', 'integer', 'exists:lokasi,id'],
            'barang_id' => ['nullable', 'integer', 'exists:barang,id'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'deskripsi_rusak' => ['required', 'string'],
            'foto_kerusakan' => ['required', 'image', 'max:4096'],
        ]);

        $foto = $request->file('foto_kerusakan');
        if (! $foto instanceof UploadedFile) {
            abort(422, 'File foto kerusakan tidak valid.');
        }

        $path = $foto->store('laporan/kerusakan', 'public');
        if ($path === false) {
            abort(500, 'Gagal menyimpan foto kerusakan.');
        }

        Laporan::create([
            'pengguna_id' => $user->id,
            'lokasi_id' => $validated['lokasi_id'],
            'barang_id' => $validated['barang_id'] ?? null,
            'nama_barang' => $validated['nama_barang'],
            'deskripsi_rusak' => $validated['deskripsi_rusak'],
            'foto_kerusakan' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Laporan kerusakan berhasil dikirim.']);

        return to_route('laporan.index');
    }

    /**
     * Display the specified report.
     */
    public function show(Request $request, Laporan $laporan): Response
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        if (in_array($user->role, ['siswa', 'guru'], true) && $laporan->pengguna_id !== $user->id) {
            abort(403, 'Anda hanya dapat melihat laporan milik Anda sendiri.');
        }

        $laporan->load([
            'pengguna',
            'lokasi',
            'barang',
            'persetujuan.pengguna',
            'perbaikan.pengguna',
        ]);

        return Inertia::render('laporan/show', [
            'laporan' => $laporan,
        ]);
    }

    /**
     * Verify and triage a report by sarana staff.
     */
    public function verifikasi(Request $request, Laporan $laporan): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat_keparahan' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'prioritas' => ['required', Rule::in(['darurat', 'tinggi', 'menengah', 'rutin'])],
            'status' => ['required', Rule::in(['diajukan_ke_kepsek', 'ditolak'])],
        ]);

        $laporan->update($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Status verifikasi laporan diperbarui.']);

        return back();
    }

    /**
     * Remove the specified report.
     */
    public function destroy(Request $request, Laporan $laporan): RedirectResponse
    {
        $user = $request->user();
        if (! $user instanceof Pengguna) {
            abort(403);
        }

        $isOwnerPending = $laporan->pengguna_id === $user->id && $laporan->status === 'menunggu_verifikasi';
        if ($user->role !== 'sarana' && ! $isOwnerPending) {
            abort(403, 'Laporan tidak dapat dihapus.');
        }

        if ($laporan->foto_kerusakan !== '') {
            Storage::disk('public')->delete($laporan->foto_kerusakan);
        }

        $laporan->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Laporan berhasil dihapus.']);

        return to_route('laporan.index');
    }
}

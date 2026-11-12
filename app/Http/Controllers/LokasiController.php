<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LokasiController extends Controller
{
    /**
     * Display a listing of locations.
     */
    public function index(): Response
    {
        return Inertia::render('lokasi/index', [
            'lokasi' => Lokasi::query()
                ->withCount(['barang', 'laporan'])
                ->orderBy('gedung')
                ->orderBy('lantai')
                ->orderBy('nama_ruangan')
                ->get(),
        ]);
    }

    /**
     * Store a newly created location.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:100'],
            'gedung' => ['nullable', 'string', 'max:50'],
            'lantai' => ['nullable', 'integer'],
        ]);

        Lokasi::create($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Lokasi berhasil ditambahkan.']);

        return back();
    }

    /**
     * Update the specified location.
     */
    public function update(Request $request, Lokasi $lokasi): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:100'],
            'gedung' => ['nullable', 'string', 'max:50'],
            'lantai' => ['nullable', 'integer'],
        ]);

        $lokasi->update($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Lokasi berhasil diperbarui.']);

        return back();
    }

    /**
     * Remove the specified location.
     */
    public function destroy(Lokasi $lokasi): RedirectResponse
    {
        if ($lokasi->laporan()->exists()) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => 'Lokasi tidak dapat dihapus karena masih digunakan pada data laporan.',
            ]);

            return back();
        }

        $lokasi->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Lokasi berhasil dihapus.']);

        return back();
    }
}

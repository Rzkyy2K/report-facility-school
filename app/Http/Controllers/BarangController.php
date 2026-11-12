<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lokasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class BarangController extends Controller
{
    /**
     * Display a listing of items.
     */
    public function index(): Response
    {
        return Inertia::render('barang/index', [
            'barang' => Barang::query()
                ->with('lokasi')
                ->orderBy('nama_barang')
                ->get(),
            'lokasi' => Lokasi::query()
                ->orderBy('nama_ruangan')
                ->get(),
        ]);
    }

    /**
     * Store a newly created item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lokasi_id' => ['nullable', 'integer', 'exists:lokasi,id'],
            'kode_barang' => ['nullable', 'string', 'max:50', Rule::unique('barang', 'kode_barang')],
            'nama_barang' => ['required', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'max:50'],
        ]);

        Barang::create($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Barang berhasil ditambahkan.']);

        return back();
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, Barang $barang): RedirectResponse
    {
        $validated = $request->validate([
            'lokasi_id' => ['nullable', 'integer', 'exists:lokasi,id'],
            'kode_barang' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('barang', 'kode_barang')->ignore($barang->id),
            ],
            'nama_barang' => ['required', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'max:50'],
        ]);

        $barang->update($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Barang berhasil diperbarui.']);

        return back();
    }

    /**
     * Remove the specified item.
     */
    public function destroy(Barang $barang): RedirectResponse
    {
        $barang->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Barang berhasil dihapus.']);

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KategoriLayanan;
use Illuminate\Http\Request;

class KategoriLayananController extends Controller
{
    public function index()
    {
        $kategoriLayanan = KategoriLayanan::all();
        return view('kategori-layanan.index', compact('kategoriLayanan'));
    }

    public function create()
    {
        return view('kategori-layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string', // Validasi untuk keterangan
            'status_aktivasi' => 'required|boolean',
        ]);

        KategoriLayanan::create($request->all());

        return redirect()->route('kategori-layanan.index')
            ->with('success', 'Kategori layanan berhasil dibuat.');
    }

    public function edit($id)
    {
        $kategoriLayanan = KategoriLayanan::findOrFail($id);
        return view('kategori-layanan.edit', compact('kategoriLayanan'));
    }

    public function update(Request $request, $id)
    {
        $kategoriLayanan = KategoriLayanan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string', // Validasi untuk keterangan
            'status_aktivasi' => 'required|boolean',
        ]);

        $kategoriLayanan->update($request->all());

        return redirect()->route('kategori-layanan.index')
            ->with('success', 'Kategori layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategoriLayanan = KategoriLayanan::findOrFail($id);
        $kategoriLayanan->delete();

        return redirect()->route('kategori-layanan.index')
            ->with('success', 'Kategori layanan berhasil dihapus.');
    }
}
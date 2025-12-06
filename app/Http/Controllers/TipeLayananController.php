<?php

namespace App\Http\Controllers;

use App\Models\TipeLayanan;
use Illuminate\Http\Request;

class TipeLayananController extends Controller
{
    public function index()
    {
        $tipeLayanan = TipeLayanan::all();
        return view('tipe-layanan.index', compact('tipeLayanan'));
    }

    public function create()
    {
        return view('tipe-layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status_aktivasi' => 'required|boolean',
        ]);

        TipeLayanan::create($request->all());

        return redirect()->route('tipe-layanan.index')->with('success', 'Tipe layanan created successfully.');
    }

    public function edit($id)
    {
        $tipeLayanan = TipeLayanan::findOrFail($id);
        return view('tipe-layanan.edit', compact('tipeLayanan'));
    }

    public function update(Request $request, $id)
    {
        $tipeLayanan = TipeLayanan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status_aktivasi' => 'required|boolean',
        ]);

        $tipeLayanan->update($request->all());

        return redirect()->route('tipe-layanan.index')->with('success', 'Tipe layanan updated successfully.');
    }

    public function destroy($id)
    {
        $tipeLayanan = TipeLayanan::findOrFail($id);
        $tipeLayanan->delete();

        return redirect()->route('tipe-layanan.index')->with('success', 'Tipe layanan deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;

class PerangkatDaerahController extends Controller
{
    public function index()
    {
        $perangkatDaerah = PerangkatDaerah::all();
        return view('perangkat-daerah.index', compact('perangkatDaerah'));
    }

    public function create()
    {
        return view('perangkat-daerah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'kode' => 'required|string|max:10',
            'link_esukma' => 'required|url',
            'status_aktivasi' => 'required|boolean',
            // TAMBAH: Validasi field baru
            'administrasi_pemerintahan' => 'sometimes|boolean',
            'publik' => 'sometimes|boolean',
        ]);

        PerangkatDaerah::create($request->all());

        return redirect()->route('perangkat-daerah.index')->with('success', 'Perangkat daerah created successfully.');
    }

    public function edit($id)
    {
        $perangkatDaerah = PerangkatDaerah::findOrFail($id);
        return view('perangkat-daerah.edit', compact('perangkatDaerah'));
    }

    public function update(Request $request, $id)
    {
        $perangkatDaerah = PerangkatDaerah::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'kode' => 'required|string|max:10',
            'link_esukma' => 'required|url',
            'status_aktivasi' => 'required|boolean',
            // TAMBAH: Validasi field baru
            'administrasi_pemerintahan' => 'sometimes|boolean',
            'publik' => 'sometimes|boolean',
        ]);

        $perangkatDaerah->update($request->all());

        return redirect()->route('perangkat-daerah.index')->with('success', 'Perangkat daerah updated successfully.');
    }

    public function destroy($id)
    {
        $perangkatDaerah = PerangkatDaerah::findOrFail($id);
        $perangkatDaerah->delete();

        return redirect()->route('perangkat-daerah.index')->with('success', 'Perangkat daerah deleted successfully.');
    }
}
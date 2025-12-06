<?php
namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\KategoriLayanan;
use App\Models\TipeLayanan;
use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::with(['kategoriLayanan', 'tipeLayanan', 'perangkatDaerah', 'teknisi'])->get();
        return view('layanan.index', compact('layanan'));
    }

    public function create()
    {
        $kategoriLayanan = KategoriLayanan::where('status_aktivasi', true)->get();
        $tipeLayanan = TipeLayanan::where('status_aktivasi', true)->get();
        $perangkatDaerah = PerangkatDaerah::where('status_aktivasi', true)->get();
        $teknisiList = User::getTeknisi();

        return view('layanan.create', compact('kategoriLayanan', 'tipeLayanan', 'perangkatDaerah', 'teknisiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_layanan_id' => 'required|exists:kategori_layanan,id',
            'tipe_layanan_id' => 'required|exists:tipe_layanan,id',
            'perangkat_daerah_id' => 'required|exists:perangkat_daerah,id',
            'teknisi_id' => 'required|exists:users,id',
            'eselon' => 'required|string|max:10',
            'sla_hari' => 'required|integer|min:1',
            // PERBAIKAN: Ubah menjadi tidak required, karena bisa false
            'administrasi_pemerintahan' => 'sometimes|boolean',
            'publik' => 'sometimes|boolean',
            'status_aktivasi' => 'required|boolean',
        ]);

        Layanan::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan created successfully.');
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        // PERBAIKAN: Validasi disesuaikan
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_layanan_id' => 'required|exists:kategori_layanan,id',
            'tipe_layanan_id' => 'required|exists:tipe_layanan,id',
            'perangkat_daerah_id' => 'required|exists:perangkat_daerah,id',
            'teknisi_id' => 'required|exists:users,id',
            'eselon' => 'required|string|max:10',
            'sla_hari' => 'required|integer|min:1',
            'administrasi_pemerintahan' => 'required|boolean',
            'publik' => 'required|boolean',
            'status_aktivasi' => 'required|boolean',
        ]);

        $layanan->update($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan updated successfully.');
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        $kategoriLayanan = KategoriLayanan::where('status_aktivasi', true)->get();
        $tipeLayanan = TipeLayanan::where('status_aktivasi', true)->get();
        $perangkatDaerah = PerangkatDaerah::where('status_aktivasi', true)->get();
        $teknisiList = User::getTeknisi();

        return view('layanan.edit', compact('layanan', 'kategoriLayanan', 'tipeLayanan', 'perangkatDaerah', 'teknisiList'));
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan deleted successfully.');
    }
}
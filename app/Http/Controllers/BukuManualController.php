<?php
// File: app/Http/Controllers/BukuManualController.php

namespace App\Http\Controllers;

use App\Models\BukuManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuManualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view buku-manual');

        $bukuManual = BukuManual::where('is_active', true)->get();
        return view('buku-manual.index', compact('bukuManual'));
    }

    public function create()
    {
        $this->authorize('create buku-manual');

        return view('buku-manual.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create buku-manual');

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:file,link',
            'file' => 'required_if:tipe,file|file|mimes:pdf,doc,docx|max:10240',
            'link' => 'required_if:tipe,link|nullable|url',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi sampul
        ]);

        $bukuManual = new BukuManual();
        $bukuManual->judul = $request->judul;
        $bukuManual->deskripsi = $request->deskripsi;
        $bukuManual->tipe = $request->tipe;

        // Handle upload sampul
        if ($request->hasFile('sampul')) {
            $sampulPath = $request->file('sampul')->store('buku-manual/sampul', 'public');
            $bukuManual->sampul_path = $sampulPath;
        }

        if ($request->tipe === 'file' && $request->hasFile('file')) {
            $filePath = $request->file('file')->store('buku-manual', 'public');
            $bukuManual->file_path = $filePath;
        } elseif ($request->tipe === 'link') {
            $bukuManual->link = $request->link;
        }

        $bukuManual->save();

        return redirect()->route('dashboard')->with('success', 'Buku manual berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorize('edit buku-manual');

        $bukuManual = BukuManual::findOrFail($id);
        return view('buku-manual.edit', compact('bukuManual'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit buku-manual');

        $bukuManual = BukuManual::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'link' => 'required_if:tipe,link|nullable|url',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bukuManual->judul = $request->judul;
        $bukuManual->deskripsi = $request->deskripsi;
        $bukuManual->tipe = $request->tipe;

        // Handle upload sampul
        if ($request->hasFile('sampul')) {
            // Hapus sampul lama jika ada
            if ($bukuManual->sampul_path) {
                Storage::disk('public')->delete($bukuManual->sampul_path);
            }
            $sampulPath = $request->file('sampul')->store('buku-manual/sampul', 'public');
            $bukuManual->sampul_path = $sampulPath;
        }

        if ($request->tipe === 'file') {
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($bukuManual->file_path) {
                    Storage::disk('public')->delete($bukuManual->file_path);
                }
                $filePath = $request->file('file')->store('buku-manual', 'public');
                $bukuManual->file_path = $filePath;
            }
            $bukuManual->link = null;
        } elseif ($request->tipe === 'link') {
            // Hapus file jika ada
            if ($bukuManual->file_path) {
                Storage::disk('public')->delete($bukuManual->file_path);
                $bukuManual->file_path = null;
            }
            $bukuManual->link = $request->link;
        }

        $bukuManual->save();

        return redirect()->route('dashboard')->with('success', 'Buku manual berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorize('delete buku-manual');

        $bukuManual = BukuManual::findOrFail($id);

        // Hapus file dan sampul jika ada
        if ($bukuManual->file_path) {
            Storage::disk('public')->delete($bukuManual->file_path);
        }
        if ($bukuManual->sampul_path) {
            Storage::disk('public')->delete($bukuManual->sampul_path);
        }

        $bukuManual->delete();

        return redirect()->route('dashboard')->with('success', 'Buku manual berhasil dihapus.');
    }

    public function download($id)
    {
        $this->authorize('view buku-manual');

        $bukuManual = BukuManual::findOrFail($id);

        if ($bukuManual->tipe !== 'file' || !$bukuManual->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($bukuManual->file_path);
    }

    // Method baru untuk preview file
    public function preview($id)
    {
        $this->authorize('view buku-manual');

        $bukuManual = BukuManual::findOrFail($id);

        if ($bukuManual->tipe !== 'file' || !$bukuManual->file_path) {
            abort(404);
        }

        // Cek ekstensi file untuk menentukan tipe konten
        $extension = pathinfo($bukuManual->file_path, PATHINFO_EXTENSION);

        if (in_array($extension, ['pdf'])) {
            // Untuk PDF, tampilkan di browser
            return response()->file(storage_path('app/public/' . $bukuManual->file_path));
        } else {
            // Untuk file lain, tetap download
            return Storage::disk('public')->download($bukuManual->file_path);
        }
    }

    // Method untuk view link
    public function view($id)
    {
        $this->authorize('view buku-manual');

        $bukuManual = BukuManual::findOrFail($id);

        if ($bukuManual->tipe !== 'link' || !$bukuManual->link) {
            abort(404);
        }

        // Redirect ke link eksternal
        return redirect()->away($bukuManual->link);
    }
}

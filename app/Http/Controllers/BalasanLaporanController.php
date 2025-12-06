<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BalasanLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('view balasan-laporan');

        // Ambil parameter pencarian
        $search = $request->input('search');

        // Query untuk laporan belum dibalas dengan relasi lengkap
        $laporansBelumDibalas = Laporan::with([
            'kategoriLayanan',
            'layanan',
            'perangkatDaerah', // PASTIKAN relasi ini ada
            'user',
            'teknisi'
        ])
        ->whereNull('balasan');

        // Query untuk laporan sudah dibalas dengan relasi lengkap
        $laporansSudahDibalas = Laporan::with([
            'kategoriLayanan',
            'layanan',
            'perangkatDaerah', // PASTIKAN relasi ini ada
            'user',
            'teknisi'
        ])
        ->whereNotNull('balasan');

        // Filter berdasarkan pencarian teknisi
        if ($search) {
            $laporansBelumDibalas->whereHas('teknisi', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });

            $laporansSudahDibalas->whereHas('teknisi', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan role
        if (Auth::user()->hasRole('user')) {
            $laporansBelumDibalas = $laporansBelumDibalas->where('user_id', Auth::id());
            $laporansSudahDibalas = $laporansSudahDibalas->where('user_id', Auth::id());
        }

        // Filter untuk teknisi - hanya melihat laporan yang terkait dengan layanan mereka
        if (Auth::user()->hasRole('teknisi')) {
            $laporansBelumDibalas = $laporansBelumDibalas->where('teknisi_id', Auth::id());
            $laporansSudahDibalas = $laporansSudahDibalas->where('teknisi_id', Auth::id());
        }

        // Execute queries
        $laporansBelumDibalas = $laporansBelumDibalas->latest()->get();
        $laporansSudahDibalas = $laporansSudahDibalas->latest()->get();

        return view('balasan-laporan.index', compact('laporansBelumDibalas', 'laporansSudahDibalas', 'search'));
    }

    public function create($id)
    {
        // PERBAIKAN: Teknisi dan administrator bisa membuat balasan
        if (Auth::user()->hasRole('administrator')) {
            $this->authorize('edit balasan-laporan');
        } else {
            $this->authorize('balas laporan');
        }

        $laporan = Laporan::with(['kategoriLayanan', 'layanan', 'perangkatDaerah', 'user'])
            ->findOrFail($id);

        // PERBAIKAN: Cek apakah teknisi adalah teknisi yang ditugaskan atau admin
        $isAssignedTeknisi = $laporan->teknisi_id === Auth::id();
        $isAdmin = Auth::user()->hasRole('administrator');
        
        // PERBAIKAN: Jika bukan admin dan bukan teknisi yang ditugaskan, tolak akses
        if (!$isAdmin && !$isAssignedTeknisi) {
            abort(403, 'Anda tidak diizinkan membalas laporan ini. Hanya teknisi yang ditugaskan yang bisa membalas.');
        }

        // PERBAIKAN: Admin bisa membalas laporan yang sudah dibalas teknisi (untuk koreksi/tambahan)
        // Tapi teknisi biasa tidak bisa membalas laporan yang sudah dibalas
        if ($laporan->balasan && !$isAdmin) {
            return redirect()->route('balasan-laporan.index')
                ->with('error', 'Laporan ini sudah dibalas.');
        }

        return view('balasan-laporan.create', compact('laporan'));
    }

    public function store(Request $request, $id)
    {
        // PERBAIKAN: Teknisi dan administrator bisa menyimpan balasan
        if (Auth::user()->hasRole('administrator')) {
            $this->authorize('edit balasan-laporan');
        } else {
            $this->authorize('balas laporan');
        }

        $request->validate([
            'balasan' => 'required|string',
            'status' => 'required|in:draft,proses,selesai',
            'lampiran_balasan' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $laporan = Laporan::findOrFail($id);

        // PERBAIKAN: Cek apakah teknisi adalah teknisi yang ditugaskan atau admin
        $isAssignedTeknisi = $laporan->teknisi_id === Auth::id();
        $isAdmin = Auth::user()->hasRole('administrator');
        
        // PERBAIKAN: Jika bukan admin dan bukan teknisi yang ditugaskan, tolak akses
        if (!$isAdmin && !$isAssignedTeknisi) {
            abort(403, 'Anda tidak diizinkan membalas laporan ini. Hanya teknisi yang ditugaskan yang bisa membalas.');
        }

        // PERBAIKAN: Admin bisa membalas laporan yang sudah dibalas (untuk update/koreksi)
        // Tapi teknisi biasa tidak bisa membalas laporan yang sudah dibalas
        if ($laporan->balasan && !$isAdmin) {
            return redirect()->route('balasan-laporan.index')
                ->with('error', 'Laporan ini sudah dibalas.');
        }

        // Handle upload lampiran balasan
        $lampiranBalasanPath = null;
        if ($request->hasFile('lampiran_balasan')) {
            $lampiranBalasanPath = $request->file('lampiran_balasan')->store('lampiran-balasan', 'public');
        }

        // PERBAIKAN: Jika admin membalas laporan yang sudah ada balasannya, append balasan baru
        $balasanBaru = $request->balasan;
        if ($laporan->balasan && $isAdmin) {
            $balasanLama = $laporan->balasan;
            $balasanBaru = "=== Balasan Sebelumnya (oleh " . ($laporan->teknisi->name ?? 'Sistem') . ") ===\n" .
                        $balasanLama . "\n\n" .
                        "=== Balasan Baru (oleh Administrator) ===\n" .
                        $request->balasan;
        }

        // Update laporan dengan balasan
        $laporan->update([
            'balasan' => $balasanBaru,
            'teknisi_id' => $isAdmin ? ($laporan->teknisi_id ?? Auth::id()) : Auth::id(),
            'status' => $request->status,
            'lampiran_balasan_path' => $lampiranBalasanPath,
            'dibalas_pada' => now(),
        ]);

        $message = $isAdmin && $laporan->balasan ?
                'Balasan administrator berhasil ditambahkan.' :
                'Balasan berhasil dikirim.';

        return redirect()->route('balasan-laporan.index')
            ->with('success', $message);
    }

    // Lihat detail balasan (untuk semua role yang memiliki akses)
    public function show($id)
    {
        $this->authorize('view balasan-laporan');

        $laporan = Laporan::with(['kategoriLayanan', 'layanan', 'perangkatDaerah', 'user', 'teknisi'])
            ->findOrFail($id);

        // PERBAIKAN: Teknisi bisa melihat semua laporan yang sudah dibalas, termasuk oleh admin
        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda hanya bisa melihat balasan laporan Anda sendiri.');
        }

        // PERBAIKAN: Teknisi dan eselon bisa melihat semua laporan yang sudah dibalas
        if (Auth::user()->hasRole(['teknisi', 'eselon']) && !$laporan->balasan) {
            abort(403, 'Laporan ini belum memiliki balasan.');
        }

        return view('balasan-laporan.show', compact('laporan'));
    }

    // Edit balasan (untuk teknisi yang membuat balasan dan administrator)
    public function edit($id)
    {
        $laporan = Laporan::with(['kategoriLayanan', 'layanan', 'perangkatDaerah', 'user'])
            ->findOrFail($id);

        // Administrator bisa mengedit semua balasan
        if (Auth::user()->hasRole('administrator')) {
            $this->authorize('edit balasan-laporan');
        } else {
            // Teknisi hanya bisa mengedit balasan mereka sendiri
            $this->authorize('balas laporan');
            if ($laporan->teknisi_id !== Auth::id()) {
                abort(403, 'Anda hanya bisa mengedit balasan yang Anda buat.');
            }
        }

        return view('balasan-laporan.edit', compact('laporan'));
    }

    // Update balasan (untuk teknisi yang membuat balasan dan administrator)
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        // Administrator bisa mengupdate semua balasan
        if (Auth::user()->hasRole('administrator')) {
            $this->authorize('edit balasan-laporan');
        } else {
            // Teknisi hanya bisa mengupdate balasan mereka sendiri
            $this->authorize('balas laporan');
            if ($laporan->teknisi_id !== Auth::id()) {
                abort(403, 'Anda hanya bisa mengupdate balasan yang Anda buat.');
            }
        }

        $request->validate([
            'balasan' => 'required|string', // DIUBAH: Hapus min:10
            'status' => 'required|in:draft,proses,selesai',
            'lampiran_balasan' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Handle upload lampiran balasan
        $lampiranBalasanPath = $laporan->lampiran_balasan_path;
        if ($request->hasFile('lampiran_balasan')) {
            // Hapus file lama jika ada
            if ($lampiranBalasanPath) {
                Storage::disk('public')->delete($lampiranBalasanPath);
            }
            $lampiranBalasanPath = $request->file('lampiran_balasan')->store('lampiran-balasan', 'public');
        }

        $laporan->update([
            'balasan' => $request->balasan,
            'status' => $request->status,
            'lampiran_balasan_path' => $lampiranBalasanPath,
        ]);

        return redirect()->route('balasan-laporan.index')
            ->with('success', 'Balasan berhasil diperbarui.');
    }

    // Hapus balasan (khusus administrator)
    public function destroy($id)
    {
        $this->authorize('delete balasan-laporan');

        $laporan = Laporan::findOrFail($id);

        // Hapus file lampiran balasan jika ada
        if ($laporan->lampiran_balasan_path) {
            Storage::disk('public')->delete($laporan->lampiran_balasan_path);
        }

        // Reset data balasan
        $laporan->update([
            'balasan' => null,
            'teknisi_id' => null,
            'lampiran_balasan_path' => null,
            'dibalas_pada' => null,
            'status' => 'draft'
        ]);

        return redirect()->route('balasan-laporan.index')
            ->with('success', 'Balasan berhasil dihapus.');
    }

    // Method untuk download lampiran balasan
    public function downloadLampiranBalasan($id)
    {
        $laporan = Laporan::findOrFail($id);

        $this->authorize('view balasan-laporan');

        // PERBAIKAN: User bisa mendownload lampiran balasan dari laporan mereka sendiri
        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda hanya bisa mendownload lampiran balasan dari laporan Anda sendiri.');
        }

        if (!$laporan->lampiran_balasan_path) {
            return redirect()->back()->with('error', 'File lampiran balasan tidak ditemukan.');
        }

        return Storage::disk('public')->download($laporan->lampiran_balasan_path);
    }

    // Method untuk melihat lampiran balasan secara langsung
    public function viewLampiranBalasan($id)
    {
        $laporan = Laporan::findOrFail($id);

        $this->authorize('view balasan-laporan');

        // PERBAIKAN: User bisa melihat lampiran balasan dari laporan mereka sendiri
        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda hanya bisa melihat lampiran balasan dari laporan Anda sendiri.');
        }

        if (!$laporan->lampiran_balasan_path) {
            return redirect()->back()->with('error', 'File lampiran balasan tidak ditemukan.');
        }

        // Cek apakah file exists
        if (!Storage::disk('public')->exists($laporan->lampiran_balasan_path)) {
            return redirect()->back()->with('error', 'File lampiran balasan tidak ditemukan di storage.');
        }

        $filePath = Storage::disk('public')->path($laporan->lampiran_balasan_path);
        $mimeType = Storage::disk('public')->mimeType($laporan->lampiran_balasan_path);

        // Untuk file PDF, image, dan text, kita bisa tampilkan langsung di browser
        if (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'text/plain'])) {
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($laporan->lampiran_balasan_path) . '"'
            ]);
        } else {
            // Untuk file lainnya, force download
            return Storage::disk('public')->download($laporan->lampiran_balasan_path);
        }
    }

    // Method untuk melihat lampiran laporan secara langsung
    public function viewLampiranLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);

        $this->authorize('view balasan-laporan');

        // PERBAIKAN: Teknisi dan eselon bisa melihat semua lampiran laporan
        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda hanya bisa melihat lampiran laporan Anda sendiri.');
        }

        if (!$laporan->lampiran_path) {
            return redirect()->back()->with('error', 'File lampiran laporan tidak ditemukan.');
        }

        // Cek apakah file exists
        if (!Storage::disk('public')->exists($laporan->lampiran_path)) {
            return redirect()->back()->with('error', 'File lampiran laporan tidak ditemukan di storage.');
        }

        $filePath = Storage::disk('public')->path($laporan->lampiran_path);
        $mimeType = Storage::disk('public')->mimeType($laporan->lampiran_path);

        // Untuk file PDF, image, dan text, kita bisa tampilkan langsung di browser
        if (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'text/plain'])) {
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($laporan->lampiran_path) . '"'
            ]);
        } else {
            // Untuk file lainnya, force download
            return Storage::disk('public')->download($laporan->lampiran_path);
        }
    }

    // Method untuk hapus lampiran balasan (untuk teknisi dan administrator)
    public function hapusLampiranBalasan($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Administrator bisa menghapus lampiran semua balasan
        if (Auth::user()->hasRole('administrator')) {
            $this->authorize('edit balasan-laporan');
        } else {
            // Teknisi hanya bisa menghapus lampiran balasan mereka sendiri
            $this->authorize('balas laporan');
            if ($laporan->teknisi_id !== Auth::id()) {
                abort(403, 'Anda hanya bisa menghapus lampiran balasan yang Anda buat.');
            }
        }

        if (!$laporan->lampiran_balasan_path) {
            return redirect()->back()->with('error', 'Tidak ada lampiran untuk dihapus.');
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($laporan->lampiran_balasan_path);

        // Update database
        $laporan->update([
            'lampiran_balasan_path' => null
        ]);

        return redirect()->back()->with('success', 'Lampiran balasan berhasil dihapus.');
    }
}

<?php
// File: app/Http/Controllers/LaporanController.php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriLayanan;
use App\Models\Layanan;
use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'trackTicketPublic',
            'showPublic',
            'downloadLampiranPublic',
            'downloadLampiranBalasanPublic'
        ]);
    }

    public function index()
    {
        $this->authorize('view laporan');

        if (Auth::user()->hasRole('administrator') || Auth::user()->hasRole(['teknisi', 'eselon'])) {
            $laporans = Laporan::with(['kategoriLayanan', 'layanan', 'user'])
                ->latest()
                ->get();
        } else {
            // User biasa hanya bisa melihat laporan mereka
            $laporans = Laporan::with(['kategoriLayanan', 'layanan'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('laporan.index', compact('laporans'));
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('view laporan');
        
        // Tambahkan pengecekan role administrator
        if (!Auth::user()->hasRole('administrator')) {
            abort(403, 'Hanya administrator yang dapat melakukan export data.');
        }

        $fileName = 'laporan-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new LaporanExport, $fileName);
    }

    public function exportPdf(Request $request)
    {
        $this->authorize('view laporan');
        
        // Tambahkan pengecekan role administrator
        if (!Auth::user()->hasRole('administrator')) {
            abort(403, 'Hanya administrator yang dapat melakukan export data.');
        }

        // Query data laporan dengan relasi lengkap
        $laporans = Laporan::with([
                'kategoriLayanan', 
                'layanan', 
                'layanan.perangkatDaerah',
                'user', 
                'teknisi'
            ])
            ->latest()
            ->get();

        // Pastikan timezone konsisten
        $now = now()->timezone('Asia/Jakarta');
        
        $pdf = PDF::loadView('exports.laporan-pdf', compact('laporans'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 150
            ]);

        return $pdf->download('laporan-' . $now->format('Y-m-d-H-i-s') . '.pdf');
    }

    public function cetakLaporan(Request $request)
    {
        $this->authorize('view laporan');
        
        // Tambahkan pengecekan role administrator
        if (!Auth::user()->hasRole('administrator')) {
            abort(403, 'Hanya administrator yang dapat mengakses halaman cetak laporan.');
        }

        // Query data laporan berdasarkan role
        if (Auth::user()->hasRole('administrator') || Auth::user()->hasRole(['teknisi', 'eselon'])) {
            $laporans = Laporan::with(['kategoriLayanan', 'layanan', 'user', 'teknisi'])
                ->latest()
                ->get();
        } else {
            // User biasa hanya bisa melihat laporan mereka
            $laporans = Laporan::with(['kategoriLayanan', 'layanan', 'user'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('cetak-laporan.index', compact('laporans'));
    }

    public function create()
    {
        $this->authorize('create laporan');

        // Validasi kelengkapan profil
        if (Auth::user()->hasRole('user') && !Auth::user()->isProfileComplete()) {
            $incompleteFields = Auth::user()->getIncompleteFields();
            return redirect()->route('profile.edit')
                ->with('warning', 'Harap lengkapi profil Anda terlebih dahulu sebelum membuat laporan. Field yang harus diisi: ' . implode(', ', $incompleteFields));
        }

        $kategoriLayanan = KategoriLayanan::where('status_aktivasi', true)->get();
        
        // Filter kategori berdasarkan jenis OPD user
        if (Auth::user()->hasRole('user') && Auth::user()->hasPublicPerangkatDaerah()) {
            // User dengan OPD publik hanya bisa melihat kategori yang terkait dengan layanan publik
            $kategoriLayanan = KategoriLayanan::where('status_aktivasi', true)
                ->whereHas('layanan', function($query) {
                    $query->where('publik', true)
                        ->where('status_aktivasi', true);
                })
                ->get();
        }
        
        // Inisialisasi dengan layanan kosong, akan diisi via AJAX
        $layanan = collect();

        return view('laporan.create', compact('kategoriLayanan', 'layanan'));
    }

    public function edit($id)
    {
        $this->authorize('edit laporan');
        $laporan = Laporan::findOrFail($id);

        // Validasi tambahan: Hanya admin/teknisi yang bisa membalas
        if (Auth::user()->hasRole('user')) {
            abort(403, 'Anda tidak dapat mengedit laporan yang sudah dikirim.');
        }

        $kategoriLayanan = KategoriLayanan::where('status_aktivasi', true)->get();
        
        // UBAH: Ambil layanan berdasarkan kategori laporan saat ini
        $layanan = Layanan::where('kategori_layanan_id', $laporan->kategori_layanan_id)
            ->where('status_aktivasi', true)
            ->get();

        return view('laporan.edit', compact('laporan', 'kategoriLayanan', 'layanan'));
    }

    public function store(Request $request)
    {
        $this->authorize('create laporan');

        if (Auth::user()->hasRole('user') && !Auth::user()->isProfileComplete()) {
            $incompleteFields = Auth::user()->getIncompleteFields();
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Harap lengkapi profil Anda terlebih dahulu sebelum membuat laporan. Field yang harus diisi: ' . implode(', ', $incompleteFields));
        }

        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_layanan_id' => 'required|exists:kategori_layanan,id',
            'layanan_id' => 'required|exists:layanan,id',
            'tanggal_laporan' => 'required|date',
            'waktu_laporan' => 'required|date_format:H:i',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
            'status' => 'sometimes|in:draft,proses,selesai'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // TAMBAH: Ambil teknisi_id dari layanan yang dipilih
        $layanan = Layanan::find($request->layanan_id);
        if ($layanan && $layanan->teknisi_id) {
            $data['teknisi_id'] = $layanan->teknisi_id;
        }

        // Set status default untuk user biasa
        if (Auth::user()->hasRole('user') && !isset($data['status'])) {
            $data['status'] = 'draft';
        }

        // Handle file upload
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $path = $file->store('laporan_lampiran', 'public');
            $data['lampiran_path'] = $path;
        }

        Laporan::create($data);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dibuat.');
    }

    public function show($id)
    {
        $this->authorize('view laporan');
        $laporan = Laporan::with(['kategoriLayanan', 'layanan', 'user', 'teknisi'])
            ->findOrFail($id);

        // Cek akses user biasa
        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat laporan ini.');
        }

        return view('laporan.show', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit laporan');

        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_layanan_id' => 'required|exists:kategori_layanan,id',
            'layanan_id' => 'required|exists:layanan,id',
            'tanggal_laporan' => 'required|date',
            'waktu_laporan' => 'required|date_format:H:i',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
            'status' => 'sometimes|in:draft,proses,selesai'
        ]);

        $data = $request->except('lampiran');

        // TAMBAH: Update teknisi_id jika layanan berubah
        if ($request->has('layanan_id') && $request->layanan_id != $laporan->layanan_id) {
            $layanan = Layanan::find($request->layanan_id);
            if ($layanan && $layanan->teknisi_id) {
                $data['teknisi_id'] = $layanan->teknisi_id;
            }
        }

        // Handle file upload
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($laporan->lampiran_path && Storage::disk('public')->exists($laporan->lampiran_path)) {
                Storage::disk('public')->delete($laporan->lampiran_path);
            }

            $file = $request->file('lampiran');
            $path = $file->store('laporan_lampiran', 'public');
            $data['lampiran_path'] = $path;
        }

        // Jika user biasa, jangan izinkan mengubah status
        if (Auth::user()->hasRole('user')) {
            unset($data['status']);
        }

        $laporan->update($data);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->hasRole('user')) {
            abort(403, 'Anda tidak diperbolehkan menghapus laporan yang sudah dibuat.');
        }
        $this->authorize('delete laporan');

        $laporan = Laporan::findOrFail($id);

        if ($laporan->lampiran_path) {
            Storage::disk('public')->delete($laporan->lampiran_path);
        }
        // Hapus lampiran balasan juga
        if ($laporan->lampiran_balasan_path) {
            Storage::disk('public')->delete($laporan->lampiran_balasan_path);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function trackTicketPublic(Request $request)
    {
        $request->validate(['ticketNumber' => 'required|string']);
        $kodeTiket = $request->input('ticketNumber');

        $laporan = Laporan::where('kode_tiket', $kodeTiket)->first();

        if (!$laporan) {
            // Jika request AJAX, kembalikan JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor tiket tidak ditemukan atau salah.'
                ], 404);
            }
            
            return redirect()->route('welcome')
                ->with('error', 'Nomor tiket tidak ditemukan atau salah.');
        }

        // Jika request AJAX, kembalikan JSON dengan data laporan
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tiket ditemukan.',
                'data' => [
                    'kode_tiket' => $laporan->kode_tiket,
                    'status' => $laporan->status,
                    'redirect_url' => route('laporan.show.public', $laporan->id)
                ]
            ]);
        }

        // Redirect ke halaman show publik untuk request biasa
        return redirect()->route('laporan.show.public', $laporan->id);
    }

    /**
     * METHOD BARU: Menampilkan detail laporan (publik).
     */
    public function showPublic($id)
    {
        $laporan = Laporan::with(['kategoriLayanan', 'layanan', 'user', 'teknisi'])
            ->findOrFail($id);

        return view('laporan.show-public', compact('laporan'));
    }

    /**
     * Download lampiran (internal)
     */
    public function downloadLampiran($id)
    {
        $this->authorize('view laporan');
        $laporan = Laporan::findOrFail($id);

        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat lampiran ini.');
        }

        if (!$laporan->lampiran_path || !Storage::disk('public')->exists($laporan->lampiran_path)) {
            return redirect()->back()->with('error', 'File lampiran tidak ditemukan.');
        }

        return Storage::disk('public')->response($laporan->lampiran_path);
    }

    /**
     * Download lampiran balasan (internal)
     */
    public function downloadLampiranBalasan($id)
    {
        $this->authorize('view laporan');
        $laporan = Laporan::findOrFail($id);

        if (Auth::user()->hasRole('user') && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat lampiran ini.');
        }

        if (!$laporan->lampiran_balasan_path || !Storage::disk('public')->exists($laporan->lampiran_balasan_path)) {
            return redirect()->back()->with('error', 'File lampiran balasan tidak ditemukan.');
        }

        return Storage::disk('public')->response($laporan->lampiran_balasan_path);
    }

    /**
     * Download lampiran (publik)
     */
    public function downloadLampiranPublic($id)
    {
        $laporan = Laporan::findOrFail($id);

        if (!$laporan->lampiran_path || !Storage::disk('public')->exists($laporan->lampiran_path)) {
            return redirect()->route('laporan.show.public', $id)->with('error', 'File lampiran tidak ditemukan.');
        }

        return Storage::disk('public')->response($laporan->lampiran_path);
    }

    /**
     * Download lampiran balasan (publik)
     */
    public function downloadLampiranBalasanPublic($id)
    {
        $laporan = Laporan::findOrFail($id);

        if (!$laporan->lampiran_balasan_path || !Storage::disk('public')->exists($laporan->lampiran_balasan_path)) {
            return redirect()->route('laporan.show.public', $id)->with('error', 'File lampiran balasan tidak ditemukan.');
        }

        return Storage::disk('public')->response($laporan->lampiran_balasan_path);
    }

    // Relasi ke Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Relasi ke User (pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke BalasanLaporan
    public function balasan()
    {
        return $this->hasOne(BalasanLaporan::class);
    }

    // METHOD BARU: Hitung sisa waktu SLA
    public function getSisaSlaAttribute()
    {
        $slaHari = $this->layanan->sla_hari;
        $tanggalDibuat = $this->created_at;
        $tanggalTarget = $tanggalDibuat->addDays($slaHari);
        $sekarang = Carbon::now();

        if ($sekarang->gt($tanggalTarget)) {
            return -$sekarang->diffInDays($tanggalTarget); // Negatif jika sudah lewat
        }

        return $sekarang->diffInDays($tanggalTarget);
    }

    // METHOD BARU: Cek status SLA
    public function getStatusSlaAttribute()
    {
        $sisaSla = $this->sisa_sla;

        if ($sisaSla < 0) {
            return 'lewat';
        } elseif ($sisaSla <= 1) {
            return 'kritis';
        } elseif ($sisaSla <= 3) {
            return 'warning';
        } else {
            return 'aman';
        }
    }

    // METHOD BARU: Warna berdasarkan status SLA
    public function getWarnaSlaAttribute()
    {
        switch ($this->status_sla) {
            case 'lewat':
                return 'danger';
            case 'kritis':
                return 'warning';
            case 'warning':
                return 'info';
            default:
                return 'success';
        }
    }

    // METHOD BARU: Icon berdasarkan status SLA
    public function getIconSlaAttribute()
    {
        switch ($this->status_sla) {
            case 'lewat':
                return 'fas fa-exclamation-triangle';
            case 'kritis':
                return 'fas fa-exclamation-circle';
            case 'warning':
                return 'fas fa-clock';
            default:
                return 'fas fa-check-circle';
        }
    }

    public function getLayananByKategori($kategoriId)
    {
        try {
            $query = Layanan::where('kategori_layanan_id', $kategoriId)
                ->where('status_aktivasi', true);
            
            // Filter untuk user dengan OPD publik
            if (Auth::user()->hasRole('user') && Auth::user()->hasPublicPerangkatDaerah()) {
                $query->where('publik', true);
            }
            
            $layanan = $query->get(['id', 'nama', 'kategori_layanan_id']);
            
            return response()->json($layanan);
        } catch (\Exception $e) {
            \Log::error('Error getting layanan by kategori: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}
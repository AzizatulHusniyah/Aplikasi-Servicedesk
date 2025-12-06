<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BukuManual;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect berdasarkan role setelah login
        if ($user->hasRole('teknisi')) {
            return $this->teknisiDashboard($user);
        }
        
        // Data untuk admin
        if ($user->hasRole('administrator')) {
            return $this->adminDashboard($user);
        }
        
        // Data untuk eselon
        if ($user->hasRole('eselon')) {
            return $this->eselonDashboard($user);
        }

        // Data untuk user biasa
        return $this->userDashboard($user);
    }

    /**
     * Dashboard khusus untuk teknisi dengan focus pada warning SLA
     */
    private function teknisiDashboard($user)
    {
        // Ambil layanan yang ditugaskan ke teknisi ini
        $layananTeknisi = Layanan::where('teknisi_id', $user->id)
            ->where('status_aktivasi', true)
            ->pluck('id');

        // Laporan untuk teknisi ini - TAMBAH: Jangan orderBy sisa_sla langsung dari query
        $laporanTeknisi = Laporan::whereIn('layanan_id', $layananTeknisi)
            ->with(['layanan', 'user'])
            ->whereIn('status', ['draft', 'proses', 'diproses', 'baru']) // Hanya yang belum selesai
            ->orderByRaw('FIELD(status, "proses", "diproses", "draft", "baru")')
            ->get();

        // Hitung total laporan dulu
        $totalLaporan = $laporanTeknisi->count();
        $laporanBaru = $laporanTeknisi->whereIn('status', ['baru', 'draft'])->count();
        $laporanDiproses = $laporanTeknisi->whereIn('status', ['proses', 'diproses'])->count();
        
        // Untuk laporan selesai, ambil semua termasuk yang sudah selesai
        $laporanSelesai = Laporan::whereIn('layanan_id', $layananTeknisi)
            ->where('status', 'selesai')
            ->count();

        // Warning SLA khusus untuk teknisi ini - Hanya yang belum selesai
        // URUTKAN DI MEMORI setelah data diambil
        $warningLaporan = $laporanTeknisi
            ->filter(function ($laporan) {
                return in_array($laporan->status_sla, ['lewat', 'deadline_hari_ini', 'kritis', 'warning']);
            })
            ->sortBy(function ($laporan) {
                // Urutkan berdasarkan: status_sla dulu, lalu sisa_sla
                $priority = [
                    'lewat' => 1,
                    'deadline_hari_ini' => 2,
                    'kritis' => 3,
                    'warning' => 4,
                    'aman' => 5,
                    'tidak_ada_sla' => 6,
                    'selesai' => 7
                ];
                
                $statusPriority = $priority[$laporan->status_sla] ?? 99;
                
                // Untuk urutan yang sama, urutkan berdasarkan sisa_sla (yang negatif/terlambat di atas)
                return [$statusPriority, $laporan->sisa_sla];
            });

        // Hitung statistik warning
        $totalWarning = $warningLaporan->count();
        $criticalWarning = $warningLaporan->where('status_sla', 'lewat')->count();
        $highWarning = $warningLaporan->whereIn('status_sla', ['deadline_hari_ini', 'kritis'])->count();
        $mediumWarning = $warningLaporan->where('status_sla', 'warning')->count();

        return view('dashboard.teknisi', compact(
            'totalLaporan', 
            'laporanBaru', 
            'laporanDiproses', 
            'laporanSelesai',
            'warningLaporan',
            'totalWarning',
            'criticalWarning',
            'highWarning',
            'mediumWarning'
        ));
    }

    /**
     * Dashboard untuk administrator
     */
    private function adminDashboard($user)
    {
        $totalLaporan = Laporan::count();
        $laporanBaru = Laporan::where('status', 'baru')->orWhere('status', 'draft')->count();
        $laporanDiproses = Laporan::where('status', 'proses')->orWhere('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();
        
        // Ambil semua laporan yang perlu warning SLA
        $warningLaporan = Laporan::with(['layanan', 'user', 'teknisi'])
            ->whereIn('status', ['baru', 'draft', 'proses', 'diproses'])
            ->get()
            ->filter(function ($laporan) {
                return in_array($laporan->status_sla, ['lewat', 'kritis', 'warning']);
            })
            ->sortByDesc('sisa_sla');

        return view('dashboard.admin', compact(
            'totalLaporan', 
            'laporanBaru', 
            'laporanDiproses', 
            'laporanSelesai',
            'warningLaporan'
        ));
    }

    private function eselonDashboard($user)
    {
        $totalLaporan = Laporan::count();
        $laporanBaru = Laporan::where('status', 'baru')->orWhere('status', 'draft')->count();
        $laporanDiproses = Laporan::where('status', 'proses')->orWhere('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();
        
        // Ambil semua laporan yang perlu warning SLA
        $warningLaporan = Laporan::with(['layanan', 'user', 'teknisi'])
            ->whereIn('status', ['baru', 'draft', 'proses', 'diproses'])
            ->get()
            ->filter(function ($laporan) {
                return in_array($laporan->status_sla, ['lewat', 'kritis', 'warning']);
            })
            ->sortByDesc('sisa_sla');

        return view('dashboard.eselon', compact(
            'totalLaporan', 
            'laporanBaru', 
            'laporanDiproses', 
            'laporanSelesai',
            'warningLaporan'
        ));
    }

    /**
     * Dashboard untuk user biasa
     */
    private function userDashboard($user)
    {
        $laporanUser = Laporan::where('user_id', $user->id)->get();
        $totalLaporan = $laporanUser->count();
        $laporanBaru = $laporanUser->whereIn('status', ['baru', 'draft'])->count();
        $laporanDiproses = $laporanUser->whereIn('status', ['proses', 'diproses'])->count();
        $laporanSelesai = $laporanUser->where('status', 'selesai')->count();

        // Stats untuk user biasa
        $laporanStats = $this->getLaporanStats($user);

        return view('dashboard.user', compact(
            'totalLaporan', 
            'laporanBaru', 
            'laporanDiproses', 
            'laporanSelesai',
            'laporanStats'
        ));
    }

    public function getWarningSla()
    {
        $user = auth()->user();
        $warningData = [];

        if ($user->hasRole('teknisi')) {
            $layananTeknisi = Layanan::where('teknisi_id', $user->id)
                ->where('status_aktivasi', true)
                ->pluck('id');

            $warningData = Laporan::whereIn('layanan_id', $layananTeknisi)
                ->with(['layanan', 'user'])
                ->whereIn('status', ['baru', 'draft', 'proses', 'diproses'])
                ->get()
                ->filter(function ($laporan) {
                    return in_array($laporan->status_sla, ['lewat', 'kritis', 'warning']);
                })
                ->map(function ($laporan) {
                    return [
                        'id' => $laporan->id,
                        'judul' => $laporan->judul_laporan,
                        'nomor_tiket' => $laporan->kode_tiket,
                        'sisa_sla' => $laporan->sisa_sla,
                        'status_sla' => $laporan->status_sla,
                        'warna_sla' => $laporan->warna_sla,
                        'icon_sla' => $laporan->icon_sla,
                        'created_at' => $laporan->created_at->format('d/m/Y H:i'),
                        'target_selesai' => $laporan->created_at->addDays($laporan->layanan->sla_hari ?? 0)->format('d/m/Y H:i'),
                        'layanan' => $laporan->layanan->nama ?? 'N/A',
                        'status' => $laporan->status,
                    ];
                })
                ->values();
        }

        return response()->json([
            'success' => true,
            'data' => $warningData,
            'total_warning' => count($warningData),
            'critical_count' => count(array_filter($warningData, function($item) {
                return $item['status_sla'] === 'lewat';
            })),
            'high_count' => count(array_filter($warningData, function($item) {
                return $item['status_sla'] === 'kritis';
            })),
        ]);
    }

    private function getLaporanStats($user)
    {
        if ($user->hasRole('administrator') || $user->hasRole(['teknisi', 'eselon'])) {
            // Admin/teknisi melihat semua laporan
            $totalLaporan = Laporan::count();
            $laporanDraft = Laporan::whereIn('status', ['draft', 'baru'])->count();
            $laporanProses = Laporan::whereIn('status', ['proses', 'diproses'])->count();
            $laporanSelesai = Laporan::where('status', 'selesai')->count();
        } else {
            // User biasa hanya melihat laporan mereka sendiri
            $totalLaporan = Laporan::where('user_id', $user->id)->count();
            $laporanDraft = Laporan::where('user_id', $user->id)->whereIn('status', ['draft', 'baru'])->count();
            $laporanProses = Laporan::where('user_id', $user->id)->whereIn('status', ['proses', 'diproses'])->count();
            $laporanSelesai = Laporan::where('user_id', $user->id)->where('status', 'selesai')->count();
        }

        // Hitung persentase
        $persentaseSelesai = $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100) : 0;
        $persentaseProses = $totalLaporan > 0 ? round(($laporanProses / $totalLaporan) * 100) : 0;
        $persentaseDraft = $totalLaporan > 0 ? round(($laporanDraft / $totalLaporan) * 100) : 0;

        return [
            'total' => $totalLaporan,
            'draft' => $laporanDraft,
            'proses' => $laporanProses,
            'selesai' => $laporanSelesai,
            'persentase_selesai' => $persentaseSelesai,
            'persentase_proses' => $persentaseProses,
            'persentase_draft' => $persentaseDraft,
        ];
    }

    /**
     * Method untuk menampilkan modal warning SLA (bisa dipanggil via AJAX)
     */
    public function showSlaWarningModal()
    {
        $user = auth()->user();
        
        if (!$user->hasRole('teknisi')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak']);
        }

        $layananTeknisi = Layanan::where('teknisi_id', $user->id)
            ->where('status_aktivasi', true)
            ->pluck('id');

        $criticalWarnings = Laporan::whereIn('layanan_id', $layananTeknisi)
            ->with(['layanan', 'user'])
            ->whereIn('status', ['baru', 'draft', 'proses', 'diproses'])
            ->get()
            ->filter(function ($laporan) {
                return in_array($laporan->status_sla, ['lewat', 'kritis']);
            })
            ->sortByDesc('sisa_sla')
            ->take(5); // Batasi untuk modal

        return response()->json([
            'success' => true,
            'html' => view('partials.sla-warning-modal', compact('criticalWarnings'))->render(),
            'count' => $criticalWarnings->count()
        ]);
    }
}
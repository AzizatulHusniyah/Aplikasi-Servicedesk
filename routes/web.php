<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PerangkatDaerahController;
use App\Http\Controllers\TipeLayananController;
use App\Http\Controllers\KategoriLayananController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RolesPermissionController;
use App\Http\Controllers\BukuManualController;
use App\Http\Controllers\BalasanLaporanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OtpVerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route untuk halaman welcome
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Redirect root ke welcome
Route::get('/', function () {
    return redirect('/welcome');
});

// Route tracking tiket (publik - tanpa auth)
Route::post('/track-ticket-public', [LaporanController::class, 'trackTicketPublic'])
    ->name('track.ticket.public');

// Route untuk melihat laporan publik
Route::get('/public-laporan/{id}', [LaporanController::class, 'showPublic'])
    ->name('laporan.show.public');

Route::get('/public-laporan/{id}/download', [LaporanController::class, 'downloadLampiranPublic'])
    ->name('laporan.download.public');

Route::get('/public-laporan/{id}/download-balasan', [LaporanController::class, 'downloadLampiranBalasanPublic'])
    ->name('laporan.download.balasan.public');

// =========================================================================
// ROUTE AJAX UNTUK GET LAYANAN BY KATEGORI (HARUS DITEMPATKAN DI LUAR AUTH)
// =========================================================================
Route::get('/get-layanan-by-kategori/{kategoriId}', [LaporanController::class, 'getLayananByKategori'])
    ->name('get.layanan.by.kategori');
    
// Auth routes dengan registrasi khusus
Auth::routes(['register' => true]);

// Override route registrasi default
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/otp-verification', [OtpVerificationController::class, 'showVerificationForm'])
    ->name('otp.verification');
Route::post('/otp-verify', [OtpVerificationController::class, 'verifyOtp'])
    ->name('otp.verify');
Route::post('/otp-resend', [OtpVerificationController::class, 'resendOtp'])
    ->name('otp.resend');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - accessible to all authenticated users with view dashboard permission
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('permission:view dashboard');

    // Route untuk API warning SLA
    Route::get('/dashboard/sla-warning', [DashboardController::class, 'getWarningSla'])
        ->name('dashboard.sla-warning')
        ->middleware('permission:view dashboard');

    // Profile - accessible to all authenticated users with view profile permission
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit')
        ->middleware('permission:view profile');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update')
        ->middleware('permission:view profile');

    // =========================================================================
    // ROUTES BUKU MANUAL
    // =========================================================================
    Route::prefix('buku-manual')->name('buku-manual.')->group(function () {
        Route::get('/', [BukuManualController::class, 'index'])
            ->name('index')
            ->middleware('permission:view buku-manual');
        Route::get('/create', [BukuManualController::class, 'create'])
            ->name('create')
            ->middleware('permission:create buku-manual');
        Route::post('/', [BukuManualController::class, 'store'])
            ->name('store')
            ->middleware('permission:create buku-manual');
        Route::get('/{id}', [BukuManualController::class, 'show'])
            ->name('show')
            ->middleware('permission:view buku-manual');
        Route::get('/{id}/edit', [BukuManualController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:edit buku-manual');
        Route::put('/{id}', [BukuManualController::class, 'update'])
            ->name('update')
            ->middleware('permission:edit buku-manual');
        Route::delete('/{id}', [BukuManualController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:delete buku-manual');

        // Routes untuk file handling
        Route::get('/{id}/download', [BukuManualController::class, 'download'])
            ->name('download')
            ->middleware('permission:view buku-manual');
        Route::get('/{id}/preview', [BukuManualController::class, 'preview'])
            ->name('preview')
            ->middleware('permission:view buku-manual');
        Route::get('/{id}/view', [BukuManualController::class, 'view'])
            ->name('view')
            ->middleware('permission:view buku-manual');
    });

    // =========================================================================
    // ROUTES LAPORAN
    // =========================================================================
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])
            ->name('index')
            ->middleware('permission:view laporan');
        Route::get('/create', [LaporanController::class, 'create'])
            ->name('create')
            ->middleware('permission:create laporan');
        Route::post('/', [LaporanController::class, 'store'])
            ->name('store')
            ->middleware('permission:create laporan');
        Route::get('/{id}', [LaporanController::class, 'show'])
            ->name('show')
            ->middleware('permission:view laporan');
        Route::get('/{id}/download', [LaporanController::class, 'downloadLampiran'])
            ->name('download')
            ->middleware('permission:view laporan');
        Route::get('/{id}/download-balasan', [LaporanController::class, 'downloadLampiranBalasan'])
            ->name('download.balasan')
            ->middleware('permission:view laporan');

        // Routes untuk edit dan delete (hanya admin)
        Route::middleware(['admin'])->group(function () {
            Route::get('/{id}/edit', [LaporanController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:edit laporan');
            Route::put('/{id}', [LaporanController::class, 'update'])
                ->name('update')
                ->middleware('permission:edit laporan');
            Route::delete('/{id}', [LaporanController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:delete laporan');
        });
    });

    // =========================================================================
    // ROUTES BALASAN LAPORAN
    // =========================================================================
    Route::prefix('balasan-laporan')->name('balasan-laporan.')->group(function () {
        // Routes untuk melihat balasan laporan (semua role dengan permission 'view balasan-laporan')
        Route::get('/', [BalasanLaporanController::class, 'index'])
            ->name('index')
            ->middleware('permission:view balasan-laporan');
        Route::get('/{id}', [BalasanLaporanController::class, 'show'])
            ->name('show')
            ->middleware('permission:view balasan-laporan');

        // Routes untuk download dan view lampiran balasan
        Route::get('/{id}/download-lampiran', [BalasanLaporanController::class, 'downloadLampiranBalasan'])
            ->name('download-lampiran')
            ->middleware('permission:view balasan-laporan');
        Route::get('/{id}/view-lampiran', [BalasanLaporanController::class, 'viewLampiranBalasan'])
            ->name('view-lampiran')
            ->middleware('permission:view balasan-laporan');

        Route::get('/{id}/view-lampiran-laporan', [BalasanLaporanController::class, 'viewLampiranLaporan'])
        ->name('view-lampiran-laporan')
        ->middleware('permission:view balasan-laporan');
        Route::get('/{id}/view-lampiran-balasan', [BalasanLaporanController::class, 'viewLampiranBalasan'])
            ->name('view-lampiran-balasan')
            ->middleware('permission:view balasan-laporan');

        // PERBAIKAN: Routes untuk teknisi (membalas laporan) - gunakan POST untuk store
        Route::middleware('permission:balas laporan')->group(function () {
            Route::get('/{id}/create', [BalasanLaporanController::class, 'create'])->name('create');
            Route::post('/{id}', [BalasanLaporanController::class, 'store'])->name('store'); // DIUBAH: POST bukan store
            Route::get('/{id}/edit', [BalasanLaporanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BalasanLaporanController::class, 'update'])->name('update'); // DIUBAH: PUT bukan update
            Route::delete('/{id}/hapus-lampiran', [BalasanLaporanController::class, 'hapusLampiranBalasan'])->name('hapus-lampiran');
        });

        // Routes khusus untuk administrator (CRUD lengkap balasan laporan)
        Route::middleware(['admin'])->group(function () {
            Route::delete('/{id}', [BalasanLaporanController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:delete balasan-laporan');
        });
    });

    // =========================================================================
    // ROUTES UNTUK CETAK LAPORAN
    // =========================================================================
    Route::prefix('cetak-laporan')->name('cetak-laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'cetakLaporan'])
            ->name('index')
            ->middleware('permission:view laporan');
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])
            ->name('export-excel')
            ->middleware('permission:view laporan');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])
            ->name('export-pdf')
            ->middleware('permission:view laporan');
    });

    // =========================================================================
    // ROUTES UNTUK CETAK BALASAN LAPORAN
    // =========================================================================
    Route::prefix('cetak-balasan-laporan')->name('cetak-balasan-laporan.')->group(function () {
        Route::get('/', [BalasanLaporanController::class, 'cetakBalasanLaporan'])
            ->name('index')
            ->middleware('permission:view balasan-laporan');
        Route::get('/export-excel', [BalasanLaporanController::class, 'exportExcelBalasan'])
            ->name('export-excel')
            ->middleware('permission:view balasan-laporan');
        Route::get('/export-pdf', [BalasanLaporanController::class, 'exportPdfBalasan'])
            ->name('export-pdf')
            ->middleware('permission:view balasan-laporan');
    });

    // =========================================================================
    // ADMIN ONLY ROUTES
    // =========================================================================
    Route::middleware(['admin'])->group(function () {
        // Hak Akses
        Route::resource('hak-akses', HakAksesController::class)
            ->middleware('permission:view hak-akses,create hak-akses,edit hak-akses,delete hak-akses');

        // Roles Permission
        Route::get('/roles-permission', [RolesPermissionController::class, 'index'])
            ->name('roles-permission.index')
            ->middleware('permission:view roles-permission');
        Route::put('/roles-permission/{id}', [RolesPermissionController::class, 'update'])
            ->name('roles-permission.update')
            ->middleware('permission:edit roles-permission');

        // Pengguna
        Route::resource('pengguna', PenggunaController::class)
            ->names([
                'index' => 'pengguna.index',
                'create' => 'pengguna.create',
                'store' => 'pengguna.store',
                'edit' => 'pengguna.edit',
                'update' => 'pengguna.update',
                'destroy' => 'pengguna.destroy'
            ])
            ->middleware('permission:view pengguna,create pengguna,edit pengguna,delete pengguna');

        // Routes tambahan untuk edit profil pengguna oleh admin
        Route::get('/pengguna/{id}/edit-profile', [PenggunaController::class, 'editProfile'])
            ->name('pengguna.edit-profile')
            ->middleware('permission:edit pengguna');
        Route::put('/pengguna/{id}/update-profile', [PenggunaController::class, 'updateProfile'])
            ->name('pengguna.update-profile')
            ->middleware('permission:edit pengguna');

        // Master Data Routes
        Route::resource('perangkat-daerah', PerangkatDaerahController::class)
            ->middleware('permission:view perangkat-daerah,create perangkat-daerah,edit perangkat-daerah,delete perangkat-daerah');

        Route::resource('tipe-layanan', TipeLayananController::class)
            ->middleware('permission:view tipe-layanan,create tipe-layanan,edit tipe-layanan,delete tipe-layanan');

        Route::resource('kategori-layanan', KategoriLayananController::class)
            ->middleware('permission:view kategori-layanan,create kategori-layanan,edit kategori-layanan,delete kategori-layanan');

        Route::resource('layanan', LayananController::class)
            ->middleware('permission:view layanan,create layanan,edit layanan,delete layanan');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'nik',
        'nip_no_thl',
        'perangkat_daerah_id',
        'perangkat_daerah',
        'email',
        'no_whatsapp',
        'password',
        'role_requested',
        'otp_code',
        'otp_expires_at',
        'is_verified',
        'password_changed_at', // TAMBAH: Field untuk tracking perubahan password
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'is_verified' => 'boolean',
            'password' => 'hashed',
            'password_changed_at' => 'datetime', // TAMBAH: Cast sebagai datetime
        ];
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

    public function hasPerangkatDaerah()
    {
        return !is_null($this->perangkat_daerah_id);
    }

    public function canAccessAdmin()
    {
        return $this->hasRole('administrator');
    }

    public function canEditPerangkatDaerah()
    {
        // Administrator selalu bisa mengedit
        if ($this->hasRole('administrator')) {
            return true;
        }

        // User biasa hanya bisa mengedit jika belum memiliki perangkat daerah
        return !$this->hasPerangkatDaerah();
    }

    public function isProfileComplete()
    {
        return !empty($this->name) && 
            !empty($this->email) && 
            !empty($this->perangkat_daerah_id);
    }

    public function getIncompleteFields()
    {
        $incomplete = [];
        
        if (empty($this->name)) {
            $incomplete[] = 'Nama Lengkap';
        }
        
        if (empty($this->email)) {
            $incomplete[] = 'Alamat Email';
        }
        
        if (empty($this->perangkat_daerah_id)) {
            $incomplete[] = 'Perangkat Daerah';
        }
        
        return $incomplete;
    }

    // Method untuk mengecek apakah user adalah reguler user
    public function isRegularUser()
    {
        return $this->hasRole('user');
    }

    // TAMBAH: Relasi ke Layanan (sebagai teknisi)
    public function layanans()
    {
        return $this->hasMany(Layanan::class, 'teknisi_id');
    }

    // TAMBAH: Method untuk mendapatkan teknisi yang tersedia
    public static function getTeknisi()
    {
        return self::whereHas('roles', function($query) {
            $query->where('name', 'teknisi');
        })->get();
    }

    public function generateOtp()
    {
        $this->otp_code = sprintf("%06d", mt_rand(1, 999999));
        $this->otp_expires_at = now()->addMinutes(10); // OTP berlaku 10 menit
        $this->is_verified = false;
        $this->save();

        \Log::info("OTP generated for {$this->email}: {$this->otp_code}");

        return $this->otp_code;
    }

    public function verifyOtp($otp)
    {
        // Pastikan otp_expires_at adalah Carbon instance
        $expiry = $this->otp_expires_at;
        if (is_string($expiry)) {
            $expiry = Carbon::parse($expiry);
        }

        // Cek jika OTP sudah expired
        if ($expiry && $expiry->isPast()) {
            \Log::warning("OTP expired for {$this->email}");
            return false;
        }

        // Cek jika OTP cocok
        if ($this->otp_code === $otp) {
            $this->is_verified = true;
            $this->email_verified_at = now();
            $this->otp_code = null;
            $this->otp_expires_at = null;
            $this->save();

            \Log::info("OTP verified successfully for {$this->email}");
            return true;
        }

        \Log::warning("Invalid OTP attempt for {$this->email}. Expected: {$this->otp_code}, Got: {$otp}");
        return false;
    }

    public function isOtpExpired()
    {
        $expiry = $this->otp_expires_at;

        // Jika null, berarti tidak ada OTP
        if (!$expiry) {
            return true;
        }

        // Pastikan otp_expires_at adalah Carbon instance
        if (is_string($expiry)) {
            $expiry = Carbon::parse($expiry);
        }

        return $expiry->isPast();
    }

    public function hasVerifiedEmail()
    {
        return $this->is_verified;
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'user_id');
    }

    public function laporanBalasan()
    {
        return $this->hasMany(Laporan::class, 'teknisi_id');
    }

    public function hasPublicPerangkatDaerah()
    {
        if (!$this->perangkatDaerah) {
            return false;
        }
        
        return $this->perangkatDaerah->publik;
    }

    // TAMBAH: Method untuk password warning system
    public function shouldShowPasswordWarning()
    {
        // Hanya tampilkan warning untuk role tertentu
        $rolesWithPasswordPolicy = ['administrator', 'teknisi', 'eselon'];
        
        if (!$this->hasAnyRole($rolesWithPasswordPolicy)) {
            return false;
        }

        // Jika belum pernah mengubah password, gunakan created_at
        $passwordChangeDate = $this->password_changed_at ?? $this->created_at;
        
        $threeMonthsAgo = now()->subMonths(3);
        $warningPeriod = now()->subMonths(2)->subWeeks(2); // 2 minggu sebelum 3 bulan

        return $passwordChangeDate <= $warningPeriod;
    }

    public function isPasswordExpired()
    {
        // Hanya berlaku untuk role tertentu
        $rolesWithPasswordPolicy = ['administrator', 'teknisi', 'eselon'];
        
        if (!$this->hasAnyRole($rolesWithPasswordPolicy)) {
            return false;
        }

        $passwordChangeDate = $this->password_changed_at ?? $this->created_at;
        $threeMonthsAgo = now()->subMonths(3);

        return $passwordChangeDate <= $threeMonthsAgo;
    }

    public function getDaysUntilPasswordExpiry()
    {
        $passwordChangeDate = $this->password_changed_at ?? $this->created_at;
        $expiryDate = $passwordChangeDate->copy()->addMonths(3);
        
        return now()->diffInDays($expiryDate, false); // false untuk menampilkan nilai negatif jika sudah expired
    }

    public function getPasswordWarningMessage()
    {
        if ($this->isPasswordExpired()) {
            return [
                'type' => 'danger',
                'message' => 'Password Anda telah kadaluarsa! Silakan ubah password segera untuk keamanan akun.',
                'days' => 0
            ];
        }

        if ($this->shouldShowPasswordWarning()) {
            $daysLeft = $this->getDaysUntilPasswordExpiry();
            return [
                'type' => 'warning',
                'message' => "Password Anda akan kadaluarsa dalam {$daysLeft} hari. Silakan ubah password segera.",
                'days' => $daysLeft
            ];
        }

        return null;
    }

    // Method untuk update password_changed_at ketika password diubah
    public function updatePasswordChangedAt()
    {
        $this->update(['password_changed_at' => now()]);
    }
}
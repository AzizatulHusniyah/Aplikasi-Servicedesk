@extends('layouts.guest')

@section('content')
<div class="container-fluid login-container">
    <div class="row justify-content-center w-100">
        <!-- PERUBAHAN: Fixed width column untuk ukuran tetap -->
        <div class="col-auto">
            <div class="card shadow-lg border-0 login-card">
                <div class="row g-0">
                    
                    {{-- Kiri: Panel Informasi Berwarna Biru (Identitas) --}}
                    <div class="col-lg-5 d-none d-lg-block bg-kominfo-dark p-4 rounded-start-lg">
                        <div class="text-center text-white h-100 d-flex flex-column justify-content-center align-items-center">
                            
                            {{-- Logo dengan ukuran minimalis --}}
                            <div class="logo-container mb-3">
                                <img src="{{ asset('images/logo1.png') }}" alt="Logo Servicedesk" class="login-logo">
                            </div>
                                                
                            {{-- Perbaikan spasi: lebih dekat --}}
                            <h2 class="fw-bold mb-1 fs-5 text-uppercase letter-spacing-1">Servicedesk</h2>
                            <h4 class="mb-3 fs-6 text-uppercase letter-spacing-1">Gresik</h4>
                            
                            <p class="text-white-50 mt-2 small lh-sm">{{ __('Verifikasi keamanan untuk mengakses layanan Servicedesk Kabupaten Gresik.') }}</p>
                        </div>
                    </div>

                    {{-- Kanan: Form OTP Berwarna Putih --}}
                    <div class="col-lg-7 p-4">
                        <div class="card-body p-3">
                            
                            <h3 class="fw-bold text-kominfo-dark-accent mb-3 fs-5 text-uppercase letter-spacing-1">{{ __('Verifikasi OTP') }}</h3>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show small mb-3" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show small mb-3" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show small mb-3" role="alert">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Email Display --}}
                            <div class="alert alert-info alert-dismissible fade show small mb-4" role="alert">
                                <i class="fas fa-envelope me-2"></i>
                                Kode OTP telah dikirim ke: <strong>{{ $email }}</strong>
                            </div>

                            <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">

                                {{-- OTP Code Field --}}
                                <div class="mb-4">
                                    <label for="otp_code" class="form-label fw-semibold small mb-3">
                                        {{ __('Kode OTP') }} <span class="text-danger">*</span>
                                    </label>
                                    <input id="otp_code" type="text"
                                           class="form-control otp-code-input @error('otp_code') is-invalid @enderror"
                                           name="otp_code"
                                           value="{{ old('otp_code') }}"
                                           required
                                           autofocus
                                           maxlength="6"
                                           placeholder="000000"
                                           autocomplete="off"
                                           inputmode="numeric">

                                    @error('otp_code')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror

                                    <div class="form-text text-center mt-2 small">
                                        Masukkan 6 digit kode yang dikirim ke email Anda
                                    </div>
                                </div>

                                {{-- Verify Button --}}
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-kominfo-accent btn-lg fw-bold py-2" id="verifyBtn">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <span id="verifyText">{{ __('Verifikasi OTP') }}</span>
                                        <div id="verifySpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </button>
                                </div>

                                {{-- Resend OTP --}}
                                <div class="text-center mb-3">
                                    <p class="mb-2 small text-muted">Tidak menerima kode OTP?</p>
                                    <form method="POST" action="{{ route('otp.resend') }}" id="resendForm">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <button type="submit" class="btn btn-link resend-otp p-0 small" id="resendBtn">
                                            <i class="fas fa-redo me-1"></i>
                                            <span id="resendText">Kirim Ulang OTP</span>
                                        </button>
                                        <span id="countdown" class="countdown d-none ms-2"></span>
                                    </form>
                                </div>

                                {{-- Information Box --}}
                                <div class="alert alert-info alert-dismissible fade show small" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div>
                                        <strong>Informasi:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Kode OTP berlaku selama <strong>10 menit</strong></li>
                                            <li>Periksa folder <strong>spam</strong> jika tidak menemukan email</li>
                                            <li>Pastikan email yang dimasukkan sudah benar</li>
                                        </ul>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-3">

                            {{-- Back to Login --}}
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none text-muted small fw-semibold">
                                    <i class="fas fa-arrow-left me-1"></i> {{ __('Kembali ke Halaman Login') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ------------------------------------- */
/* CUSTOM STYLES DENGAN PALET WARNA KOMINFO */
/* ------------------------------------- */

/* Palet Warna Kominfo */
.login-card .bg-kominfo-dark {
    background-color: #003366 !important; 
    background-image: linear-gradient(135deg, #003366 0%, #004d99 100%) !important; 
}

.text-kominfo-dark-accent {
    color: #003366 !important;
}
.text-kominfo-accent {
    color: #003366 !important;
}
.btn-kominfo-accent {
    color: #fff;
    background-color: #003366;
    border-color: #00BFFF;
    transition: all 0.2s ease-in-out;
}
.btn-kominfo-accent:hover {
    color: #fff;
    background-color: #00A3D9; 
    border-color: #00A3D9;
}

/* PERUBAHAN: Kustomisasi Layout Card untuk fixed size */
.login-container {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f0f2f5; 
    padding: 20px;
    min-height: 100vh;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* PERUBAHAN: Fixed width card dengan width tetap */
.login-card {
    width: 700px; /* Ganti max-width dengan width fixed */
    min-width: 700px; /* Pastikan tidak lebih kecil */
    border-radius: 1rem !important; 
    overflow: hidden; 
    animation: fadeInScale 0.5s ease-out forwards;
    /* PERUBAHAN: Center card secara horizontal dan vertikal */
    position: relative;
    margin: 0 auto;
}

.rounded-start-lg {
    border-top-left-radius: 1rem !important;
    border-bottom-left-radius: 1rem !important;
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

/* PERBAIKAN LOGO CONTAINER - UKURAN MINIMALIS */
.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100px;
    height: 100px;
    background-color: white;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

/* PERBAIKAN UKURAN LOGO - Minimalis dan tidak terpotong */
.login-logo {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
}

/* PERBAIKAN TYPOGRAPHY - Lebih rapi dan formal */
.letter-spacing-1 {
    letter-spacing: 0.5px;
}

/* PERBAIKAN SPASI ANTARA JUDUL - Lebih dekat */
.bg-kominfo-dark h2 {
    margin-bottom: 0.5rem !important;
}

.bg-kominfo-dark h4 {
    margin-bottom: 1rem !important;
}

/* Font family yang lebih formal */
.login-card {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Perbaikan line height untuk keterbacaan yang lebih baik */
.bg-kominfo-dark h2,
.bg-kominfo-dark h4,
.bg-kominfo-dark p {
    line-height: 1.3;
}

/* Kustomisasi Input Focus */
.form-control:focus {
    border-color: #00BFFF;
    box-shadow: 0 0 0 0.25rem rgba(0, 191, 255, 0.25);
}

/* OTP Code Input Styling */
.otp-code-input {
    font-size: 1.3rem;
    font-weight: bold;
    letter-spacing: 0.4rem;
    text-align: center;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 0.75rem;
    transition: all 0.3s ease;
    height: 3.5rem;
}

.otp-code-input:focus {
    border-color: #00BFFF;
    box-shadow: 0 0 0 0.25rem rgba(0, 191, 255, 0.25);
    outline: none;
}

/* Kustomisasi Alert */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-size: 0.8rem;
    line-height: 1.4;
}

.alert-info ul {
    margin-bottom: 0;
}

.alert-info li {
    font-size: 0.75rem;
}

/* Resend OTP Link */
.resend-otp {
    color: #003366;
    text-decoration: none;
    cursor: pointer;
    border: none;
    background: none;
    font-size: 0.8rem;
    font-weight: 500;
}

.resend-otp:hover {
    color: #00A3D9;
    text-decoration: underline;
}

.resend-otp:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    text-decoration: none;
}

.countdown {
    font-weight: bold;
    color: #dc3545;
    font-size: 0.8rem;
}

/* PERUBAHAN: Responsive adjustments untuk fixed size */
@media (max-width: 1199.98px) {
    .login-card {
        width: 700px; /* Tetap sama untuk desktop */
        min-width: 700px;
    }
}

@media (max-width: 991.98px) {
    .login-card {
        width: 650px; /* Sedikit lebih kecil untuk tablet landscape */
        min-width: 650px;
    }
    
    .logo-container {
        width: 80px;
        height: 80px;
        padding: 8px;
    }
    
    .bg-kominfo-dark h2 {
        font-size: 1.1rem !important;
        margin-bottom: 0.4rem !important;
    }
    
    .bg-kominfo-dark h4 {
        font-size: 0.95rem !important;
        margin-bottom: 0.8rem !important;
    }

    .otp-code-input {
        font-size: 1.1rem;
        letter-spacing: 0.3rem;
        height: 3rem;
        padding: 0.6rem;
    }
}

@media (max-width: 767.98px) {
    .login-card {
        width: 500px; /* Ukuran untuk tablet portrait */
        min-width: 500px;
    }
}

@media (max-width: 575.98px) {
    .login-card {
        width: 100%; /* Untuk mobile, gunakan full width */
        min-width: auto;
        max-width: 400px; /* Tapi batasi maksimal width */
    }
    
    .logo-container {
        width: 70px;
        height: 70px;
        padding: 6px;
    }
    
    .login-container {
        padding: 15px;
    }
    
    .bg-kominfo-dark h2 {
        font-size: 1rem !important;
        margin-bottom: 0.3rem !important;
    }
    
    .bg-kominfo-dark h4 {
        font-size: 0.9rem !important;
        margin-bottom: 0.7rem !important;
    }

    .otp-code-input {
        font-size: 1rem;
        letter-spacing: 0.2rem;
        height: 2.8rem;
        padding: 0.5rem;
    }
}

/* Hover effect untuk logo (opsional) */
.logo-container:hover {
    transform: scale(1.05);
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.25);
}

.btn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp_code');
    const otpForm = document.getElementById('otpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyText = document.getElementById('verifyText');
    const verifySpinner = document.getElementById('verifySpinner');
    const resendForm = document.getElementById('resendForm');
    const resendBtn = document.getElementById('resendBtn');
    const resendText = document.getElementById('resendText');
    const countdownEl = document.getElementById('countdown');

    let canResend = true;
    let countdown = 30; // 30 detik cooldown

    // Format input OTP - hanya angka
    otpInput.addEventListener('keypress', function(e) {
        const charCode = e.which ? e.which : e.keyCode;
        if (charCode < 48 || charCode > 57) {
            e.preventDefault();
            return false;
        }
    });

    // Auto submit ketika OTP lengkap
    otpInput.addEventListener('input', function() {
        // Hapus karakter non-angka
        this.value = this.value.replace(/\D/g, '');

        if (this.value.length === 6) {
            verifyText.classList.add('d-none');
            verifySpinner.classList.remove('d-none');
            verifyBtn.disabled = true;

            // Auto submit setelah 500ms
            setTimeout(() => {
                otpForm.submit();
            }, 500);
        }
    });

    // Handle form submission
    otpForm.addEventListener('submit', function(e) {
        if (otpInput.value.length !== 6) {
            e.preventDefault();
            showAlert('error', 'Harap masukkan 6 digit kode OTP');
            otpInput.focus();
            return;
        }

        verifyText.classList.add('d-none');
        verifySpinner.classList.remove('d-none');
        verifyBtn.disabled = true;
    });

    // Handle resend OTP
    resendForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!canResend) {
            return;
        }

        // Show loading state
        resendBtn.disabled = true;
        const originalText = resendText.textContent;
        resendText.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengirim...';

        // Submit form
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || 'Kode OTP baru telah dikirim!');
                startCountdown();
            } else {
                showAlert('error', data.message || 'Gagal mengirim OTP. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(() => {
            resendText.innerHTML = '<i class="fas fa-redo me-1"></i>Kirim Ulang OTP';
            resendBtn.disabled = false;
        });
    });

    function startCountdown() {
        canResend = false;
        resendBtn.disabled = true;
        countdownEl.classList.remove('d-none');

        const countdownInterval = setInterval(() => {
            countdownEl.textContent = `(${countdown}s)`;
            countdown--;

            if (countdown < 0) {
                clearInterval(countdownInterval);
                canResend = true;
                resendBtn.disabled = false;
                countdownEl.classList.add('d-none');
                countdown = 30;
            }
        }, 1000);
    }

    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert-dismissible');
        existingAlerts.forEach(alert => alert.remove());

        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show small mb-3" role="alert">
                <i class="fas ${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.querySelector('.card-body').insertAdjacentHTML('afterbegin', alertHtml);

        // Auto close alert after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert-dismissible');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

    // Focus on OTP input
    otpInput.focus();

    // Select all text when focused
    otpInput.addEventListener('focus', function() {
        this.select();
    });
});
</script>
@endpush
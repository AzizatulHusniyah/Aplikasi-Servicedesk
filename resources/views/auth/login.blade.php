@extends('layouts.guest')

@section('content')
<div class="container-fluid login-container">
    <div class="row justify-content-center w-100">
        <div class="col-xl-8 col-lg-9 col-md-10">
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
                            
                            <p class="text-white-50 mt-2 small lh-sm">{{ __('Masuk ke akun Anda untuk mengakses layanan Servicedesk Kabupaten Gresik.') }}</p>
                        </div>
                    </div>

                    {{-- Kanan: Form Login Berwarna Putih --}}
                    <div class="col-lg-7 p-4">
                        <div class="card-body p-3">
                            
                            {{-- Perbaikan font judul form --}}
                            <h3 class="fw-bold text-kominfo-dark-accent mb-4 fs-5 text-uppercase letter-spacing-1">{{ __('Login Akun Anda') }}</h3>

                            {{-- Alert untuk semua error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Email Field --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold small">{{ __('Alamat Email') }} <span class="text-danger">*</span></label> 
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan alamat email">
                                    @error('email')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                {{-- Password Field --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold small">{{ __('Kata Sandi') }} <span class="text-danger">*</span></label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
                                    @error('password')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                {{-- Security Code Field --}}
                                <div class="mb-3">
                                    <label for="security_code" class="form-label fw-semibold small">{{ __('Kode Keamanan') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="security_code" type="text" class="form-control text-uppercase @error('security_code') is-invalid @enderror" 
                                               name="security_code" value="{{ old('security_code') }}" required 
                                               maxlength="6" placeholder="Masukkan kode keamanan" style="letter-spacing: 2px;">
                                        <span class="input-group-text bg-light fw-bold text-kominfo-dark-accent security-code-display" 
                                              style="font-family: 'Courier New', monospace; letter-spacing: 2px;">
                                            {{ $securityCode ?? 'LOADING' }}
                                        </span>
                                    </div>
                                    @error('security_code')
                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <small class="form-text text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Masukkan 6 karakter kode keamanan di atas
                                    </small>
                                </div>

                                {{-- Remember Me & Forgot Password --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted small" for="remember">
                                            {{ __('Ingat Saya') }}
                                        </label>
                                    </div>
                                </div>

                                {{-- Login Button --}}
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-kominfo-accent btn-lg fw-bold" id="submit-btn">
                                        <i class="fas fa-sign-in-alt me-2"></i> {{ __('Login') }}
                                    </button>
                                </div>
                                
                                <hr class="my-3">

                                {{-- Link Register --}}
                                <div class="text-center">
                                    <a href="{{ route('register') }}" class="text-decoration-none text-muted small fw-semibold">
                                        <i class="fas fa-user-plus me-1"></i> {{ __('Belum punya akun? Daftar di sini') }}
                                    </a>
                                </div>
                            </form>
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

/* Kustomisasi Layout Card */
.login-container {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f0f2f5; 
    padding: 20px;
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

/* PERKECIL MAX-WIDTH CARD */
.login-card {
    max-width: 850px;
    width: 100%;
    border-radius: 1rem !important; 
    overflow: hidden; 
    animation: fadeInScale 0.5s ease-out forwards;
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
    margin-bottom: 0.5rem !important; /* Diperkecil dari 1rem */
}

.bg-kominfo-dark h4 {
    margin-bottom: 1rem !important; /* Diperkecil dari 1.5rem */
}

/* Font family yang lebih formal */
.login-card {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Perbaikan line height untuk keterbacaan yang lebih baik */
.bg-kominfo-dark h2,
.bg-kominfo-dark h4,
.bg-kominfo-dark p {
    line-height: 1.3; /* Diperkecil dari 1.4 */
}

/* Kustomisasi Input Focus */
.form-control:focus {
    border-color: #00BFFF;
    box-shadow: 0 0 0 0.25rem rgba(0, 191, 255, 0.25);
}

/* Kustomisasi Tombol Outline */
.btn-outline-light {
    border-width: 2px !important;
}

/* Security Code Styles */
.security-code-display {
    min-width: 100px;
    font-size: 0.9rem;
    border: 2px dashed #003366 !important;
    background-color: #f8f9fa !important;
}

.input-group-text {
    border-left: none !important;
}

.form-control.text-uppercase {
    text-transform: uppercase;
}

/* Security code input focus */
#security_code:focus {
    border-color: #00BFFF;
    box-shadow: 0 0 0 0.25rem rgba(0, 191, 255, 0.25);
}

/* CAPTCHA Styles */
.captcha-image {
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.captcha-image:hover {
    opacity: 0.8;
}

.captcha-container {
    text-align: center;
}

#refresh-captcha {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    transition: all 0.2s ease;
}

#refresh-captcha:hover {
    background-color: #003366;
    color: white;
}

/* Responsive adjustments untuk ukuran minimalis */
@media (max-width: 991.98px) {
    .logo-container {
        width: 80px;
        height: 80px;
        padding: 8px;
    }
    
    /* Perbaikan ukuran font di tablet */
    .bg-kominfo-dark h2 {
        font-size: 1.1rem !important;
        margin-bottom: 0.4rem !important;
    }
    
    .bg-kominfo-dark h4 {
        font-size: 0.95rem !important;
        margin-bottom: 0.8rem !important;
    }

    /* Security code responsive */
    .security-code-display {
        min-width: 80px;
        font-size: 0.8rem;
    }
}

@media (max-width: 575.98px) {
    .logo-container {
        width: 70px;
        height: 70px;
        padding: 6px;
    }
    
    .login-container {
        padding: 15px;
    }
    
    /* Perbaikan ukuran font di mobile */
    .bg-kominfo-dark h2 {
        font-size: 1rem !important;
        margin-bottom: 0.3rem !important;
    }
    
    .bg-kominfo-dark h4 {
        font-size: 0.9rem !important;
        margin-bottom: 0.7rem !important;
    }

    /* Security code mobile */
    .security-code-display {
        min-width: 70px;
        font-size: 0.75rem;
    }

    .captcha-image {
        height: 35px !important;
    }
}

/* Hover effect untuk logo (opsional) */
.logo-container:hover {
    transform: scale(1.05);
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.25);
}

/* Loading state untuk tombol */
.btn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

/* Alert customization */
.alert {
    border-radius: 0.5rem;
    border: none;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d1edff;
    color: #0c5460;
    border-left: 4px solid #003366;
}

/* CAPTCHA Styles */
.captcha-container {
    text-align: center;
}

#captcha-question {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    font-family: 'Courier New', monospace;
    transition: all 0.3s ease;
}

#refresh-captcha {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    transition: all 0.2s ease;
}

#refresh-captcha:hover {
    background-color: #003366;
    color: white;
}

@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const securityCodeInput = document.getElementById('security_code');
    
    if (securityCodeInput) {
        // Auto uppercase dan batasi 6 karakter
        securityCodeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase().substring(0, 6);
        });
        
        // Validasi format (hanya huruf dan angka)
        securityCodeInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.keyCode || e.which);
            if (!/^[A-Za-z0-9]$/.test(char)) {
                e.preventDefault();
            }
        });

        // Focus ke security code field jika ada error
        @if($errors->has('security_code'))
            securityCodeInput.focus();
        @endif
    }
});
</script>
@endpush
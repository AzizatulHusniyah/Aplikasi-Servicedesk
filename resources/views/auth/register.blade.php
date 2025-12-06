@extends('layouts.guest')

@section('content')
<div class="container-fluid login-container">
    <div class="row justify-content-center w-100">
        {{-- Perkecil max-width container --}}
        <div class="col-xl-7 col-lg-8 col-md-9">
            <div class="card shadow-lg border-0 login-card">
                <div class="row g-0">
                    
                    {{-- Kiri: Panel Informasi Berwarna Biru (Identitas) --}}
                    <div class="col-lg-5 d-none d-lg-block bg-kominfo-dark p-3 rounded-start-lg">
                        <div class="text-center text-white h-100 d-flex flex-column justify-content-center align-items-center">
                            
                            {{-- Logo dengan ukuran minimalis --}}
                            <div class="logo-container mb-2">
                                <img src="{{ asset('images/logo1.png') }}" alt="Logo Servicedesk" class="login-logo">
                            </div>
                                                
                            {{-- Perbaikan spasi: lebih dekat --}}
                            <h2 class="fw-bold mb-1 fs-6 text-uppercase letter-spacing-1">Servicedesk</h2>
                            <h4 class="mb-2 fs-7 text-uppercase letter-spacing-1">Gresik</h4>
                            
                            <p class="text-white-50 mt-1 small lh-sm">{{ __('Daftar akun baru untuk mengakses layanan Servicedesk Kabupaten Gresik.') }}</p>
                        </div>
                    </div>

                    {{-- Kanan: Form Register Berwarna Putih --}}
                    <div class="col-lg-7 p-3">
                        <div class="card-body p-2">
                            
                            <h3 class="fw-bold text-kominfo-dark-accent mb-3 fs-6 text-uppercase letter-spacing-1">{{ __('Daftar Akun Baru') }}</h3>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show small mb-2" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show small mb-2" role="alert">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}" class="compact-form">
                                @csrf

                                <div class="row g-2">
                                    {{-- Nama Lengkap Field --}}
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold small">{{ __('Nama Lengkap') }} <span class="text-danger">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama lengkap">
                                        @error('name')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    {{-- Email Field --}}
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold small">{{ __('Email') }} <span class="text-danger">*</span></label> 
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@gmail.com">
                                        @error('email')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    {{-- No WhatsApp Field --}}
                                    <div class="col-12">
                                        <label for="no_whatsapp" class="form-label fw-semibold small">{{ __('WhatsApp') }}</label>
                                        <input id="no_whatsapp" type="text" class="form-control @error('no_whatsapp') is-invalid @enderror" name="no_whatsapp" value="{{ old('no_whatsapp') }}" autocomplete="no_whatsapp" placeholder="081234567890">
                                        @error('no_whatsapp')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    {{-- Password Field --}}
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold small">{{ __('Password') }} <span class="text-danger">*</span></label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Masukkan password">
                                        <div class="password-warning mt-1">
                                            <small class="form-text text-muted small">Minimal 8 karakter, mengandung huruf kapital, angka, dan karakter khusus</small>
                                            <div id="password-strength" class="small mt-1" style="display: none;"></div>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                        
                                        {{-- Warning Container --}}
                                        <div id="password-warnings" class="mt-1"></div>
                                    </div>

                                    {{-- Confirm Password Field --}}
                                    <div class="col-md-6">
                                        <label for="password-confirm" class="form-label fw-semibold small">{{ __('Konfirmasi Password') }} <span class="text-danger">*</span></label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password">
                                        <div id="password-match" class="small mt-1" style="display: none;"></div>
                                        
                                        {{-- Match Warning Container --}}
                                        <div id="confirm-warnings" class="mt-1"></div>
                                    </div>
                                </div>

                                {{-- Info Alert --}}
                                <div class="alert alert-info alert-dismissible fade show small mt-2 mb-2" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong> Registrasi hanya diperbolehkan untuk User Reguler. Role lainnya (Administrator, Teknisi, Eselon) hanya dapat dibuat oleh Administrator.
                                </div>

                                {{-- Register Button --}}
                                <div class="d-grid gap-2 mb-1">
                                    <button type="submit" class="btn btn-kominfo-accent btn-md fw-bold py-2" id="submit-btn">
                                        <i class="fas fa-user-plus me-2"></i> {{ __('Daftar') }}
                                    </button>
                                </div>
                                
                                <hr class="my-2">

                                {{-- Link Login --}}
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-decoration-none text-muted small fw-semibold">
                                        <i class="fas fa-sign-in-alt me-1"></i> {{ __('Sudah punya akun? Login di sini') }}
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
    padding: 15px;
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
    max-width: 750px;
    width: 100%;
    border-radius: 0.8rem !important;
    overflow: hidden; 
    animation: fadeInScale 0.5s ease-out forwards;
}

.rounded-start-lg {
    border-top-left-radius: 0.8rem !important;
    border-bottom-left-radius: 0.8rem !important;
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

/* PERBAIKAN LOGO CONTAINER - UKURAN LEBIH MINIMALIS */
.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 80px;
    height: 80px;
    background-color: white;
    border-radius: 50%;
    padding: 8px;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.12);
    margin-bottom: 0.8rem;
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

/* Font size untuk h4 */
.fs-7 {
    font-size: 0.8rem !important;
}

/* PERBAIKAN TYPOGRAPHY - Lebih rapi dan formal */
.letter-spacing-1 {
    letter-spacing: 0.4px;
}

/* PERBAIKAN SPASI ANTARA JUDUL - Lebih dekat */
.bg-kominfo-dark h2 {
    margin-bottom: 0.4rem !important;
}

.bg-kominfo-dark h4 {
    margin-bottom: 0.8rem !important;
}

/* Font family yang lebih formal */
.login-card {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Perbaikan line height untuk keterbacaan yang lebih baik */
.bg-kominfo-dark h2,
.bg-kominfo-dark h4,
.bg-kominfo-dark p {
    line-height: 1.2;
}

/* Kustomisasi Input Focus */
.form-control:focus {
    border-color: #00BFFF;
    box-shadow: 0 0 0 0.2rem rgba(0, 191, 255, 0.25);
}

/* Kustomisasi Alert */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
    border-radius: 0.4rem;
    padding: 0.5rem 0.6rem;
    font-size: 0.75rem;
    line-height: 1.3;
}

/* FORM COMPACT STYLING */
.compact-form .form-label {
    margin-bottom: 0.3rem;
    font-size: 0.8rem;
}

.compact-form .form-control {
    padding: 0.4rem 0.6rem;
    font-size: 0.85rem;
    height: 2.4rem;
}

.compact-form .form-text {
    margin-top: 0.2rem;
    font-size: 0.7rem;
}

.compact-form .row {
    margin-bottom: 0.2rem;
}

/* Card body centering */
.card-body {
    min-height: auto;
}

/* Kustomisasi Tombol */
.btn-md {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

/* Password strength indicator */
.password-warning {
    font-size: 0.75rem;
}

/* Validation states */
.is-valid {
    border-color: #198754 !important;
}

.is-invalid {
    border-color: #dc3545 !important;
}

/* Password strength text */
#password-strength i,
#password-match i {
    font-size: 0.7rem;
}

/* Responsive adjustments untuk ukuran minimalis */
@media (max-width: 991.98px) {
    .logo-container {
        width: 70px;
        height: 70px;
        padding: 6px;
    }
    
    .bg-kominfo-dark h2 {
        font-size: 0.95rem !important;
        margin-bottom: 0.3rem !important;
    }
    
    .bg-kominfo-dark h4 {
        font-size: 0.85rem !important;
        margin-bottom: 0.6rem !important;
    }

    .compact-form .form-control {
        height: 2.3rem;
    }
}

@media (max-width: 575.98px) {
    .logo-container {
        width: 60px;
        height: 60px;
        padding: 5px;
    }
    
    .login-container {
        padding: 10px;
    }
    
    .bg-kominfo-dark h2 {
        font-size: 0.9rem !important;
        margin-bottom: 0.2rem !important;
    }
    
    .bg-kominfo-dark h4 {
        font-size: 0.8rem !important;
        margin-bottom: 0.5rem !important;
    }

    .compact-form .form-control {
        padding: 0.35rem 0.5rem;
        font-size: 0.8rem;
        height: 2.2rem;
    }

    /* Pada mobile, buat form field full width */
    .compact-form .col-md-6 {
        width: 100%;
    }
}

/* Hover effect untuk logo (opsional) */
.logo-container:hover {
    transform: scale(1.05);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
}

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

/* Warning Styles */
.password-warning-alert {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
    border-radius: 0.4rem;
    padding: 0.4rem 0.6rem;
    font-size: 0.7rem;
    line-height: 1.3;
    margin-top: 0.3rem;
    animation: fadeIn 0.3s ease-in;
}

.password-warning-alert ul {
    margin-bottom: 0;
    padding-left: 1rem;
}

.password-warning-alert li {
    margin-bottom: 0.1rem;
}

.confirm-warning-alert {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
    border-radius: 0.4rem;
    padding: 0.4rem 0.6rem;
    font-size: 0.7rem;
    line-height: 1.3;
    margin-top: 0.3rem;
    animation: fadeIn 0.3s ease-in;
}

.confirm-success-alert {
    background-color: #d1edff;
    border: 1px solid #bee5eb;
    color: #0c5460;
    border-radius: 0.4rem;
    padding: 0.4rem 0.6rem;
    font-size: 0.7rem;
    line-height: 1.3;
    margin-top: 0.3rem;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password-confirm');
    const passwordWarnings = document.getElementById('password-warnings');
    const confirmWarnings = document.getElementById('confirm-warnings');
    const submitBtn = document.getElementById('submit-btn');

    function validatePassword(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            number: /\d/.test(password),
            special: /[@$!%*?&]/.test(password)
        };

        // Get unmet requirements
        const unmetRequirements = [];
        
        if (!requirements.length) {
            unmetRequirements.push('Minimal 8 karakter');
        }
        if (!requirements.uppercase) {
            unmetRequirements.push('Minimal 1 huruf kapital (A-Z)');
        }
        if (!requirements.number) {
            unmetRequirements.push('Minimal 1 angka (0-9)');
        }
        if (!requirements.special) {
            unmetRequirements.push('Minimal 1 karakter khusus (@$!%*?&)');
        }

        // Show/hide warnings
        showPasswordWarnings(unmetRequirements, password.length > 0);

        return Object.values(requirements).every(Boolean);
    }

    function showPasswordWarnings(unmetRequirements, hasInput) {
        if (unmetRequirements.length > 0 && hasInput) {
            let warningHTML = `
                <div class="password-warning-alert">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                        <div>
                            <strong class="d-block">Password belum memenuhi syarat:</strong>
                            <ul class="mb-0 mt-1">
            `;
            
            unmetRequirements.forEach(requirement => {
                warningHTML += `<li>${requirement}</li>`;
            });
            
            warningHTML += `
                            </ul>
                        </div>
                    </div>
                </div>
            `;
            
            passwordWarnings.innerHTML = warningHTML;
        } else {
            passwordWarnings.innerHTML = '';
        }
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (confirmPassword === '') {
            confirmWarnings.innerHTML = '';
            return;
        }

        if (password === confirmPassword && password !== '') {
            confirmWarnings.innerHTML = `
                <div class="confirm-success-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <span><strong>Sukses:</strong> Password cocok</span>
                    </div>
                </div>
            `;
        } else {
            confirmWarnings.innerHTML = `
                <div class="confirm-warning-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span><strong>Peringatan:</strong> Password tidak cocok</span>
                    </div>
                </div>
            `;
        }
    }

    function updateSubmitButtonState() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const isPasswordValid = validatePassword(password);
        const isPasswordMatch = password === confirmPassword && password !== '';
        
        // Optional: Disable submit button jika password tidak valid atau tidak match
        // if (submitBtn) {
        //     submitBtn.disabled = !isPasswordValid || !isPasswordMatch;
        // }
    }

    // Event listeners untuk password validation
    passwordInput.addEventListener('input', function() {
        validatePassword(this.value);
        checkPasswordMatch();
        updateSubmitButtonState();
    });

    confirmPasswordInput.addEventListener('input', function() {
        checkPasswordMatch();
        updateSubmitButtonState();
    });

    // Validasi form sebelum submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // Validasi password
        if (!validatePassword(password)) {
            e.preventDefault();
            // Focus ke password field
            passwordInput.focus();
            
            // Show all warnings
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                number: /\d/.test(password),
                special: /[@$!%*?&]/.test(password)
            };
            const unmetRequirements = [];
            Object.keys(requirements).forEach(key => {
                if (!requirements[key]) {
                    if (key === 'length') unmetRequirements.push('Minimal 8 karakter');
                    if (key === 'uppercase') unmetRequirements.push('Minimal 1 huruf kapital (A-Z)');
                    if (key === 'number') unmetRequirements.push('Minimal 1 angka (0-9)');
                    if (key === 'special') unmetRequirements.push('Minimal 1 karakter khusus (@$!%*?&)');
                }
            });
            
            showPasswordWarnings(unmetRequirements, true);
            
            return false;
        }

        // Validasi password match
        if (password !== confirmPassword) {
            e.preventDefault();
            confirmPasswordInput.focus();
            
            // Show match warning
            confirmWarnings.innerHTML = `
                <div class="confirm-warning-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span><strong>Error:</strong> Password tidak cocok. Silakan periksa kembali.</span>
                    </div>
                </div>
            `;
            
            return false;
        }

        // Show loading state pada submit button
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            submitBtn.disabled = true;
        }
    });

    // Initial validation state
    updateSubmitButtonState();

    console.log('Registration form initialized without security code');
});
</script>
@endpush
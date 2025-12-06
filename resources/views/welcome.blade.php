<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pusat Bantuan Layanan Aplikasi - Kabupaten Gresik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1E3C72;
            --primary-light: #2A5298;
            --secondary: #f8f9fa;
            --accent: #00A3D2;
            --text-dark: #2d3748;
            --text-light: #718096;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--secondary);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .welcome-container {
            padding: 0;
        }

        .navbar-custom {
            background-color: var(--primary);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }

        .navbar-brand {
            margin-right: auto;
            margin-left: 0;
        }

        .logo-text {
            color: var(--white);
            font-weight: 700;
            font-size: 1.35rem;
            margin-bottom: 0;
            letter-spacing: 0.5px;
        }

        .logo-subtext {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.2;
        }

        .btn-header-primary {
            background-color: var(--accent);
            border: 2px solid var(--accent);
            color: var(--white);
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-header-primary:hover {
            background-color: #008CB9;
            border-color: #008CB9;
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 163, 210, 0.3);
        }

        .btn-header-outline {
            background-color: transparent;
            border: 2px solid var(--white);
            color: var(--white);
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-header-outline:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
            transform: translateY(-2px);
        }

        .hero-section {
            position: relative;
            background: url("{{ asset('images/gambar1.png') }}") no-repeat center center;
            background-size: cover;
            min-height: 500px;
            display: flex;
            align-items: center;
            color: var(--white);
            margin-bottom: 3rem;
            overflow: hidden;
        }

        .hero-content {
            z-index: 10;
            padding: 3rem 0;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            font-size: 1.4rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            max-width: 600px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--accent) 0%, #008CB9 100%);
            border: 2px solid var(--accent);
            color: var(--white);
            border-radius: 8px;
            padding: 0.85rem 2.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1.05rem;
            box-shadow: 0 4px 12px rgba(0, 163, 210, 0.3);
        }

        .btn-hero-primary:hover {
            background: linear-gradient(135deg, #008CB9 0%, var(--accent) 100%);
            border-color: #008CB9;
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 163, 210, 0.4);
        }

        .btn-hero-outline {
            background-color: transparent;
            border: 2px solid var(--white);
            color: var(--white);
            border-radius: 8px;
            padding: 0.85rem 2.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1.05rem;
        }

        .btn-hero-outline:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 255, 255, 0.2);
        }

        .content-section {
            padding: 3rem 0 5rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            color: var(--primary);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-header h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .section-header p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .tracking-card {
            border: none;
            border-radius: var(--border-radius);
            background-color: var(--white);
            box-shadow: var(--shadow);
            padding: 3rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tracking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            border-radius: 8px;
            padding: 0.9rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
            font-size: 1.05rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(30, 60, 114, 0.4);
        }
        
        .alert-custom {
            border-radius: 8px;
            padding: 1.25rem 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 0;
            border-left: 4px solid var(--accent);
            background-color: rgba(0, 163, 210, 0.05);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            border-left-color: #28a745;
            background-color: rgba(40, 167, 69, 0.05);
        }

        .alert-danger {
            border-left-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.05);
        }

        .alert-warning {
            border-left-color: #ffc107;
            background-color: rgba(255, 193, 7, 0.05);
        }
        
        .footer-custom {
            background-color: var(--primary);
            color: rgba(255, 255, 255, 0.85);
            padding: 2rem 0;
            text-align: center;
            font-size: 0.95rem;
            margin-top: auto;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(0, 163, 210, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            font-size: 1.05rem;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s ease forwards;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.2rem;
            }
            .tracking-card {
                padding: 2rem;
            }
            .section-header h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="d-flex flex-column">

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Kabupaten Gresik" class="logo-img me-3" style="max-height: 50px; margin-left: -12pt">
                <div>
                    <div class="logo-text">Servicedesk</div>
                    <div class="logo-subtext">Kabupaten Gresik</div>
                </div>
            </a>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-sm btn-header-outline me-2">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-header-primary">Daftar</a>
            </div>
        </div>
    </nav>

    <main class="welcome-container flex-grow-1">
        <section class="hero-section">
            <div class="container hero-content animate-fade-in">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="hero-title">Selamat Datang</h1>
                        <p class="hero-subtitle">Di Pusat Bantuan Layanan Aplikasi Pemerintah Kabupaten Gresik</p>

                        <a href="#tracking-section" class="btn btn-hero-primary me-3 mb-2">
                            Lacak Tiket Anda
                        </a>
                        <a href="https://drive.google.com/file/d/1mftYFaq39hLEdvko8CZrHHvlcf0vlhWC/view?usp=sharing" class="btn btn-hero-outline mb-2" target="_blank">
                            Buku Manual Pengguna
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="tracking-section" class="content-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="section-header">
                            <h2>Lacak Tiket Anda</h2>
                            <p>Masukkan nomor tiket Anda untuk memeriksa status dan progres penanganan layanan</p>
                        </div>

                        <div class="tracking-card animate-fade-in">
                            <form method="POST" action="{{ route('track.ticket.public') }}" id="tracking-form">
                                @csrf
                                <div class="mb-4">
                                    <label for="ticketNumber" class="form-label">Nomor Tiket</label>
                                    <input type="text" class="form-control @error('ticketNumber') is-invalid @enderror"
                                        id="ticketNumber" name="ticketNumber"
                                        value="{{ old('ticketNumber') }}"
                                        placeholder="Contoh: TKT-251024-A1B2C3" required>
                                    @error('ticketNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2" id="track-button">
                                    <i class="fas fa-search me-2"></i> Lacak Tiket Anda
                                </button>
                            </form>

                            <div id="alert-container">
                                @if(session('error'))
                                    <div class="alert alert-danger mt-3 alert-custom">
                                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                                    </div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success mt-3 alert-custom">
                                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-custom">
        <div class="container">
            <p class="mb-0">&copy; 2025 Dinas Komunikasi dan Informatika Kabupaten Gresik. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- LOGIKA TRACKING TIKET (AJAX) ---
        const trackingForm = document.getElementById('tracking-form');
        const alertContainer = document.getElementById('alert-container');
        const trackButton = document.getElementById('track-button');

        trackingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const ticketNumber = document.getElementById('ticketNumber').value.trim();

            // 1. Validasi Input Sederhana
            if (!ticketNumber) {
                showAlert('Harap masukkan nomor tiket', 'warning');
                return;
            }

            // 2. Tampilkan Loading State
            trackButton.innerHTML = '<span class="loading me-2"></span> Mencari tiket...';
            trackButton.disabled = true;

            // 3. AJAX call untuk tracking tiket
            fetch('{{ route("track.ticket.public") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    ticketNumber: ticketNumber
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                // Handle non-JSON responses
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    // Jika bukan JSON, redirect biasa
                    window.location.href = '{{ route("track.ticket.public") }}';
                    return;
                }
                
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);

                // 4. Reset Button
                trackButton.innerHTML = '<i class="fas fa-search me-2"></i> Lacak Tiket Anda';
                trackButton.disabled = false;

                // 5. Tampilkan Hasil
                if (data.success) {
                    showAlert(`Tiket <strong>${data.data.kode_tiket}</strong> ditemukan! Status: <strong>${getStatusText(data.data.status)}</strong>. Mengarahkan ke halaman detail...`, 'success');

                    setTimeout(() => {
                        window.location.href = data.data.redirect_url;
                    }, 2000);
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error details:', error);

                // 4. Reset Button
                trackButton.innerHTML = '<i class="fas fa-search me-2"></i> Lacak Tiket Anda';
                trackButton.disabled = false;

                // 5. Tampilkan Error
                showAlert('Terjadi kesalahan saat mencari tiket. Silakan coba lagi.', 'error');
            });
        });

        // Fungsi Helper
        function getStatusText(status) {
            const statusMap = {
                'draft': 'Draft',
                'proses': 'Dalam Proses',
                'selesai': 'Selesai',
                'pending': 'Menunggu'
            };
            return statusMap[status] || status;
        }

        function showAlert(message, type) {
            // Hapus alert yang sudah ada
            const existingAlerts = alertContainer.querySelectorAll('.alert-custom');
            existingAlerts.forEach(alert => {
                alert.remove();
            });

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert-custom animate-fade-in`;

            let icon = 'info-circle';
            let iconColor = 'primary';

            if (type === 'success') { 
                alertDiv.classList.add('alert-success');
                icon = 'check-circle';
                iconColor = 'success';
            } else if (type === 'error') {
                alertDiv.classList.add('alert-danger');
                icon = 'exclamation-triangle';
                iconColor = 'danger';
            } else if (type === 'warning') {
                alertDiv.classList.add('alert-warning');
                icon = 'exclamation-circle';
                iconColor = 'warning';
            }

            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${icon} me-2 text-${iconColor}"></i>
                    <div>${message}</div>
                </div>
            `;

            alertContainer.appendChild(alertDiv);

            // Auto remove setelah 5 detik
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.style.opacity = '0';
                    alertDiv.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        if (alertDiv.parentNode) {
                            alertDiv.parentNode.removeChild(alertDiv);
                        }
                    }, 500);
                }
            }, 5000);
        }
    });
    </script>
</body>
</html>
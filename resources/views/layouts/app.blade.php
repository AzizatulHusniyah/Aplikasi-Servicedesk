<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global & Structural Resets */
        * {
            box-sizing: border-box;
        }
        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Arial', sans-serif; 
            overflow-x: hidden;
        }
        .container-fluid { 
            padding: 0; 
            margin: 0;
        }
        .row { 
            margin: 0; 
        }
        .col-md-3, .col-lg-2, .col-md-9, .col-lg-10 { 
            padding: 0; 
        }

        /* Layout utama */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar: Transition and Collapse Logic (MUST remain) */
        .sidebar { 
            transition: all 0.3s ease; 
            background-color: #1E3C72;
            width: 280px;
            flex-shrink: 0;
            overflow-y: auto;
            position: relative;
            z-index: 1001;
        }
        .sidebar.collapsed { 
            width: 70px !important; 
        }

        /* Sidebar Links & Headings */
        .sidebar .nav-link {
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.125rem 0.5rem;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover { 
            background-color: #3B62A4; 
            transform: translateX(5px);
        }
        .sidebar .nav-link.active { 
            background-color: #3B62A4; 
            font-weight: 600;
        }
        .sidebar-heading {
            color: #adb5bd;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }
        /* Collapse styles for inner elements (MUST remain) */
        .sidebar.collapsed .sidebar-heading,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-brand .brand-text {
            opacity: 0;
            height: 0;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: none;
        }
        .sidebar-brand {
            transition: all 0.3s ease;
            text-align: center;
            padding: 1.5rem 0.5rem;
            border-bottom: 1px solid #3B62A4;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
            transition: margin-right 0.3s ease;
            flex-shrink: 0;
        }
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        /* Main content area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0; /* Penting untuk mencegah overflow */
        }
        
        /* Header Content Flexbox & Toggle Button Interactivity (MUST remain) */
        .main-header {
            background: #ffffff; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); 
            border-bottom: 1px solid #e9ecef; 
            padding: 1rem 0; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
            flex-shrink: 0;
        }
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            margin: 0;
        }
        .header-left, .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .header-toggle-btn {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .header-toggle-btn:hover {
            background-color: #f8f9fa;
            color: #1E3C72;
        }
        
        /* Content wrapper */
        .content-wrapper {
            padding: 2rem; 
            background-color: #f8f9fa; 
            flex: 1;
            overflow-y: auto;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100vh;
                transform: translateX(-100%);
                z-index: 1050;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar.collapsed {
                transform: translateX(-100%);
            }
            .content-wrapper {
                padding: 1rem;
            }
            .header-content {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        @auth
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="position-sticky pt-0">
                <!-- Sidebar Brand -->
                <div class="sidebar-brand">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="max-height: 50px; margin-bottom: 1rem;">
                    <div class="brand-text">
                        <h6 class="text-white mb-1" style="font-weight: 700; font-size: 1.1rem;">Servicedesk</h6>
                        <small class="text-white-50" style="font-size: 0.85rem;">Kabupaten Gresik</small>
                    </div>
                </div>

                <div class="sidebar-content">
                    <h6 class="sidebar-heading px-3 mt-4 mb-2">
                        <span>Dashboard</span>
                    </h6>
                    <ul class="nav flex-column mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user"></i> <span>Profile</span>
                            </a>
                        </li>
                    </ul>

                    @canany(['view hak-akses', 'view pengguna', 'view roles-permission', 'view perangkat-daerah'])
                    <h6 class="sidebar-heading px-3 mt-4 mb-2">
                        <span>Master Data</span>
                    </h6>
                    <ul class="nav flex-column mb-3">
                        @can('view hak-akses')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('hak-akses.*') ? 'active' : '' }}" href="{{ route('hak-akses.index') }}">
                                <i class="fas fa-key"></i> <span>Hak Akses</span>
                            </a>
                        </li>
                        @endcan
                        @can('view pengguna')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}" href="{{ route('pengguna.index') }}">
                                <i class="fas fa-users"></i> <span>Pengguna</span>
                            </a>
                        </li>
                        @endcan
                        @can('view perangkat-daerah')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('perangkat-daerah.*') ? 'active' : '' }}" href="{{ route('perangkat-daerah.index') }}">
                                <i class="fas fa-building"></i> <span>Perangkat Daerah</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany

                    @canany(['view laporan', 'balas laporan'])
                    <h6 class="sidebar-heading px-3 mt-4 mb-2">
                        <span>Laporan</span>
                    </h6>
                    <ul class="nav flex-column mb-3">
                        @can('view laporan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                                <i class="fas fa-file-alt"></i> <span>Laporan</span>
                            </a>
                        </li>
                        @endcan
                        @can('balas laporan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('balasan-laporan.*') ? 'active' : '' }}" href="{{ route('balasan-laporan.index') }}">
                                <i class="fas fa-reply"></i> <span>Balasan Laporan</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany

                    @canany(['view tipe-layanan', 'view kategori-layanan', 'view layanan'])
                    <h6 class="sidebar-heading px-3 mt-4 mb-2">
                        <span>Konfigurasi Layanan</span>
                    </h6>
                    <ul class="nav flex-column mb-3">
                        @can('view tipe-layanan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tipe-layanan.*') ? 'active' : '' }}" href="{{ route('tipe-layanan.index') }}">
                                <i class="fas fa-layer-group"></i> <span>Tipe Layanan</span>
                            </a>
                        </li>
                        @endcan
                        @can('view kategori-layanan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategori-layanan.*') ? 'active' : '' }}" href="{{ route('kategori-layanan.index') }}">
                                <i class="fas fa-tags"></i> <span>Kategori Layanan</span>
                            </a>
                        </li>
                        @endcan
                        @can('view layanan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">
                                <i class="fas fa-cogs"></i> <span>Layanan</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany
                </div>
            </div>
        </nav>
        @endauth

        <div class="main-content">
            @auth
            <!-- Main Header -->
            <div class="main-header">
                <div class="header-content">
                    <div class="header-left">
                        <button class="header-toggle-btn" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 style="color: #1E3C72; font-weight: 700; font-size: 1.5rem; margin: 0;">@yield('title')</h1>
                    </div>
                    <div class="header-right">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" style="
                                background-color: #f8f9fa; 
                                border: 1px solid #e9ecef;
                                color: #495057;
                                border-radius: 8px;
                                font-weight: 500;
                                padding: 0.5rem 1rem;
                                transition: all 0.3s ease;
                            "
                            onmouseover="this.style.backgroundColor='#e9ecef'; this.style.borderColor='#dee2e6'"
                            onmouseout="this.style.backgroundColor='#f8f9fa'; this.style.borderColor='#e9ecef'">
                                <i class="fas fa-user-circle me-2" style="color: #3B62A4;"></i>
                                {{ Auth::user()->name }} ({{ Auth::user()->getRoleNames()->first() }})
                            </button>
                            <ul class="dropdown-menu" style="
                                border: none;
                                border-radius: 8px;
                                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                                padding: 0.5rem;
                            ">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}" style="
                                        border-radius: 6px;
                                        padding: 0.5rem 1rem;
                                        font-weight: 500;
                                        transition: all 0.2s ease;
                                    "
                                    onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.color='#1E3C72'"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='inherit'">
                                        <i class="fas fa-user me-2"></i>Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="margin: 0.25rem 0;"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="
                                            border-radius: 6px;
                                            padding: 0.5rem 1rem;
                                            font-weight: 500;
                                            transition: all 0.2s ease;
                                            width: 100%;
                                            text-align: left;
                                            border: none;
                                            background: none;
                                        "
                                        onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.color='#dc3545'"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='inherit'">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="
                        border: none;
                        border-radius: 8px;
                        padding: 1rem 1.5rem;
                        background-color: #d4edda;
                        color: #155724;
                        border-left: 4px solid #28a745;
                        font-weight: 500;
                        margin-bottom: 1.5rem;
                    ">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.75rem;"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="
                        border: none;
                        border-radius: 8px;
                        padding: 1rem 1.5rem;
                        background-color: #f8d7da;
                        color: #721c24;
                        border-left: 4px solid #dc3545;
                        font-weight: 500;
                        margin-bottom: 1.5rem;
                    ">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0" style="padding-left: 1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.75rem;"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            // Check if sidebar state is stored in localStorage
            const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            // Apply initial state
            if (isSidebarCollapsed) {
                sidebar.classList.add('collapsed');
            }

            // Toggle sidebar function
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }

            // Event listener for toggle button
            sidebarToggle.addEventListener('click', toggleSidebar);

            // Auto close alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            
            // Handle responsive behavior
            function handleResize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.add('show');
                } else {
                    sidebar.classList.remove('show');
                }
            }
            
            // Initial check
            handleResize();
            
            // Listen for resize events
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>
</html>
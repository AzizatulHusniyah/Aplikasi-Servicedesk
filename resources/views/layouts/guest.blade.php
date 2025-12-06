<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Login</title>

    <!-- Bootstrap CSS CDN (Pastikan versi sesuai dengan yang Anda gunakan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Styles yang di-push dari view (yaitu CSS kustom dari login.blade.php) -->
    @stack('styles')
</head>
<body class="antialiased">
    <div id="app" class="min-vh-100 d-flex flex-column">
        
        {{-- Konten Utama Login Card akan dimasukkan di sini --}}
        <main class="flex-grow-1">
            @yield('content')
        </main>
        
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Scripts yang di-push dari view (yaitu JS kustom dari login.blade.php) -->
    @stack('scripts')
</body>
</html>
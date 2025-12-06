@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-md-8">
        <div class="card" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        ">
            <div class="card-header" style="
                background-color: #fff;
                border-bottom: 2px solid #1E3C72;
                padding: 1.5rem 2rem;
            ">
                <h5 class="card-title" style="
                    color: #1E3C72;
                    font-weight: 700;
                    margin: 0;
                    font-size: 1.5rem;
                ">
                    <i class="fas fa-tachometer-alt me-2" style="color: #3B62A4;"></i>{{ __('Dashboard') }}
                </h5>
            </div>

            <div class="card-body" style="padding: 3rem 2rem;">
                @if (session('status'))
                    <div class="alert alert-success" role="alert" style="
                        border: none;
                        border-radius: 8px;
                        padding: 1rem 1.5rem;
                        background-color: #d4edda;
                        color: #155724;
                        border-left: 4px solid #28a745;
                        font-weight: 500;
                        margin-bottom: 2rem;
                    ">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <div class="text-center py-3">
                    <div style="
                        font-size: 5rem; 
                        color: #1E3C72; 
                        margin-bottom: 1.5rem;
                        opacity: 0.9;
                    ">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 style="
                        color: #1E3C72; 
                        font-weight: 700; 
                        margin-bottom: 1rem;
                        font-size: 1.75rem;
                    ">
                        {{ __('You are logged in!') }}
                    </h3>
                    <p style="
                        color: #495057; 
                        font-size: 1.1rem; 
                        line-height: 1.6;
                        max-width: 400px;
                        margin: 0 auto;
                    ">
                        Selamat datang di Sistem Servicedesk<br>Kabupaten Gresik
                    </p>
                    
                    <div style="
                        margin-top: 2.5rem;
                        padding: 1.5rem;
                        background-color: #f8f9fa;
                        border-radius: 10px;
                        border-left: 4px solid #3B62A4;
                    ">
                        <p style="
                            color: #495057; 
                            font-weight: 500; 
                            margin-bottom: 0.5rem;
                            font-size: 1rem;
                        ">
                            <i class="fas fa-info-circle me-2" style="color: #3B62A4;"></i>
                            Anda berhasil masuk ke sistem
                        </p>
                        <p style="
                            color: #6c757d; 
                            font-size: 0.95rem; 
                            margin-bottom: 0;
                        ">
                            Gunakan menu navigasi untuk mengakses fitur yang tersedia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
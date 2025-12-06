@extends('layouts.app')

@section('title', 'Tambah Hak Akses')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    {{-- Menggunakan col-md-8 untuk tampilan yang lebih terpusat dan elegan --}}
    <div class="col-md-8">
        {{-- Card Utama --}}
        <div class="card" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        ">
            {{-- Card Header --}}
            <div class="card-header" style="
                background-color: #fff;
                border-bottom: 2px solid #1E3C72; /* Garis bawah tebal warna brand */
                padding: 1.5rem 2rem;
            ">
                <h5 class="card-title" style="
                    color: #1E3C72; /* Warna judul sesuai brand */
                    font-weight: 700;
                    margin: 0;
                    font-size: 1.5rem;
                ">
                    <i class="fas fa-user-plus me-2" style="color: #3B62A4;"></i> Tambah Hak Akses Baru
                </h5>
            </div>

            {{-- Card Body (Formulir) --}}
            <div class="card-body" style="padding: 2rem;">
                <form method="POST" action="{{ route('hak-akses.store') }}">
                    @csrf

                    {{-- Input Nama Role --}}
                    <div class="mb-4">
                        <label for="name" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Nama Role
                        </label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name') }}" required 
                               placeholder="Contoh: Admin, Operator, User"
                               style="
                                   border-radius: 8px;
                                   padding: 0.75rem 1rem;
                                   border: 1px solid #ced4da;
                                   transition: border-color 0.3s ease, box-shadow 0.3s ease;
                               ">
                        {{-- Handling Error (opsional) --}}
                        @error('name')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Bagian untuk Permissions (Placeholder untuk keindahan) --}}
                    <div class="mb-5">
                        <h6 style="font-weight: 600; color: #1E3C72;">Alokasi Permissions</h6>
                        <div style="
                            padding: 1.5rem;
                            background-color: #f5f7fa;
                            border: 1px dashed #d0d5dc;
                            border-radius: 10px;
                        ">
                            <p class="text-muted m-0" style="font-style: italic;">
                                <i class="fas fa-lock me-1" style="color: #3B62A4;"></i> Area ini akan digunakan untuk memilih daftar *permissions* yang akan diberikan kepada role baru ini.
                            </p>
                            <p class="text-muted m-0 mt-1" style="font-size: 0.85rem;">
                                Setelah role tersimpan, Anda dapat mengeditnya untuk menetapkan permissions.
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-start gap-3 mt-4">
                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn btn-primary" style="
                            background-color: #1E3C72;
                            border-color: #1E3C72;
                            border-radius: 8px;
                            font-weight: 600;
                            padding: 0.75rem 1.75rem;
                            transition: all 0.3s ease;
                        "
                        onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'; this.style.boxShadow='0 4px 10px rgba(30, 60, 114, 0.4)'"
                        onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'; this.style.boxShadow='none'">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('hak-akses.index') }}" class="btn btn-secondary" style="
                            background-color: #6c757d;
                            border-color: #6c757d;
                            border-radius: 8px;
                            font-weight: 500;
                            padding: 0.75rem 1.75rem;
                            transition: all 0.3s ease;
                        "
                        onmouseover="this.style.backgroundColor='#5a6268'; this.style.borderColor='#5a6268'"
                        onmouseout="this.style.backgroundColor='#6c757d'; this.style.borderColor='#6c757d'">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
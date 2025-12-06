@extends('layouts.app')

@section('title', 'Tambah Kategori Layanan')

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
                    <i class="fas fa-plus-circle me-2" style="color: #3B62A4;"></i> Tambah Kategori Layanan
                </h5>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <form method="POST" action="{{ route('kategori-layanan.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nama" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Nama Kategori Layanan <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="{{ old('nama') }}" required 
                               style="
                                   border-radius: 8px;
                                   padding: 0.75rem 1rem;
                                   border: 1px solid #ced4da;
                                   transition: border-color 0.3s ease, box-shadow 0.3s ease;
                               "
                               onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                               onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'"
                               placeholder="Masukkan nama kategori layanan">
                        @error('nama')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Keterangan
                        </label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                                  style="
                                      border-radius: 8px;
                                      padding: 0.75rem 1rem;
                                      border: 1px solid #ced4da;
                                      transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                      resize: vertical;
                                  "
                                  onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                  onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'"
                                  placeholder="Masukkan keterangan kategori layanan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size: 0.875rem; color: #6c757d;">
                            Keterangan tambahan tentang kategori layanan ini.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="status_aktivasi" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Status Aktivasi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="status_aktivasi" name="status_aktivasi" required
                                style="
                                    border-radius: 8px;
                                    padding: 0.75rem 1rem;
                                    border: 1px solid #ced4da;
                                    transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                "
                                onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                            <option value="1" {{ old('status_aktivasi', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status_aktivasi') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status_aktivasi')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start gap-3 mt-5">
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
                            <i class="fas fa-save me-2"></i> Simpan Kategori Layanan
                        </button>

                        <a href="{{ route('kategori-layanan.index') }}" class="btn btn-secondary" style="
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
@extends('layouts.app')

@section('title', 'Edit Perangkat Daerah')

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
                    <i class="fas fa-edit me-2" style="color: #3B62A4;"></i> Edit Perangkat Daerah
                </h5>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <form method="POST" action="{{ route('perangkat-daerah.update', $perangkatDaerah->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="nama" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Nama Perangkat Daerah
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="{{ old('nama', $perangkatDaerah->nama) }}" required 
                                       style="
                                           border-radius: 8px;
                                           padding: 0.75rem 1rem;
                                           border: 1px solid #ced4da;
                                           transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                       "
                                       onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                       onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                @error('nama')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="email" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $perangkatDaerah->email) }}" required 
                                       style="
                                           border-radius: 8px;
                                           padding: 0.75rem 1rem;
                                           border: 1px solid #ced4da;
                                           transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                       "
                                       onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                       onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                @error('email')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="kode" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Kode
                                </label>
                                <input type="text" class="form-control" id="kode" name="kode" 
                                       value="{{ old('kode', $perangkatDaerah->kode) }}" required maxlength="10"
                                       style="
                                           border-radius: 8px;
                                           padding: 0.75rem 1rem;
                                           border: 1px solid #ced4da;
                                           transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                       "
                                       onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                       onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                @error('kode')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="link_esukma" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Link e-Sukma
                                </label>
                                <input type="url" class="form-control" id="link_esukma" name="link_esukma" 
                                       value="{{ old('link_esukma', $perangkatDaerah->link_esukma) }}" required
                                       style="
                                           border-radius: 8px;
                                           padding: 0.75rem 1rem;
                                           border: 1px solid #ced4da;
                                           transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                       "
                                       onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                       onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                @error('link_esukma')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TAMBAH: Field Jenis Layanan --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                    display: block;
                                ">
                                    Jenis Layanan <span class="text-muted" style="font-size: 0.875rem;">(Dapat memilih keduanya)</span>
                                </label>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="administrasi_pemerintahan" name="administrasi_pemerintahan" value="1"
                                        {{ old('administrasi_pemerintahan', $perangkatDaerah->administrasi_pemerintahan) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="administrasi_pemerintahan" style="color: #495057; font-weight: 500;">
                                        <i class="fas fa-building me-1" style="color: #007bff;"></i> Administrasi Pemerintahan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="publik" name="publik" value="1"
                                        {{ old('publik', $perangkatDaerah->publik) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publik" style="color: #495057; font-weight: 500;">
                                        <i class="fas fa-users me-1" style="color: #28a745;"></i> Publik
                                    </label>
                                </div>

                                @error('administrasi_pemerintahan')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                                @error('publik')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="status_aktivasi" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Status Aktivasi
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
                            <option value="1" {{ $perangkatDaerah->status_aktivasi ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$perangkatDaerah->status_aktivasi ? 'selected' : '' }}>Non-Aktif</option>
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
                            <i class="fas fa-check-circle me-2"></i> Update Perangkat Daerah
                        </button>

                        <a href="{{ route('perangkat-daerah.index') }}" class="btn btn-secondary" style="
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
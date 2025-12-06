@extends('layouts.app')

@section('title', 'Edit Layanan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-md-12">
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
                    <i class="fas fa-edit me-2" style="color: #3B62A4;"></i> Edit Layanan
                </h5>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <form method="POST" action="{{ route('layanan.update', $layanan->id) }}">
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
                                    Nama Layanan
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="{{ old('nama', $layanan->nama) }}" required 
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
                                <label for="kategori_layanan_id" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Kategori Layanan
                                </label>
                                <select class="form-select" id="kategori_layanan_id" name="kategori_layanan_id" required
                                        style="
                                            border-radius: 8px;
                                            padding: 0.75rem 1rem;
                                            border: 1px solid #ced4da;
                                            transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                        "
                                        onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                        onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                    <option value="">Pilih Kategori Layanan</option>
                                    @foreach($kategoriLayanan as $kl)
                                        <option value="{{ $kl->id }}" {{ old('kategori_layanan_id', $layanan->kategori_layanan_id) == $kl->id ? 'selected' : '' }}>
                                            {{ $kl->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_layanan_id')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tipe_layanan_id" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Tipe Layanan
                                </label>
                                <select class="form-select" id="tipe_layanan_id" name="tipe_layanan_id" required
                                        style="
                                            border-radius: 8px;
                                            padding: 0.75rem 1rem;
                                            border: 1px solid #ced4da;
                                            transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                        "
                                        onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                        onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                    <option value="">Pilih Tipe Layanan</option>
                                    @foreach($tipeLayanan as $tl)
                                        <option value="{{ $tl->id }}" {{ old('tipe_layanan_id', $layanan->tipe_layanan_id) == $tl->id ? 'selected' : '' }}>
                                            {{ $tl->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipe_layanan_id')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="perangkat_daerah_id" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Perangkat Daerah
                                </label>
                                <select class="form-select" id="perangkat_daerah_id" name="perangkat_daerah_id" required
                                        style="
                                            border-radius: 8px;
                                            padding: 0.75rem 1rem;
                                            border: 1px solid #ced4da;
                                            transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                        "
                                        onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                        onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                    <option value="">Pilih Perangkat Daerah</option>
                                    @foreach($perangkatDaerah as $pd)
                                        <option value="{{ $pd->id }}" {{ old('perangkat_daerah_id', $layanan->perangkat_daerah_id) == $pd->id ? 'selected' : '' }}>
                                            {{ $pd->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('perangkat_daerah_id')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="teknisi_id" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Teknisi
                                </label>
                                <select class="form-select" id="teknisi_id" name="teknisi_id" required
                                        style="
                                            border-radius: 8px;
                                            padding: 0.75rem 1rem;
                                            border: 1px solid #ced4da;
                                            transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                        "
                                        onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                        onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                    <option value="">Pilih Teknisi</option>
                                    @foreach($teknisiList as $teknisi)
                                        <option value="{{ $teknisi->id }}" {{ old('teknisi_id', $layanan->teknisi_id) == $teknisi->id ? 'selected' : '' }}>
                                            {{ $teknisi->name }} ({{ $teknisi->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @if($teknisiList->isEmpty())
                                    <div class="text-warning mt-1" style="font-size: 0.875rem;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Tidak ada teknisi yang tersedia. Silakan tambah pengguna dengan role teknisi terlebih dahulu.
                                    </div>
                                @endif
                                @error('teknisi_id')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="eselon" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    Eselon
                                </label>
                                <input type="text" class="form-control" id="eselon" name="eselon" 
                                       value="{{ old('eselon', $layanan->eselon) }}" required 
                                       style="
                                           border-radius: 8px;
                                           padding: 0.75rem 1rem;
                                           border: 1px solid #ced4da;
                                           transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                       "
                                       onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                       onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                @error('eselon')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="sla_hari" class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                ">
                                    SLA (Hari)
                                </label>
                                <input type="number" class="form-control" id="sla_hari" name="sla_hari" 
                                    value="{{ old('sla_hari', $layanan->sla_hari) }}" min="1" required 
                                    style="
                                        border-radius: 8px;
                                        padding: 0.75rem 1rem;
                                        border: 1px solid #ced4da;
                                        transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                    "
                                    onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                    onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                @error('sla_hari')
                                    <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label" style="
                                    font-weight: 600;
                                    color: #495057;
                                    margin-bottom: 0.5rem;
                                    display: block;
                                ">
                                    Jenis Layanan <span class="text-muted" style="font-size: 0.875rem;">(Pilih salah satu)</span>
                                </label>
                                
                                {{-- PERBAIKAN: Gunakan input checkbox langsung --}}
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="administrasi_pemerintahan" name="administrasi_pemerintahan" value="1"
                                        {{ old('administrasi_pemerintahan', $layanan->administrasi_pemerintahan ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="administrasi_pemerintahan" style="color: #495057; font-weight: 500;">
                                        <i class="fas fa-building me-1" style="color: #007bff;"></i> Administrasi Pemerintahan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="publik" name="publik" value="1"
                                        {{ old('publik', $layanan->publik ?? false) ? 'checked' : '' }}>
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
                            <option value="1" {{ $layanan->status_aktivasi ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$layanan->status_aktivasi ? 'selected' : '' }}>Non-Aktif</option>
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
                            <i class="fas fa-check-circle me-2"></i> Update Layanan
                        </button>

                        <a href="{{ route('layanan.index') }}" class="btn btn-secondary" style="
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
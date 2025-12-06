@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-11">
        <div class="row">
            {{-- Main Content Card (Update Profile) --}}
            <div class="col-md-8">
                <div class="card" style="
                    border: none;
                    border-radius: 12px;
                    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                    font-family: 'Arial', sans-serif;
                    margin-bottom: 1.5rem;
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
                            <i class="fas fa-user-edit me-2" style="color: #3B62A4;"></i> Edit Profile
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        
                        {{-- TAMBAH: Password Warning Alert --}}
                        @if($passwordWarning)
                            <div class="alert alert-{{ $passwordWarning['type'] }} alert-dismissible fade show" role="alert" style="
                                border-radius: 8px;
                                border-left: 4px solid {{ $passwordWarning['type'] == 'danger' ? '#dc3545' : '#ffc107' }};
                                margin-bottom: 2rem;
                            ">
                                <div class="d-flex align-items-center">
                                    <i class="fas {{ $passwordWarning['type'] == 'danger' ? 'fa-exclamation-triangle' : 'fa-exclamation-circle' }} me-2" style="font-size: 1.2rem;"></i>
                                    <strong class="me-2">{{ $passwordWarning['type'] == 'danger' ? 'Peringatan!' : 'Perhatian!' }}</strong>
                                    {{ $passwordWarning['message'] }}
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <h6 style="
                                color: #1E3C72;
                                font-weight: 600;
                                margin-bottom: 1.5rem;
                                padding-bottom: 0.5rem;
                                border-bottom: 1px solid #e9ecef;
                                font-size: 1.1rem;
                            ">
                                <i class="fas fa-user-circle me-2"></i> Informasi Pribadi
                            </h6>

                            {{-- Section 1: Nama & Email --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="name" class="form-label" style="
                                            font-weight: 600;
                                            color: #495057;
                                            margin-bottom: 0.5rem;
                                        ">
                                            Nama Lengkap
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{{ old('name', $user->name) }}" required 
                                               style="
                                                   border-radius: 8px;
                                                   padding: 0.75rem 1rem;
                                                   border: 1px solid #ced4da;
                                                   transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                               "
                                               onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                               onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                        @error('name')
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
                                            Alamat Email
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{ old('email', $user->email) }}" required 
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

                            {{-- Section 2: NIK & NIP/THL --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="nik" class="form-label" style="
                                            font-weight: 600;
                                            color: #495057;
                                            margin-bottom: 0.5rem;
                                        ">
                                            NIK
                                        </label>
                                        <input type="text" class="form-control" id="nik" name="nik"
                                               value="{{ old('nik', $user->nik) }}"
                                               style="
                                                   border-radius: 8px;
                                                   padding: 0.75rem 1rem;
                                                   border: 1px solid #ced4da;
                                                   transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                               "
                                               onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                               onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                        @error('nik')
                                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="nip_no_thl" class="form-label" style="
                                            font-weight: 600;
                                            color: #495057;
                                            margin-bottom: 0.5rem;
                                        ">
                                            NIP / No THL
                                        </label>
                                        <input type="text" class="form-control" id="nip_no_thl" name="nip_no_thl"
                                               value="{{ old('nip_no_thl', $user->nip_no_thl) }}"
                                               style="
                                                   border-radius: 8px;
                                                   padding: 0.75rem 1rem;
                                                   border: 1px solid #ced4da;
                                                   transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                               "
                                               onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                               onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                        @error('nip_no_thl')
                                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="no_whatsapp" class="form-label" style="
                                            font-weight: 600;
                                            color: #495057;
                                            margin-bottom: 0.5rem;
                                        ">
                                            No WhatsApp
                                        </label>
                                        <input type="text" class="form-control" id="no_whatsapp" name="no_whatsapp"
                                            value="{{ old('no_whatsapp', $user->no_whatsapp) }}"
                                            style="
                                                border-radius: 8px;
                                                padding: 0.75rem 1rem;
                                                border: 1px solid #ced4da;
                                                transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                            "
                                            onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                            onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                        @error('no_whatsapp')
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
                                            @if(!$user->canEditPerangkatDaerah())
                                                <span class="badge bg-warning ms-2" style="font-size: 0.7rem;">Terkunci</span>
                                            @endif
                                        </label>
                                        
                                        @if($user->canEditPerangkatDaerah())
                                            {{-- User bisa mengedit (belum ada perangkat daerah atau administrator) --}}
                                            <select class="form-select" id="perangkat_daerah_id" name="perangkat_daerah_id"
                                                    style="
                                                        border-radius: 8px;
                                                        padding: 0.75rem 1rem;
                                                        border: 1px solid #ced4da;
                                                        transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                                    "
                                                    onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                                    onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                                <option value="">Pilih Perangkat Daerah</option>
                                                @foreach($perangkatDaerahs as $pd)
                                                    <option value="{{ $pd->id }}"
                                                        {{ old('perangkat_daerah_id', $user->perangkat_daerah_id) == $pd->id ? 'selected' : '' }}>
                                                        {{ $pd->nama }} ({{ $pd->kode }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted" style="
                                                font-size: 0.8rem;
                                                color: #6c757d;
                                                margin-top: 0.5rem;
                                                display: block;
                                            ">
                                                <i class="fas fa-info-circle me-1"></i> 
                                                @if($user->hasRole('administrator'))
                                                    Administrator dapat mengubah perangkat daerah kapan saja.
                                                @else
                                                    Pilihan ini hanya dapat diisi sekali. Pastikan memilih dengan benar.
                                                @endif
                                            </small>
                                        @else
                                            {{-- User tidak bisa mengedit (sudah ada perangkat daerah dan bukan administrator) --}}
                                            <div class="form-control" style="
                                                border-radius: 8px;
                                                padding: 0.75rem 1rem;
                                                border: 1px solid #ced4da;
                                                background-color: #f8f9fa;
                                                color: #6c757d;
                                            ">
                                                @if($user->perangkatDaerah)
                                                    {{ $user->perangkatDaerah->nama }} ({{ $user->perangkatDaerah->kode }})
                                                @else
                                                    Belum dipilih
                                                @endif
                                            </div>
                                            <input type="hidden" name="perangkat_daerah_id" value="{{ $user->perangkat_daerah_id }}">
                                            <small class="form-text text-muted" style="
                                                font-size: 0.8rem;
                                                color: #6c757d;
                                                margin-top: 0.5rem;
                                                display: block;
                                            ">
                                                <i class="fas fa-lock me-1"></i> Perangkat daerah sudah terkunci. Hubungi administrator untuk perubahan.
                                            </small>
                                        @endif
                                        
                                        @error('perangkat_daerah_id')
                                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password Change Section -->
                            <div style="
                                margin: 2.5rem 0;
                                border-top: 1px solid #e9ecef;
                                padding-top: 1.5rem;
                            ">
                                <h6 style="
                                    color: #1E3C72;
                                    font-weight: 600;
                                    margin-bottom: 1.5rem;
                                    font-size: 1.1rem;
                                ">
                                    <i class="fas fa-key me-2"></i> Ubah Password
                                </h6>
                                
                                {{-- TAMBAH: Password Policy Info --}}
                                @if($user->hasAnyRole(['administrator', 'teknisi', 'eselon']))
                                    <div class="alert alert-info" style="
                                        border-radius: 8px;
                                        border-left: 4px solid #17a2b8;
                                        margin-bottom: 1.5rem;
                                        font-size: 0.9rem;
                                    ">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>Kebijakan Password:</strong> Untuk keamanan sistem, password harus diganti setiap 3 bulan.
                                                @if($passwordWarning)
                                                    <br><small class="text-{{ $passwordWarning['type'] }}">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Status: {{ $passwordWarning['type'] == 'danger' ? 'Telah Kadaluarsa' : 'Akan Kadaluarsa' }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <small class="form-text text-muted" style="
                                    font-size: 0.8rem;
                                    color: #6c757d;
                                    margin-bottom: 1rem;
                                    display: block;
                                ">
                                    <i class="fas fa-info-circle me-1"></i> Kosongkan jika tidak ingin mengubah password
                                </small>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="current_password" class="form-label" style="
                                                font-weight: 600;
                                                color: #495057;
                                                margin-bottom: 0.5rem;
                                            ">
                                                Password Saat Ini
                                            </label>
                                            <input type="password" class="form-control" id="current_password" name="current_password"
                                                   style="
                                                       border-radius: 8px;
                                                       padding: 0.75rem 1rem;
                                                       border: 1px solid #ced4da;
                                                       transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                                   "
                                                   onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                                   onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                            @error('current_password')
                                                <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="new_password" class="form-label" style="
                                                font-weight: 600;
                                                color: #495057;
                                                margin-bottom: 0.5rem;
                                            ">
                                                Password Baru
                                            </label>
                                            <input type="password" class="form-control" id="new_password" name="new_password"
                                                   style="
                                                       border-radius: 8px;
                                                       padding: 0.75rem 1rem;
                                                       border: 1px solid #ced4da;
                                                       transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                                   "
                                                   onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                                   onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                            @error('new_password')
                                                <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="new_password_confirmation" class="form-label" style="
                                                font-weight: 600;
                                                color: #495057;
                                                margin-bottom: 0.5rem;
                                            ">
                                                Konfirmasi Password Baru
                                            </label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation"
                                                   style="
                                                       border-radius: 8px;
                                                       padding: 0.75rem 1rem;
                                                       border: 1px solid #ced4da;
                                                       transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                                   "
                                                   onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                                   onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start gap-3 mt-4">
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
                                    <i class="fas fa-check-circle me-2"></i> Update Profile
                                </button>

                                <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="
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

            {{-- Sidebar Card (Account Info) --}}
            <div class="col-md-4">
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
                        padding: 1.5rem;
                    ">
                        <h5 class="card-title" style="
                            color: #1E3C72;
                            font-weight: 700;
                            margin: 0;
                            font-size: 1.25rem;
                        ">
                            <i class="fas fa-info-circle me-2" style="color: #3B62A4;"></i> Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="mb-3">
                            <p class="mb-1" style="font-weight: 600; color: #495057;">Role</p>
                            <p class="mb-0" style="color: #1E3C72; font-weight: 500;">
                                {{ $user->getRoleNames()->isNotEmpty() ? $user->getRoleNames()->implode(', ') : 'Tidak ada role' }}
                            </p>
                        </div>
                        <hr style="margin: 1rem 0; color: #e9ecef;">
                        <div class="mb-3">
                            <p class="mb-1" style="font-weight: 600; color: #495057;">Status Email</p>
                            <p class="mb-0 @if($user->email_verified_at) text-success @else text-warning @endif" style="font-weight: 500;">
                                @if($user->email_verified_at)
                                    <i class="fas fa-check-circle me-1"></i> Verified ({{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y H:i') }})
                                @else
                                    <i class="fas fa-exclamation-triangle me-1"></i> Belum Diverifikasi
                                @endif
                            </p>
                        </div>
                        <hr style="margin: 1rem 0; color: #e9ecef;">
                        <div class="mb-3">
                            <p class="mb-1" style="font-weight: 600; color: #495057;">Bergabung Sejak</p>
                            <p class="mb-0" style="color: #1E3C72; font-weight: 500;">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $user->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        {{-- TAMBAH: Password Expiry Info --}}
                        @if($user->hasAnyRole(['administrator', 'teknisi', 'eselon']))
                            <hr style="margin: 1rem 0; color: #e9ecef;">
                            <div class="mb-3">
                                <p class="mb-1" style="font-weight: 600; color: #495057;">Status Password</p>
                                @if($passwordWarning)
                                    <p class="mb-0 text-{{ $passwordWarning['type'] }}" style="font-weight: 500;">
                                        <i class="fas {{ $passwordWarning['type'] == 'danger' ? 'fa-exclamation-triangle' : 'fa-exclamation-circle' }} me-1"></i>
                                        @if($passwordWarning['type'] == 'danger')
                                            Telah Kadaluarsa
                                        @else
                                            {{ $passwordWarning['days'] }} Hari Lagi
                                        @endif
                                    </p>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        Terakhir diubah: {{ $user->password_changed_at ? $user->password_changed_at->format('d/m/Y') : $user->created_at->format('d/m/Y') }}
                                    </small>
                                @else
                                    <p class="mb-0 text-success" style="font-weight: 500;">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </p>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        Terakhir diubah: {{ $user->password_changed_at ? $user->password_changed_at->format('d/m/Y') : $user->created_at->format('d/m/Y') }}
                                    </small>
                                @endif
                            </div>
                        @endif

                        @if($user->perangkatDaerah)
                            <hr style="margin: 1rem 0; color: #e9ecef;">
                            <div class="mb-0">
                                <p class="mb-1" style="font-weight: 600; color: #495057;">Perangkat Daerah</p>
                                <p class="mb-0" style="color: #1E3C72; font-weight: 500;">
                                    <i class="fas fa-building me-1"></i> {{ $user->perangkatDaerah->nama }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
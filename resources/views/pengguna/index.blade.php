@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="container-fluid" style="
    padding: 20px 30px; 
    font-family: 'Arial', sans-serif; 
    color: #333;
">
    {{-- Header dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4" style="
        border-bottom: 2px solid #f0f0f0; 
        padding-bottom: 15px;
    ">
        <h4 style="
            color: #1E3C72; /* Dark Brand Color */
            font-weight: 700;
            margin: 0;
            font-size: 1.8rem;
        ">
            Data Pengguna
        </h4>
        <a href="{{ route('pengguna.create') }}" class="btn btn-primary" style="
            background-color: #1E3C72; 
            border-color: #1E3C72;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        "
        onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'"
        onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'">
            <i class="fas fa-user-plus me-2"></i> Tambah Pengguna
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert" style="
            background-color: #d4edda; 
            color: #155724; 
            border-color: #c3e6cb; 
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        ">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert" style="
            background-color: #f8d7da; 
            color: #721c24; 
            border-color: #f5c6cb; 
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        ">
            {{ session('error') }}
        </div>
    @endif

    {{-- Card Tabel Data --}}
    <div class="card" style="
        border: none;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    ">
        <div class="card-body" style="padding: 1.5rem;">
            <div class="table-responsive">
                <table class="table table-striped" style="
                    width: 100%; 
                    margin-bottom: 0;
                    border-collapse: separate;
                    border-spacing: 0;
                ">
                    <thead style="background-color: #F8F9FA;">
                        <tr style="color: #1E3C72; font-size: 0.95rem;">
                            <th style="padding: 12px 15px; border-top: none; font-weight: 700;">#</th>
                            <th style="padding: 12px 15px; border-top: none; font-weight: 700;">Nama</th>
                            <th style="padding: 12px 15px; border-top: none; font-weight: 700;">Email</th>
                            <th style="padding: 12px 15px; border-top: none; font-weight: 700;">Roles</th>
                            <th style="padding: 12px 15px; border-top: none; font-weight: 700;">Perangkat Daerah</th>
                            <th style="padding: 12px 15px; border-top: none; font-weight: 700; width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr style="vertical-align: middle; font-size: 0.9rem;">
                            <td style="padding: 12px 15px;">{{ $loop->iteration }}</td>
                            <td style="padding: 12px 15px;">{{ $user->name }}</td>
                            <td style="padding: 12px 15px;">{{ $user->email }}</td>
                            <td style="padding: 12px 15px;">
                                @foreach($user->roles as $role)
                                    <span class="badge" style="
                                        background-color: #3B62A4; 
                                        color: white; 
                                        border-radius: 5px;
                                        padding: 0.4em 0.8em;
                                        font-weight: 500;
                                    ">{{ $role->name }}</span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                    <span class="badge" style="
                                        background-color: #6C757D; 
                                        color: white; 
                                        border-radius: 5px;
                                        padding: 0.4em 0.8em;
                                        font-weight: 500;
                                    ">No Role</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px;">
                                @if($user->perangkatDaerah)
                                    {{ $user->perangkatDaerah->nama }}
                                    @if(!$user->canEditPerangkatDaerah() && !$user->hasRole('administrator'))
                                        <span class="badge bg-success ms-1" style="font-size: 0.7rem;">Terkunci</span>
                                    @endif
                                @else
                                    <span class="text-muted">Belum dipilih</span>
                                    <span class="badge bg-warning ms-1" style="font-size: 0.7rem;">Dapat dipilih</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; vertical-align: middle; white-space: nowrap;">
                                {{-- Tombol Edit Role --}}
                                <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm" style="
                                    background-color: #28a745; 
                                    color: #fff; 
                                    border-radius: 8px; 
                                    font-weight: 500; 
                                    transition: all 0.2s ease;
                                    margin-right: 5px;
                                    padding: 0.5rem 0.8rem;
                                "
                                onmouseover="this.style.backgroundColor='#1e7e34'"
                                onmouseout="this.style.backgroundColor='#28a745'"
                                title="Edit Role">
                                    <i class="fas fa-wrench"></i>
                                </a>

                                {{-- Tombol Edit Profil --}}
                                <a href="{{ route('pengguna.edit-profile', $user->id) }}" class="btn btn-sm" style="
                                    background-color: #3B62A4; 
                                    color: #fff; 
                                    border-radius: 8px; 
                                    font-weight: 500; 
                                    transition: all 0.2s ease;
                                    margin-right: 5px;
                                    padding: 0.5rem 0.8rem;
                                "
                                onmouseover="this.style.backgroundColor='#1E3C72'"
                                onmouseout="this.style.backgroundColor='#3B62A4'"
                                title="Edit Profil">
                                    <i class="fas fa-user-edit"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="
                                        background-color: #dc3545; 
                                        border-color: #dc3545; 
                                        border-radius: 8px; 
                                        font-weight: 500; 
                                        transition: all 0.2s ease;
                                        padding: 0.5rem 0.8rem;
                                    "
                                    onmouseover="this.style.backgroundColor='#c82333'"
                                    onmouseout="this.style.backgroundColor='#dc3545'"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}? Aksi ini tidak dapat dibatalkan.')"
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                    {{ $user->id === auth()->id() ? 'style="opacity: 0.65; cursor: not-allowed;"' : '' }}
                                    title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 20px; color: #6c757d;">
                                <i class="fas fa-info-circle me-2"></i> Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
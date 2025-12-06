@extends('layouts.app')

@section('title', 'Hak Akses')

@section('content')
<div class="container-fluid" style="padding: 0;">

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-5" style="padding-bottom: 20px; border-bottom: 1px solid #e0e0e0;">
        <h4 style="font-weight: 700; color: #1E3C72; margin: 0; font-size: 1.75rem;">Manajemen Hak Akses Pengguna</h4>
        {{-- Tombol Tambah yang Lebih Menarik --}}
    </div>

    {{-- Card Kontainer Data --}}
    <div class="card shadow" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
        <div class="card-body" style="padding: 2.5rem;">
            
            <div class="table-responsive">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr style="background-color: #f1f4f8;">
                            <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem;">#</th>
                            <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem;">Nama Role</th>
                            <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem;">Permissions</th>
                            <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="roleTableBody">
                        @foreach($roles as $role)
                        <tr class="table-row" style="transition: background-color 0.2s ease;"
                            onmouseover="this.style.backgroundColor='#f9f9f9'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <td style="vertical-align: middle; padding: 1rem 1.5rem; color: #6c757d;">{{ $loop->iteration }}</td>
                            <td style="vertical-align: middle; font-weight: 600; color: #1E3C72; padding: 1rem 1.5rem; font-size: 1.05rem;">{{ $role->name }}</td>
                            <td style="vertical-align: middle; padding: 1rem 1.5rem;">
                                @foreach($role->permissions as $permission)
                                    {{-- Badge dengan warna accent yang lebih lembut dan elegan --}}
                                    <span class="badge" style="
                                        background-color: #e6f7ff; 
                                        color: #1E3C72; 
                                        font-weight: 500; 
                                        margin-right: 8px; 
                                        margin-bottom: 5px; 
                                        padding: 0.6em 1em; 
                                        border-radius: 4px; 
                                        display: inline-block;
                                        border: 1px solid #1E3C7230;
                                        font-size: 0.85rem;
                                    ">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td style="vertical-align: middle; white-space: nowrap; padding: 1rem 1.5rem;">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('hak-akses.edit', $role->id) }}" class="btn btn-sm" style="
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
                                title="Edit">
                                    <i class="fas fa-wrench"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Optional: Teks jika data kosong --}}
            @if(count($roles) === 0)
                <div class="text-center py-5">
                    <i class="fas fa-user-shield fa-4x mb-3" style="color: #ccc;"></i>
                    <p class="text-muted">Belum ada data Hak Akses (Roles) yang terdaftar.</p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
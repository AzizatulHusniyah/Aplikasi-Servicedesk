@extends('layouts.app')

@section('title', 'Edit Balasan Laporan - Teknisi')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-md-10">
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
                    <i class="fas fa-edit me-2" style="color: #3B62A4;"></i> Edit Balasan Laporan
                </h5>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <!-- Informasi Laporan -->
                <div class="card mb-4" style="
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                ">
                    <div class="card-header" style="
                        background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
                        color: white;
                        border-radius: 10px 10px 0 0 !important;
                        padding: 1rem 1.5rem;
                    ">
                        <h6 class="card-title mb-0" style="font-weight: 600;">
                            <i class="fas fa-info-circle me-2"></i> Informasi Laporan
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong style="color: #495057;">Judul:</strong><br>
                                    <span style="color: #1E3C72; font-weight: 500;">{{ $laporan->judul_laporan }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong style="color: #495057;">User:</strong><br>
                                    <span>{{ $laporan->user->name }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong style="color: #495057;">Kategori:</strong><br>
                                    <span>{{ $laporan->kategoriLayanan->nama }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong style="color: #495057;">Layanan:</strong><br>
                                    <span>{{ $laporan->layanan->nama }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong style="color: #495057;">Tanggal:</strong><br>
                                    <span>{{ $laporan->tanggal_laporan->format('d/m/Y') }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong style="color: #495057;">Status Saat Ini:</strong><br>
                                    <span class="badge px-3 py-2" style="
                                        background-color: {{ $laporan->status == 'selesai' ? '#28a745' : ($laporan->status == 'proses' ? '#ffc107' : '#6c757d') }};
                                        color: {{ $laporan->status == 'proses' ? '#212529' : 'white' }};
                                        border-radius: 20px;
                                        font-weight: 500;
                                    ">
                                        {{ $laporan->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($laporan->lampiran_path)
                        <div class="mt-3 pt-3 border-top">
                            <strong style="color: #495057;">Lampiran User:</strong>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('laporan.download', $laporan->id) }}" class="btn btn-sm px-3 py-2" style="
                                    background-color: #1E3C72;
                                    border-color: #1E3C72;
                                    color: white;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'"
                                onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                                <a href="{{ route('balasan-laporan.view-lampiran-laporan', $laporan->id) }}"
                                   target="_blank"
                                   class="btn btn-sm px-3 py-2" style="
                                    background-color: #28a745;
                                    border-color: #28a745;
                                    color: white;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'"
                                onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'">
                                    <i class="fas fa-eye me-1"></i> Lihat Langsung
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Form Edit Balasan -->
                <form method="POST" action="{{ route('balasan-laporan.update', $laporan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="balasan" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Balasan <span style="color: #dc3545;">*</span>
                        </label>
                        <textarea class="form-control" id="balasan" name="balasan" rows="6" required 
                                  style="
                                      border-radius: 8px;
                                      padding: 0.75rem 1rem;
                                      border: 1px solid #ced4da;
                                      transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                      resize: vertical;
                                  "
                                  onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                  onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">{{ old('balasan', $laporan->balasan) }}</textarea>
                        @error('balasan')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="lampiran_balasan" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Lampiran Balasan
                        </label>

                        @if($laporan->lampiran_balasan_path)
                        <div class="mb-3 p-3 rounded" style="
                            background-color: #f8f9fa;
                            border-radius: 8px;
                            border: 1px solid #e9ecef;
                        ">
                            <strong style="color: #495057;">Lampiran Saat Ini:</strong>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('balasan-laporan.download-lampiran', $laporan->id) }}" class="btn btn-sm px-3 py-2" style="
                                    background-color: #1E3C72;
                                    border-color: #1E3C72;
                                    color: white;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'"
                                onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'">
                                    <i class="fas fa-download me-1"></i> Download Lampiran
                                </a>
                                <a href="{{ route('balasan-laporan.view-lampiran-balasan', $laporan->id) }}" target="_blank" class="btn btn-sm px-3 py-2" style="
                                    background-color: #28a745;
                                    border-color: #28a745;
                                    color: white;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'"
                                onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'">
                                    <i class="fas fa-eye me-1"></i> Lihat Langsung
                                </a>
                            </div>
                        </div>
                        @endif

                        <input type="file" class="form-control" id="lampiran_balasan" name="lampiran_balasan" 
                               style="
                                   border-radius: 8px;
                                   padding: 0.75rem 1rem;
                                   border: 1px solid #ced4da;
                                   transition: border-color 0.3s ease, box-shadow 0.3s ease;
                               "
                               onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                               onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                        <small class="form-text text-muted mt-2 d-block" style="font-size: 0.875rem;">
                            <i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah lampiran. Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)
                        </small>
                        @error('lampiran_balasan')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Status Laporan <span style="color: #dc3545;">*</span>
                        </label>
                        <select class="form-select" id="status" name="status" required 
                                style="
                                    border-radius: 8px;
                                    padding: 0.75rem 1rem;
                                    border: 1px solid #ced4da;
                                    transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                "
                                onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                            <option value="proses" {{ old('status', $laporan->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status', $laporan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="draft" {{ old('status', $laporan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('balasan-laporan.index') }}" class="btn px-4 py-2" style="
                            background-color: #6c757d;
                            border-color: #6c757d;
                            color: white;
                            border-radius: 8px;
                            font-weight: 500;
                            transition: all 0.3s ease;
                        "
                        onmouseover="this.style.backgroundColor='#5a6268'; this.style.borderColor='#5a6268'"
                        onmouseout="this.style.backgroundColor='#6c757d'; this.style.borderColor='#6c757d'">
                            <i class="fas fa-times me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn px-4 py-2" style="
                            background-color: #ffc107;
                            border-color: #ffc107;
                            color: #212529;
                            border-radius: 8px;
                            font-weight: 600;
                            transition: all 0.3s ease;
                        "
                        onmouseover="this.style.backgroundColor='#e0a800'; this.style.borderColor='#e0a800'; this.style.boxShadow='0 4px 10px rgba(255, 193, 7, 0.4)'"
                        onmouseout="this.style.backgroundColor='#ffc107'; this.style.borderColor='#ffc107'; this.style.boxShadow='none'">
                            <i class="fas fa-save me-2"></i> Update Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
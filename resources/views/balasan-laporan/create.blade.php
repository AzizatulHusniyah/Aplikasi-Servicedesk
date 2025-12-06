@extends('layouts.app')

@section('title', 'Balas Laporan - Teknisi')

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
                    <i class="fas fa-reply me-2" style="color: #3B62A4;"></i> Balas Laporan
                </h5>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <!-- Informasi Laporan -->
                <div class="card mb-4" style="
                    border: 1px solid #e9ecef;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                ">
                    <div class="card-header bg-light" style="
                        background-color: #f8f9fa !important;
                        border-bottom: 1px solid #e9ecef;
                        padding: 1rem 1.5rem;
                    ">
                        <h6 class="card-title mb-0" style="
                            color: #1E3C72;
                            font-weight: 600;
                            font-size: 1.1rem;
                        ">
                            <i class="fas fa-info-circle me-2" style="color: #3B62A4;"></i> Informasi Laporan
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <p style="margin-bottom: 0.75rem;">
                                    <strong style="color: #495057;">Judul:</strong><br>
                                    <span style="color: #1E3C72; font-weight: 500;">{{ $laporan->judul_laporan }}</span>
                                </p>
                                <p style="margin-bottom: 0.75rem;">
                                    <strong style="color: #495057;">User:</strong><br>
                                    <span style="color: #1E3C72; font-weight: 500;">{{ $laporan->user->name }}</span>
                                </p>
                                <p style="margin-bottom: 0.75rem;">
                                    <strong style="color: #495057;">Kategori:</strong><br>
                                    <span style="color: #1E3C72; font-weight: 500;">{{ $laporan->kategoriLayanan->nama }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p style="margin-bottom: 0.75rem;">
                                    <strong style="color: #495057;">Layanan:</strong><br>
                                    <span style="color: #1E3C72; font-weight: 500;">{{ $laporan->layanan->nama }}</span>
                                </p>
                                <p style="margin-bottom: 0.75rem;">
                                    <strong style="color: #495057;">Tanggal:</strong><br>
                                    <span style="color: #1E3C72; font-weight: 500;">{{ $laporan->tanggal_laporan->format('d/m/Y') }}</span>
                                </p>
                                <p style="margin-bottom: 0.75rem;">
                                    <strong style="color: #495057;">Status:</strong><br>
                                    <span class="badge" style="
                                        background-color: {{ $laporan->status == 'selesai' ? '#28a745' : ($laporan->status == 'proses' ? '#ffc107' : '#6c757d') }};
                                        color: {{ $laporan->status == 'proses' ? '#212529' : 'white' }};
                                        border-radius: 6px;
                                        padding: 0.35rem 0.75rem;
                                        font-weight: 500;
                                    ">
                                        {{ $laporan->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3" style="border-top: 1px solid #e9ecef;">
                            <strong style="color: #495057;">Deskripsi:</strong>
                            <p class="mb-0 mt-2" style="
                                color: #495057;
                                line-height: 1.6;
                                background-color: #f8f9fa;
                                padding: 1rem;
                                border-radius: 8px;
                                border-left: 4px solid #3B62A4;
                            ">
                                {{ $laporan->deskripsi }}
                            </p>
                        </div>
                        @if($laporan->lampiran_path)
                        <div class="mt-3 pt-3" style="border-top: 1px solid #e9ecef;">
                            <strong style="color: #495057; display: block; margin-bottom: 0.5rem;">Lampiran User:</strong>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('laporan.download', $laporan->id) }}" class="btn" style="
                                    background-color: #3B62A4;
                                    border-color: #3B62A4;
                                    color: white;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    padding: 0.5rem 1rem;
                                    margin-right: 0.5rem;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'"
                                onmouseout="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                                <a href="{{ route('balasan-laporan.view-lampiran-laporan', $laporan->id) }}"
                                   target="_blank"
                                   class="btn" style="
                                    background-color: #28a745;
                                    border-color: #28a745;
                                    color: white;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    padding: 0.5rem 1rem;
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

                <!-- Form Balasan -->
                <form method="POST" action="{{ route('balasan-laporan.store', $laporan->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="balasan" class="form-label" style="
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                        ">
                            Balasan *
                        </label>
                        <textarea class="form-control" id="balasan" name="balasan" rows="6"
                                  placeholder="Tulis balasan untuk laporan ini..." required
                                  style="
                                      border-radius: 8px;
                                      padding: 0.75rem 1rem;
                                      border: 1px solid #ced4da;
                                      transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                  ">{{ old('balasan') }}</textarea>
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
                        <input type="file" class="form-control" id="lampiran_balasan" name="lampiran_balasan"
                               style="
                                   border-radius: 8px;
                                   padding: 0.75rem 1rem;
                                   border: 1px solid #ced4da;
                               ">
                        <small class="form-text text-muted" style="font-size: 0.875rem; margin-top: 0.25rem;">
                            <i class="fas fa-info-circle me-1" style="color: #3B62A4;"></i>
                            Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)
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
                            Status Laporan *
                        </label>
                        <select class="form-control" id="status" name="status" required
                                style="
                                    border-radius: 8px;
                                    padding: 0.75rem 1rem;
                                    border: 1px solid #ced4da;
                                    transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                ">
                            <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start gap-3 mt-4">
                        <a href="{{ route('balasan-laporan.index') }}" class="btn" style="
                            background-color: #6c757d;
                            border-color: #6c757d;
                            border-radius: 8px;
                            font-weight: 500;
                            padding: 0.75rem 1.75rem;
                            transition: all 0.3s ease;
                            color: white;
                        "
                        onmouseover="this.style.backgroundColor='#5a6268'; this.style.borderColor='#5a6268'"
                        onmouseout="this.style.backgroundColor='#6c757d'; this.style.borderColor='#6c757d'">
                            <i class="fas fa-arrow-left me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn" style="
                            background-color: #28a745;
                            border-color: #28a745;
                            border-radius: 8px;
                            font-weight: 600;
                            padding: 0.75rem 1.75rem;
                            transition: all 0.3s ease;
                            color: white;
                        "
                        onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'; this.style.boxShadow='0 4px 10px rgba(40, 167, 69, 0.4)'"
                        onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'; this.style.boxShadow='none'">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
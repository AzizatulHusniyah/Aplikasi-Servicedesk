@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-md-10">
        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Laporan
                    </h5>
                    <span class="badge custom-badge">
                        ID: {{ $laporan->id }} | Tiket: {{ $laporan->kode_tiket }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('laporan.update', $laporan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="kategori_layanan_id" class="form-label">
                                    Kategori Layanan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select custom-select" id="kategori_layanan_id" name="kategori_layanan_id" required>
                                    <option value="">Pilih Kategori Layanan</option>
                                    @foreach($kategoriLayanan as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $laporan->kategori_layanan_id == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_layanan_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="layanan_id" class="form-label">
                                    Layanan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select custom-select" id="layanan_id" name="layanan_id" required>
                                    <option value="">Pilih Layanan</option>
                                    @foreach($layanan as $item)
                                        <option value="{{ $item->id }}" {{ $laporan->layanan_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="judul_laporan" class="form-label">
                            Judul Laporan <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control custom-input" id="judul_laporan" name="judul_laporan" 
                               value="{{ $laporan->judul_laporan }}" required>
                        @error('judul_laporan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">
                            Keterangan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control custom-textarea" id="deskripsi" name="deskripsi" rows="4" required>{{ $laporan->deskripsi }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tanggal_laporan" class="form-label">
                                    Tanggal Laporan <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control custom-input" id="tanggal_laporan" name="tanggal_laporan" 
                                       value="{{ $laporan->tanggal_laporan->format('Y-m-d') }}" required>
                                @error('tanggal_laporan')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="waktu_laporan" class="form-label">
                                    Waktu Laporan <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control custom-input" id="waktu_laporan" name="waktu_laporan" 
                                       value="{{ $laporan->waktu_laporan ? \Carbon\Carbon::parse($laporan->waktu_laporan)->timezone('Asia/Jakarta')->format('H:i') : \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i') }}" required>
                                <div class="form-text-info">
                                    <i class="fas fa-clock me-1"></i> Waktu Indonesia Barat (WIB) - Sekarang: <span id="current-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i') }}</span>
                                </div>
                                @error('waktu_laporan')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="lampiran" class="form-label">
                            Lampiran
                        </label>
                        @if($laporan->lampiran_path)
                            <div class="file-preview mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('laporan.download', $laporan->id) }}" class="btn btn-sm custom-btn-download me-3">
                                        <i class="fas fa-download me-1"></i> Download Lampiran
                                    </a>
                                    <span class="text-muted">{{ basename($laporan->lampiran_path) }}</span>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control custom-input" id="lampiran" name="lampiran">
                        <div class="form-text-info">
                            <i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah lampiran
                        </div>
                        @error('lampiran')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(auth()->user()->hasRole('administrator'))
                    <div class="mb-4">
                        <label for="status" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select custom-select" id="status" name="status" required>
                            <option value="draft" {{ $laporan->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="proses" {{ $laporan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @else
                    <input type="hidden" name="status" value="{{ $laporan->status }}">
                    @endif

                    <div class="d-flex justify-content-start gap-3 mt-5">
                        <button type="submit" class="btn btn-primary custom-btn-primary">
                            <i class="fas fa-check-circle me-2"></i> Update Laporan
                        </button>

                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary custom-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriLayananSelect = document.getElementById('kategori_layanan_id');
    const layananSelect = document.getElementById('layanan_id');
    
    // Fungsi untuk memuat layanan berdasarkan kategori
    function loadLayananByKategori(kategoriId, selectedLayananId = null) {
        // Reset dan disable dropdown layanan
        layananSelect.innerHTML = '<option value="">Memuat layanan...</option>';
        layananSelect.disabled = true;
        
        if (kategoriId) {
            // AJAX request untuk mendapatkan layanan berdasarkan kategori
            fetch(`/get-layanan-by-kategori/${kategoriId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Kosongkan dan isi ulang dropdown layanan
                    layananSelect.innerHTML = '<option value="">Pilih Layanan</option>';
                    
                    if (data.length === 0) {
                        layananSelect.innerHTML = '<option value="">Tidak ada layanan tersedia untuk kategori ini</option>';
                    } else {
                        data.forEach(layanan => {
                            const option = document.createElement('option');
                            option.value = layanan.id;
                            option.textContent = layanan.nama;
                            
                            // Set selected jika ada nilai currentLayananId atau selectedLayananId
                            const currentLayananId = {{ $laporan->layanan_id }};
                            if ((selectedLayananId && selectedLayananId == layanan.id) || 
                                (!selectedLayananId && currentLayananId && currentLayananId == layanan.id)) {
                                option.selected = true;
                            }
                            
                            layananSelect.appendChild(option);
                        });
                    }
                    
                    layananSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    layananSelect.innerHTML = '<option value="">Error memuat layanan</option>';
                    layananSelect.disabled = false;
                });
        } else {
            layananSelect.innerHTML = '<option value="">Pilih Layanan</option>';
            layananSelect.disabled = false;
        }
    }
    
    // Event listener untuk perubahan kategori
    kategoriLayananSelect.addEventListener('change', function() {
        const selectedKategoriId = this.value;
        loadLayananByKategori(selectedKategoriId);
    });
    
    // Inisialisasi saat halaman dimuat
    const initialKategoriId = kategoriLayananSelect.value;
    if (initialKategoriId) {
        loadLayananByKategori(initialKategoriId);
    }
});

// Fungsi untuk update waktu (existing)
function updateCurrentTime() {
    const now = new Date();
    const options = { 
        timeZone: 'Asia/Jakarta',
        hour12: false,
        hour: '2-digit',
        minute: '2-digit'
    };
    const timeString = now.toLocaleTimeString('id-ID', options);
    document.getElementById('current-time').textContent = timeString;
}

// Update time immediately and then every minute
updateCurrentTime();
setInterval(updateCurrentTime, 60000);
</script>

<style>
.custom-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    font-family: 'Arial', sans-serif;
}

.custom-card-header {
    background-color: #fff;
    border-bottom: 2px solid #1E3C72;
    padding: 1.5rem 2rem;
}

.custom-card-header .card-title {
    color: #1E3C72;
    font-weight: 700;
    margin: 0;
    font-size: 1.5rem;
}

.custom-badge {
    background-color: #f8f9fa;
    color: #1E3C72;
    font-size: 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    border: 1px solid #dee2e6;
    padding: 0.5rem 1rem;
}

.custom-select,
.custom-input,
.custom-textarea {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.custom-select:focus,
.custom-input:focus,
.custom-textarea:focus {
    border-color: #1E3C72;
    box-shadow: 0 0 0 0.2rem rgba(30, 60, 114, 0.1);
    outline: none;
}

.form-text-info {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

#current-time {
    font-weight: 600;
    color: #1E3C72;
}

.file-preview {
    background-color: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    padding: 1rem;
}

.custom-btn-download {
    background-color: #1E3C72;
    border-color: #1E3C72;
    color: white;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.custom-btn-download:hover {
    background-color: #3B62A4;
    border-color: #3B62A4;
    color: white;
}

.custom-btn-primary {
    background-color: #1E3C72;
    border-color: #1E3C72;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.75rem;
    transition: all 0.3s ease;
}

.custom-btn-primary:hover {
    background-color: #3B62A4;
    border-color: #3B62A4;
    box-shadow: 0 4px 10px rgba(30, 60, 114, 0.4);
    transform: translateY(-1px);
}

.custom-btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    border-radius: 8px;
    font-weight: 500;
    padding: 0.75rem 1.75rem;
    transition: all 0.3s ease;
}

.custom-btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
}

.text-danger {
    font-size: 0.875rem;
}
</style>
@endsection
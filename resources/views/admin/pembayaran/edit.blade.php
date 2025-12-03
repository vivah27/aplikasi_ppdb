@extends('layouts.master')

@section('page_title', 'Verifikasi Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                <i class="ti ti-arrow-left"></i>
            </a>
            Verifikasi Pembayaran #{{ $pembayaran->id }}
        </h1>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Bukti Pembayaran -->
            @if($pembayaran->bukti)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="ti ti-file me-2"></i>Bukti Pembayaran</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $pembayaran->bukti) }}" 
                             alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 500px;">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pembayaran->bukti) }}" 
                               target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                <i class="ti ti-external-link me-1"></i>Buka Gambar
                            </a>
                            <a href="{{ asset('storage/' . $pembayaran->bukti) }}" 
                               download class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="ti ti-alert-circle me-2"></i>Tidak ada bukti pembayaran
                </div>
            @endif

            <!-- Form Verifikasi -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ti ti-clipboard-check me-2"></i>Form Verifikasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Pembayaran -->
                        <div class="row mb-4 pb-3 border-bottom">
                            <div class="col-md-6">
                                <p class="text-muted mb-1"><small>Nama Pembayaran</small></p>
                                <p class="fw-bold">{{ $pembayaran->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1"><small>Metode</small></p>
                                <p class="fw-bold">{{ $pembayaran->metode }}</p>
                            </div>
                        </div>

                        <div class="row mb-4 pb-3 border-bottom">
                            <div class="col-md-6">
                                <p class="text-muted mb-1"><small>Jumlah</small></p>
                                <p class="fw-bold text-success" style="font-size: 1.1rem;">
                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1"><small>Tanggal Upload</small></p>
                                <p>{{ $pembayaran->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Detail Transfer/E-Wallet -->
                        @if($pembayaran->metode === 'Transfer Bank' || str_contains($pembayaran->metode, 'Transfer'))
                            @if($pembayaran->nama_bank)
                                <div class="row mb-4 pb-3 border-bottom bg-info bg-opacity-10 p-3 rounded">
                                    <h6 class="mb-3"><i class="ti ti-building-bank me-2 text-info"></i>Detail Transfer Bank</h6>
                                    <div class="col-md-6">
                                        <p class="text-muted mb-1"><small>Nama Bank</small></p>
                                        <p class="fw-bold">{{ $pembayaran->nama_bank }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted mb-1"><small>Nomor Rekening</small></p>
                                        <p class="fw-bold font-monospace">{{ $pembayaran->nomor_rekening }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-muted mb-1"><small>Atas Nama Rekening</small></p>
                                        <p class="fw-bold">{{ $pembayaran->atas_nama_rekening }}</p>
                                    </div>
                                </div>
                            @endif
                        @elseif($pembayaran->metode === 'E-Wallet' || str_contains($pembayaran->metode, 'Wallet'))
                            @if($pembayaran->jenis_ewallet)
                                <div class="row mb-4 pb-3 border-bottom bg-success bg-opacity-10 p-3 rounded">
                                    <h6 class="mb-3"><i class="ti ti-wallet me-2 text-success"></i>Detail E-Wallet</h6>
                                    <div class="col-md-6">
                                        <p class="text-muted mb-1"><small>Jenis E-Wallet</small></p>
                                        <p class="fw-bold">{{ $pembayaran->jenis_ewallet }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted mb-1"><small>Nomor/ID E-Wallet</small></p>
                                        <p class="fw-bold font-monospace">{{ $pembayaran->nomor_ewallet }}</p>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Status Decision -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">
                                <i class="ti ti-alert-circle me-2 text-warning"></i>Keputusan Verifikasi <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check card p-3 border-success cursor-pointer"
                                         onclick="document.getElementById('status_terima').checked = true; updateStatusUI();">
                                        <input class="form-check-input" type="radio" name="status" 
                                               id="status_terima" value="Terverifikasi" required>
                                        <label class="form-check-label ms-2" for="status_terima">
                                            <i class="ti ti-check text-success me-2"></i>
                                            <strong>Terima Pembayaran</strong>
                                            <p class="text-muted mb-0"><small>Pembayaran diterima dan valid</small></p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check card p-3 border-danger cursor-pointer"
                                         onclick="document.getElementById('status_tolak').checked = true; updateStatusUI();">
                                        <input class="form-check-input" type="radio" name="status" 
                                               id="status_tolak" value="Ditolak" required>
                                        <label class="form-check-label ms-2" for="status_tolak">
                                            <i class="ti ti-x text-danger me-2"></i>
                                            <strong>Tolak Pembayaran</strong>
                                            <p class="text-muted mb-0"><small>Pembayaran ditolak atau tidak valid</small></p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label for="catatan" class="form-label">
                                <i class="ti ti-notes me-1"></i>Catatan (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="4"
                                      placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan', $pembayaran->catatan) }}</textarea>
                            <small class="text-muted">Catatan akan ditampilkan kepada siswa</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 gap-md-3">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="ti ti-check me-2"></i>Simpan Keputusan Verifikasi
                            </button>
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-lg btn-outline-secondary">
                                <i class="ti ti-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3 sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="ti ti-info-circle me-2"></i>Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3 pb-3 border-bottom">
                        <p class="text-muted mb-2"><small>Status Saat Ini</small></p>
                        <span class="badge bg-{{ match($pembayaran->status) {
                            'Menunggu Verifikasi' => 'warning',
                            'Terverifikasi' => 'success',
                            'Ditolak' => 'danger',
                            default => 'secondary'
                        } }}" style="font-size: 0.95rem; padding: 0.6rem 1rem;">
                            {{ $pembayaran->status }}
                        </span>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <p class="text-muted mb-2"><small>ID Pembayaran</small></p>
                        <p class="fw-bold mb-0">#{{ $pembayaran->id }}</p>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <p class="text-muted mb-2"><small>Metode Pembayaran</small></p>
                        <p class="fw-bold mb-0">{{ $pembayaran->metode }}</p>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-2"><small>Jumlah</small></p>
                        <p class="fw-bold text-success mb-0" style="font-size: 1.1rem;">
                            Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3"><i class="ti ti-list-check me-2"></i>Checklist Verifikasi</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check1" checked disabled>
                        <label class="form-check-label" for="check1">
                            <small>Bukti pembayaran ada</small>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check2">
                        <label class="form-check-label" for="check2">
                            <small>Nominal sesuai</small>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check3">
                        <label class="form-check-label" for="check3">
                            <small>Bukti jelas dan terbaca</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check4">
                        <label class="form-check-label" for="check4">
                            <small>Semua kriteria terpenuhi</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    
    .form-check.card {
        transition: all 0.2s;
    }
    
    .form-check.card:hover {
        background-color: #f5f5f5;
    }
    
    .form-check-input:checked ~ .form-check-label {
        font-weight: 600;
    }
</style>

<script>
    function updateStatusUI() {
        const status = document.querySelector('input[name="status"]:checked');
        if (status) {
            const terima = document.querySelector('.form-check.border-success');
            const tolak = document.querySelector('.form-check.border-danger');
            
            if (status.value === 'Terverifikasi') {
                terima?.classList.add('border-3');
                tolak?.classList.remove('border-3');
            } else {
                tolak?.classList.add('border-3');
                terima?.classList.remove('border-3');
            }
        }
    }
    
    // Initialize on load
    document.addEventListener('DOMContentLoaded', updateStatusUI);
</script>
@endsection

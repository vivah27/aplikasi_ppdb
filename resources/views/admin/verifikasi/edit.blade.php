@extends('layouts.master')

@section('page_title', 'Verifikasi Dokumen')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.verifikasi') }}">Verifikasi Dokumen</a></li>
                    <li class="breadcrumb-item active">Edit Verifikasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Dokumen Preview -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Preview Dokumen</h5>
                </div>
                <div class="card-body">
                    @if (str_ends_with($dokumen->path, '.pdf'))
                        <embed src="{{ route('admin.verifikasi.preview', $dokumen->id) }}" type="application/pdf" width="100%" height="600" style="border: none;">
                    @else
                        <img src="{{ route('admin.verifikasi.preview', $dokumen->id) }}" class="img-fluid rounded" alt="Preview Dokumen">
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.verifikasi.preview', $dokumen->id) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="ti ti-external-link"></i> Buka di Tab Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Verifikasi Form -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Dokumen & Verifikasi</h5>
                </div>
                <div class="card-body">
                    <!-- Info Siswa -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-primary mb-3">Informasi Siswa</h6>
                        <p class="mb-2">
                            <strong>Nama:</strong> {{ $dokumen->siswa->nama_lengkap }}
                        </p>
                        <p class="mb-2">
                            <strong>NISN:</strong> {{ $dokumen->siswa->nisn }}
                        </p>
                        <p class="mb-2">
                            <strong>Email:</strong> {{ $dokumen->siswa->email ?? '-' }}
                        </p>
                    </div>

                    <!-- Info Dokumen -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-primary mb-3">Informasi Dokumen</h6>
                        <p class="mb-2">
                            <strong>Jenis Dokumen:</strong> {{ $dokumen->jenisDokumen->nama }}
                        </p>
                        <p class="mb-2">
                            <strong>Deskripsi:</strong> {{ $dokumen->jenisDokumen->deskripsi ?? '-' }}
                        </p>
                        <p class="mb-2">
                            <strong>Wajib:</strong> 
                            <span class="badge bg-{{ $dokumen->jenisDokumen->wajib ? 'danger' : 'success' }}">
                                {{ $dokumen->jenisDokumen->wajib ? 'Ya' : 'Tidak' }}
                            </span>
                        </p>
                        <p class="mb-2">
                            <strong>Tanggal Upload:</strong> {{ $dokumen->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                    <!-- Verifikasi Form -->
                    <form action="{{ route('admin.verifikasi.update', $dokumen->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Status Verifikasi (hidden) -->
                        <input type="hidden" id="status_verifikasi_id" name="status_verifikasi_id" value="{{ old('status_verifikasi_id', $dokumen->status_verifikasi_id) }}">
                        <div class="mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <div>
                                @php
                                    $currentStatusLabel = $dokumen->statusVerifikasi?->label ?? 'Menunggu Verifikasi';
                                    $currentStatusKode = $dokumen->statusVerifikasi?->kode ?? 'pending';
                                @endphp
                                <span class="badge bg-{{ $currentStatusKode === 'verified' ? 'success' : ($currentStatusKode === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ $currentStatusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror"
                                      id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan verifikasi...">{{ old('catatan', $dokumen->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Catatan akan diteruskan ke siswa
                            </small>
                        </div>

                        <!-- Buttons (main form: Kembali + Simpan) -->
                        <div class="d-flex gap-2 justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.verifikasi') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-2"></i> Kembali
                                </a>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-check me-2"></i> Simpan Verifikasi
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Quick action buttons (outside main form to avoid nested-form validation issues) -->
                    <div class="mt-3 d-flex gap-2">
                        <form action="{{ route('admin.verifikasi.accept', $dokumen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin langsung menandai dokumen ini sebagai TER-VERIFIKASI?');">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-2"></i> Terima
                            </button>
                        </form>

                        <form action="{{ route('admin.verifikasi.reject', $dokumen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak dokumen ini?');">
                            @csrf
                            <input type="hidden" name="catatan" value="Ditolak oleh admin (quick action)">
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-x me-2"></i> Tolak
                            </button>
                        </form>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

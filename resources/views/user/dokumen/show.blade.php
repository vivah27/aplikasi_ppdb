@extends('layouts.master')

@section('page_title', 'Detail Dokumen')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Detail Dokumen
                </h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('user.dokumen.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <!-- Document Preview -->
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Preview Dokumen</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $ext = strtolower(pathinfo($dokumen->path, PATHINFO_EXTENSION));
                        @endphp
                        
                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ Storage::url($dokumen->path) }}" class="img-fluid rounded" alt="Dokumen">
                        @elseif($ext === 'pdf')
                            <iframe src="{{ Storage::url($dokumen->path) }}" width="100%" height="600" style="border: none; border-radius: 4px;"></iframe>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-file"></i> File tidak dapat ditampilkan dalam preview.
                                <a href="{{ route('user.dokumen.download', $dokumen->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Unduh File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Document Info -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Status Dokumen</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-6">Status</dt>
                            <dd class="col-6">
                                @switch($dokumen->statusVerifikasi->kode)
                                    @case('verified')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Tertunda
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                        @break
                                    @case('revision')
                                        <span class="badge bg-info">
                                            <i class="fas fa-edit"></i> Revisi
                                        </span>
                                        @break
                                @endswitch
                            </dd>

                            <dt class="col-6">Jenis Dokumen</dt>
                            <dd class="col-6">{{ $dokumen->jenisDokumen->nama }}</dd>

                            <dt class="col-6">Wajib/Opsional</dt>
                            <dd class="col-6">
                                @if($dokumen->jenisDokumen->wajib)
                                    <span class="badge bg-danger">Wajib</span>
                                @else
                                    <span class="badge bg-secondary">Opsional</span>
                                @endif
                            </dd>

                            <dt class="col-6">Tanggal Upload</dt>
                            <dd class="col-6">{{ $dokumen->created_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-6">Terakhir Diperbarui</dt>
                            <dd class="col-6">{{ $dokumen->updated_at->format('d/m/Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Aksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('user.dokumen.download', $dokumen->id) }}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Unduh Dokumen
                            </a>
                            @if(in_array($dokumen->statusVerifikasi->kode, ['rejected', 'revision']))
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#uploadUlangModal">
                                    <i class="fas fa-redo"></i> Upload Ulang
                                </button>
                            @endif
                            @if(in_array($dokumen->statusVerifikasi->kode, ['rejected', 'revision']))
                                <form action="{{ route('user.dokumen.destroy', $dokumen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Hapus Dokumen
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Catatan Dari Admin -->
                @if($dokumen->catatan)
                    <div class="card">
                        <div class="card-header bg-warning-light">
                            <h3 class="card-title">Catatan dari Admin</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-sticky-note me-2"></i>
                                {{ $dokumen->catatan }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Upload Ulang Modal -->
@if(in_array($dokumen->statusVerifikasi->kode, ['rejected', 'revision']))
    <div class="modal fade" id="uploadUlangModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Ulang Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih File Baru <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Format: PDF, JPG, JPEG, PNG (Max: 5 MB)</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Jelaskan perbaikan yang Anda lakukan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Ulang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

@extends('layouts.master')

@section('page_title', 'Detail Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-3">
        <a href="{{ route('user.pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Pembayaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terjadi Kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Detail Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><small>Nama Pembayaran</small></p>
                            <p class="fw-bold fs-6">{{ $pembayaran->nama ?? 'Pembayaran Pendaftaran' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><small>ID Pembayaran</small></p>
                            <p class="fw-bold fs-6">#{{ str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><small>Jumlah Pembayaran</small></p>
                            <p class="fw-bold fs-5 text-success">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><small>Metode Pembayaran</small></p>
                            <p class="fw-bold fs-6">{{ $pembayaran->metode ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><small>Status</small></p>
                            <p>
                                @php
                                    $statusClass = match($pembayaran->status ?? '') {
                                        'Terverifikasi' => 'success',
                                        'Ditolak' => 'danger',
                                        'Menunggu Verifikasi', 'Menunggu' => 'warning',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }} fs-6 p-2">
                                    <i class="fas fa-circle-notch me-1"></i>{{ $pembayaran->status ?? 'Menunggu Verifikasi' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><small>Tanggal Upload</small></p>
                            <p class="fw-bold fs-6">
                                <i class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Detail Berdasarkan Metode -->
                    @if($pembayaran->metode === 'Transfer Bank' || strpos($pembayaran->metode ?? '', 'Bank') !== false)
                        <div class="mb-4 p-3 border border-info rounded bg-light">
                            <h6 class="fw-bold text-info mb-3"><i class="fas fa-university me-2"></i>Detail Transfer Bank</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1"><small>Nama Bank</small></p>
                                    <p class="fw-bold">{{ $pembayaran->nama_bank ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1"><small>Nomor Rekening</small></p>
                                    <p class="fw-bold">{{ $pembayaran->nomor_rekening ?? '-' }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted mb-1"><small>Atas Nama Rekening</small></p>
                                    <p class="fw-bold">{{ $pembayaran->atas_nama_rekening ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($pembayaran->metode === 'E-wallet' || strpos($pembayaran->metode ?? '', 'wallet') !== false)
                        <div class="mb-4 p-3 border border-success rounded bg-light">
                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-mobile-alt me-2"></i>Detail E-Wallet</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1"><small>Jenis E-Wallet</small></p>
                                    <p class="fw-bold">{{ $pembayaran->jenis_ewallet ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1"><small>Nomor E-Wallet</small></p>
                                    <p class="fw-bold">{{ $pembayaran->nomor_ewallet ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Bukti Pembayaran -->
                    @if($pembayaran->bukti)
                        <div class="mb-4 p-3 border border-secondary rounded bg-light">
                            <h6 class="fw-bold mb-3"><i class="fas fa-file-upload me-2"></i>Bukti Pembayaran</h6>
                            <a href="{{ asset('storage/' . $pembayaran->bukti) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Bukti Pembayaran
                            </a>
                        </div>
                    @endif

                    <!-- Catatan -->
                    @if($pembayaran->catatan)
                        <div class="mb-4 p-3 bg-light border-start border-4 border-warning">
                            <p class="text-muted mb-2"><small><i class="fas fa-sticky-note me-1"></i>Catatan</small></p>
                            <p class="fw-normal">{{ $pembayaran->catatan }}</p>
                        </div>
                    @endif

                    <!-- Status Verifikasi -->
                    @if($pembayaran->status === 'Terverifikasi')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Pembayaran Terverifikasi!</strong> Pembayaran Anda telah dikonfirmasi oleh admin.
                            Anda sekarang dapat mencetak kartu peserta dan dokumen lainnya.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @elseif($pembayaran->status === 'Ditolak')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Pembayaran Ditolak!</strong> Pembayaran Anda tidak dapat diterima.
                            Silakan upload ulang bukti pembayaran yang benar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @else
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-hourglass-half me-2"></i>
                            <strong>Menunggu Verifikasi!</strong> Pembayaran Anda sudah kami terima dan sedang dalam proses verifikasi.
                            Anda akan mendapat notifikasi via email ketika pembayaran sudah diverifikasi.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Aksi</h5>
                </div>
                <div class="card-body">
                    @if($pembayaran->status === 'Menunggu Verifikasi')
                        <div class="mb-3">
                            <a href="{{ route('user.pembayaran.index') }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="fas fa-list me-1"></i>Lihat Daftar Pembayaran
                            </a>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#editPaymentModal">
                                <i class="fas fa-edit me-1"></i>Perbarui Pembayaran
                            </button>
                        </div>

                        <div class="mb-3">
                            <form action="{{ route('user.pembayaran.destroy', $pembayaran->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                    <i class="fas fa-trash me-1"></i>Hapus Pembayaran
                                </button>
                            </form>
                        </div>

                        <hr>

                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle me-1"></i>Anda dapat mengubah atau menghapus pembayaran selama masih menunggu verifikasi.</small>
                        </div>
                    @else
                        <div class="alert alert-secondary">
                            <small><i class="fas fa-lock me-1"></i>Pembayaran tidak dapat diubah setelah diverifikasi atau ditolak.</small>
                        </div>

                        @if($pembayaran->status === 'Terverifikasi')
                            <div class="mb-3">
                                <a href="{{ route('cetak.index') }}" class="btn btn-success w-100">
                                    <i class="fas fa-file-pdf me-1"></i>Cetak Dokumen
                                </a>
                            </div>
                        @elseif($pembayaran->status === 'Ditolak')
                            <div class="mb-3">
                                <a href="{{ route('user.pembayaran.create') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-plus me-1"></i>Upload Ulang Pembayaran
                                </a>
                            </div>
                        @endif

                        <div class="mb-3">
                            <a href="{{ route('user.pembayaran.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2"><small>Status Pembayaran Terbaru:</small></p>
                    <p class="fw-bold mb-3">
                        @php
                            $statusText = match($pembayaran->status ?? '') {
                                'Terverifikasi' => 'Pembayaran sudah dikonfirmasi',
                                'Ditolak' => 'Pembayaran ditolak - silakan upload ulang',
                                'Menunggu Verifikasi', 'Menunggu' => 'Sedang dalam proses verifikasi',
                                default => 'Status tidak diketahui'
                            };
                        @endphp
                        {{ $statusText }}
                    </p>

                    <div class="alert alert-info">
                        <small><i class="fas fa-bell me-1"></i>Anda akan menerima notifikasi email ketika status pembayaran berubah.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Payment Modal -->
<div class="modal fade" id="editPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Perbarui Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.pembayaran.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Anda hanya dapat mengubah bukti pembayaran dan catatan.
                    </div>

                    <div class="mb-3">
                        <label for="bukti_baru" class="form-label">
                            <i class="fas fa-file-upload me-1"></i>Bukti Pembayaran Baru (Opsional)
                        </label>
                        <input type="file" name="bukti" id="bukti_baru" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        <small class="text-muted d-block mt-2">
                            Format: JPG, PNG, PDF | Maksimal: 2MB | Biarkan kosong jika tidak ingin mengubah
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_baru" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i>Catatan (Opsional)
                        </label>
                        <textarea name="keterangan" id="keterangan_baru" class="form-control" rows="3">{{ $pembayaran->catatan ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

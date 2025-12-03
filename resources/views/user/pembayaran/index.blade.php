@extends('layouts.master')

@section('page_title', 'Riwayat Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Pembayaran</h1>
        <a href="{{ route('user.pembayaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>Upload Pembayaran Baru
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

    @if($pembayaran->count() > 0)
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2"><small>Total Pembayaran</small></p>
                                <h4 class="mb-0">{{ $pembayaran->count() }}</h4>
                            </div>
                            <div style="font-size: 2rem; color: #e3e6f0;">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2"><small>Terverifikasi</small></p>
                                <h4 class="mb-0 text-success">
                                    {{ $pembayaran->filter(function($p) { return $p->status === 'Terverifikasi'; })->count() }}
                                </h4>
                            </div>
                            <div style="font-size: 2rem; color: #28a745;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2"><small>Menunggu Verifikasi</small></p>
                                <h4 class="mb-0 text-warning">
                                    {{ $pembayaran->filter(function($p) { return $p->status === 'Menunggu Verifikasi'; })->count() }}
                                </h4>
                            </div>
                            <div style="font-size: 2rem; color: #ffc107;">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pembayaran -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Pembayaran</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 20%;">Nama Pembayaran</th>
                            <th style="width: 15%;">Jumlah</th>
                            <th style="width: 15%;">Metode</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 20%;">Tanggal Upload</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $index => $p)
                            <tr>
                                <td>{{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + $index + 1 }}</td>
                                <td>
                                    <strong>{{ $p->nama ?? 'Pembayaran Pendaftaran' }}</strong>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $p->metode ?? '-' }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($p->status ?? '') {
                                            'Terverifikasi' => 'success',
                                            'Ditolak' => 'danger',
                                            'Menunggu Verifikasi', 'Menunggu' => 'warning',
                                            default => 'secondary'
                                        };
                                        $statusIcon = match($p->status ?? '') {
                                            'Terverifikasi' => 'check-circle',
                                            'Ditolak' => 'times-circle',
                                            'Menunggu Verifikasi', 'Menunggu' => 'hourglass-half',
                                            default => 'circle'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        <i class="fas fa-{{ $statusIcon }} me-1"></i>{{ $p->status ?? 'Menunggu Verifikasi' }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('user.pembayaran.show', $p->id) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($p->status === 'Menunggu Verifikasi')
                                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('user.pembayaran.destroy', $p->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-secondary" disabled title="Terkunci">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            @if($p->status === 'Menunggu Verifikasi')
                                <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Perbarui Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('user.pembayaran.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>Anda hanya dapat mengubah bukti pembayaran dan catatan.
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="bukti_{{ $p->id }}" class="form-label">
                                                            <i class="fas fa-file-upload me-1"></i>Bukti Pembayaran Baru (Opsional)
                                                        </label>
                                                        <input type="file" name="bukti" id="bukti_{{ $p->id }}" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                        <small class="text-muted d-block mt-2">
                                                            Format: JPG, PNG, PDF | Maksimal: 2MB
                                                        </small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="keterangan_{{ $p->id }}" class="form-label">
                                                            <i class="fas fa-sticky-note me-1"></i>Catatan (Opsional)
                                                        </label>
                                                        <textarea name="keterangan" id="keterangan_{{ $p->id }}" class="form-control" rows="3">{{ $p->catatan ?? '' }}</textarea>
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
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($pembayaran->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $pembayaran->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div style="font-size: 3rem; color: #e3e6f0; margin-bottom: 1rem;">
                    <i class="fas fa-receipt"></i>
                </div>
                <h5 class="text-muted mb-3">Tidak Ada Data Pembayaran</h5>
                <p class="text-muted mb-4">Anda belum melakukan pembayaran. Silakan upload bukti pembayaran Anda.</p>
                <a href="{{ route('user.pembayaran.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i>Upload Pembayaran
                </a>
            </div>
        </div>
    @endif

    <!-- Info Box -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card border-left-info">
                <div class="card-body">
                    <h6 class="fw-bold text-info mb-2"><i class="fas fa-info-circle me-2"></i>Informasi Penting</h6>
                    <ul class="small mb-0">
                        <li>Pastikan bukti pembayaran jelas dan sesuai dengan data yang Anda masukkan</li>
                        <li>Pembayaran akan diverifikasi oleh admin dalam 1-2 hari kerja</li>
                        <li>Anda akan mendapat notifikasi email ketika pembayaran terverifikasi</li>
                        <li>Hanya pembayaran dengan status "Menunggu Verifikasi" yang dapat diubah atau dihapus</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-left-success">
                <div class="card-body">
                    <h6 class="fw-bold text-success mb-2"><i class="fas fa-check-circle me-2"></i>Status Pembayaran</h6>
                    <ul class="small mb-0">
                        <li><span class="badge bg-warning">Menunggu Verifikasi</span> - Dalam proses</li>
                        <li><span class="badge bg-success">Terverifikasi</span> - Diterima admin</li>
                        <li><span class="badge bg-danger">Ditolak</span> - Silakan upload ulang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

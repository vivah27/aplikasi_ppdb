@extends('layouts.master')

@section('page_title', 'Cetak Kuitansi Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            Cetak Kuitansi Pembayaran
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($pembayaranTerverifikasi->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success bg-opacity-10">
                        <h5 class="mb-0 text-success">
                            <i class="fas fa-receipt me-2"></i>Daftar Kuitansi Tersedia
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembayaranTerverifikasi as $index => $pembayaran)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pembayaran->updated_at->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($pembayaran->metodePembayaran)
                                                    {{ $pembayaran->metodePembayaran->label }}
                                                @else
                                                    {{ $pembayaran->metode }}
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-success">
                                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Terverifikasi
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('cetak.kuitansi', $pembayaran->id) }}"
                                                       target="_blank"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-print me-1"></i>Cetak
                                                    </a>
                                                    <a href="{{ route('cetak.kuitansi', $pembayaran->id) }}"
                                                       download="kuitansi-{{ $pembayaran->id }}.html"
                                                       class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                    <ul class="mb-0">
                        <li>Kuitansi hanya tersedia untuk pembayaran yang sudah terverifikasi oleh admin</li>
                        <li>Klik tombol "Cetak" untuk membuka kuitansi di tab baru</li>
                        <li>Gunakan Ctrl+P (Windows) atau Cmd+P (Mac) untuk mencetak</li>
                        <li>Tombol "Download" akan mengunduh file HTML yang bisa dibuka di browser</li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-receipt text-muted" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                        <h4 class="text-muted mb-3">Belum Ada Kuitansi Tersedia</h4>
                        <p class="text-muted mb-4">
                            Kuitansi pembayaran akan tersedia setelah pembayaran Anda diverifikasi oleh admin.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('user.pembayaran.index') }}" class="btn btn-primary">
                                <i class="fas fa-credit-card me-2"></i>Lihat Status Pembayaran
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
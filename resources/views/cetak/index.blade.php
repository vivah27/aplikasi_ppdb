@extends('layouts.master')

@section('page_title', 'Cetak Dokumen')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-print"></i> Cetak Dokumen PPDB
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!isset($pendaftaran) || !$pendaftaran)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Anda belum melakukan pendaftaran. Silakan <a href="{{ route('formulir.index') }}">daftar terlebih dahulu</a>.
                        </div>
                    @else
                        <!-- Status Pendaftaran -->
                        <div class="alert alert-info mb-4">
                            <strong>Status Pendaftaran:</strong> 
                            <span class="badge bg-info">{{ $pendaftaran->statusPendaftaran->nama ?? 'BELUM DIVERIFIKASI' }}</span>
                            <br>
                            <small>Tahun Ajaran: {{ $pendaftaran->tahun_ajaran ?? '-' }}</small>
                        </div>

                        <!-- Tombol Cetak -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h6>Formulir Pendaftaran</h6>
                                        <p class="text-muted small">Cetak formulir lengkap dengan data pribadi</p>
                                        <a href="{{ route('cetak.formulir', ['pendaftaranId' => $pendaftaran->id]) }}" class="btn btn-sm btn-danger" target="_blank">
                                            <i class="fas fa-print"></i> Tampilkan
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-id-card fa-3x text-success mb-3"></i>
                                        <h6>Kartu Peserta</h6>
                                        <p class="text-muted small">
                                            @php
                                                $pembayaranLunas = $pendaftaran && $pendaftaran->pembayaran && $pendaftaran->pembayaran->statusPembayaran && $pendaftaran->pembayaran->statusPembayaran->nama == 'LUNAS';
                                            @endphp
                                            @if($pembayaranLunas)
                                                Cetak kartu peserta ujian
                                            @else
                                                (Hanya untuk pembayaran lunas)
                                            @endif
                                        </p>
                                        @if($pembayaranLunas)
                                            <a href="{{ route('cetak.kartu', ['pendaftaranId' => $pendaftaran->id]) }}" class="btn btn-sm btn-success" target="_blank">
                                                <i class="fas fa-print"></i> Tampilkan
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-lock"></i> Terkunci
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-envelope fa-3x text-warning mb-3"></i>
                                        <h6>Surat Penerimaan</h6>
                                        <p class="text-muted small">
                                            @php
                                                $statusDiterima = $pendaftaran && $pendaftaran->statusPendaftaran && $pendaftaran->statusPendaftaran->nama == 'DITERIMA';
                                            @endphp
                                            @if($statusDiterima)
                                                Cetak surat resmi penerimaan
                                            @else
                                                (Hanya untuk status DITERIMA)
                                            @endif
                                        </p>
                                        @if($statusDiterima)
                                            <a href="{{ route('cetak.surat', ['pendaftaranId' => $pendaftaran->id]) }}" class="btn btn-sm btn-warning" target="_blank">
                                                <i class="fas fa-print"></i> Tampilkan
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-lock"></i> Terkunci
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-receipt fa-3x text-info mb-3"></i>
                                        <h6>Kuitansi Pembayaran</h6>
                                        <p class="text-muted small">
                                            @php
                                                $kuitansiLunas = $pendaftaran && $pendaftaran->pembayaran && $pendaftaran->pembayaran->statusPembayaran && $pendaftaran->pembayaran->statusPembayaran->nama == 'LUNAS';
                                            @endphp
                                            @if($kuitansiLunas)
                                                Cetak bukti pembayaran
                                            @else
                                                (Hanya untuk pembayaran lunas)
                                            @endif
                                        </p>
                                        @if($kuitansiLunas && $pendaftaran->pembayaran)
                                            <a href="{{ route('cetak.kuitansi', ['pembayaranId' => $pendaftaran->pembayaran->id]) }}" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-print"></i> Tampilkan
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-lock"></i> Terkunci
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Cetak -->
                        <div class="mt-4">
                            <h6>
                                <i class="fas fa-history"></i> Riwayat Cetak
                            </h6>
                            <hr>

                            @if($berkasCetak->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Jenis Dokumen</th>
                                                <th>Tanggal Cetak</th>
                                                <th>Informasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($berkasCetak as $berkas)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">
                                                            {{ $berkas->jenisBerkas->nama ?? 'UNKNOWN' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small>{{ $berkas->created_at->format('d/m/Y H:i') }}</small>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $meta = json_decode($berkas->meta, true);
                                                        @endphp
                                                        <small class="text-muted">
                                                            @if($meta && isset($meta['nama']))
                                                                {{ $meta['nama'] }}
                                                            @elseif($meta && isset($meta['jumlah']))
                                                                Rp {{ number_format($meta['jumlah'], 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('cetak.download', $berkas->id) }}" class="btn btn-xs btn-outline-primary" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $berkasCetak->links() }}
                            @else
                                <div class="alert alert-secondary text-center">
                                    <i class="fas fa-inbox"></i> Belum ada dokumen yang dicetak
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }
</style>
@endsection

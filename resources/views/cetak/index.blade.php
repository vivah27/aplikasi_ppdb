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
                        <!-- Status Pembayaran -->
                        @php
                            // Check pembayaran status - admin verifikasi set status = "Terverifikasi" di kolom status
                            $pembayaranLunas = false;
                            
                            // DEBUG: Force load pembayaran if not already loaded
                            if ($pendaftaran && !$pendaftaran->relationLoaded('pembayaran')) {
                                $pendaftaran->load('pembayaran.statusPembayaran');
                            }
                            
                            if ($pendaftaran && $pendaftaran->pembayaran) {
                                $pembayaran = $pendaftaran->pembayaran;
                                // Check status field (from admin verification) - case insensitive
                                if ($pembayaran->status && strtoupper(trim($pembayaran->status)) === 'TERVERIFIKASI') {
                                    $pembayaranLunas = true;
                                }
                                // Also check statusPembayaran relationship if exists
                                elseif ($pembayaran->statusPembayaran && in_array(strtoupper($pembayaran->statusPembayaran->nama ?? ''), ['LUNAS', 'TERVERIFIKASI'])) {
                                    $pembayaranLunas = true;
                                }
                            }
                            
                            $pembayaranStatus = $pendaftaran && $pendaftaran->pembayaran ? ($pendaftaran->pembayaran->status ?? 'MENUNGGU VERIFIKASI') : 'TIDAK ADA';
                        @endphp
                        <div class="alert {{ $pembayaranLunas ? 'alert-success' : 'alert-warning' }} mb-4">
                            <strong>Status Pembayaran:</strong> 
                            <span class="badge {{ $pembayaranLunas ? 'bg-success' : 'bg-warning' }}">
                                {{ strtoupper($pembayaranStatus) }}
                            </span>
                            @if(!$pembayaranLunas && $pendaftaran->pembayaran)
                                <br>
                                <small>Menunggu verifikasi dari admin. Silakan hubungi admin untuk verifikasi pembayaran Anda.</small>
                            @elseif(!$pendaftaran->pembayaran)
                                <br>
                                <small>Anda belum membuat pembayaran. <a href="{{ route('user.pembayaran.create') }}">Lakukan pembayaran sekarang</a></small>
                            @elseif($pembayaranLunas)
                                <br>
                                <small class="text-success"><i class="fas fa-check-circle"></i> Pembayaran Anda telah diverifikasi oleh admin!</small>
                            @endif
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
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-receipt fa-3x text-info mb-3"></i>
                                        <h6>Kuitansi Pembayaran</h6>
                                        <p class="text-muted small">
                                            @if($pembayaranLunas)
                                                Cetak bukti pembayaran
                                            @else
                                                (Hanya untuk pembayaran terverifikasi)
                                            @endif
                                        </p>
                                        @if($pembayaranLunas && $pendaftaran->pembayaran)
                                            <a href="{{ route('cetak.kuitansi', ['pembayaranId' => $pendaftaran->pembayaran->id]) }}" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-print"></i> Tampilkan
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled title="Pembayaran belum diverifikasi admin">
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

@extends('layouts.master')

@section('page_title', 'Detail Gelombang')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.gelombang.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <h1 class="h3 mb-0 text-gray-800">Detail {{ $gelombang->nama_gelombang }}</h1>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Tanggal Buka</small></p>
                    <p class="fw-bold">{{ $gelombang->tanggal_buka->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Tanggal Tutup</small></p>
                    <p class="fw-bold">{{ $gelombang->tanggal_tutup->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Harga</small></p>
                    <p class="fw-bold text-success">Rp {{ number_format($gelombang->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Status</small></p>
                    <p>
                        @if($gelombang->isOpen())
                            <span class="badge bg-success">Aktif & Buka</span>
                        @elseif($gelombang->is_active)
                            <span class="badge bg-warning">Belum/Sudah Ditutup</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Pendaftar {{ $gelombang->nama_gelombang }} ({{ $pendaftaran->total() }} orang)</h5>
        </div>
        <div class="card-body">
            @if($pendaftaran->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama</th>
                                <th width="15%">NISN</th>
                                <th width="15%">Jurusan</th>
                                <th width="20%">Status</th>
                                <th width="15%">Tanggal Daftar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftaran as $key => $item)
                                <tr>
                                    <td>{{ ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() + $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->siswa->nama_lengkap ?? $item->pengguna->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        {{ $item->siswa->nisn ?? $item->biodata->nisn ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->jurusan->nama_jurusan ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($item->status_pendaftaran ?? '') {
                                                'Diterima' => 'success',
                                                'Ditolak' => 'danger',
                                                'Menunggu' => 'warning',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ $item->status_pendaftaran ?? 'Menunggu' }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $item->created_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.siswa.show', $item) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <nav>
                    {{ $pendaftaran->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada pendaftar untuk gelombang ini
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

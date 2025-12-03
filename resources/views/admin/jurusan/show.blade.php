@extends('layouts.master')

@section('page_title', 'Detail Jurusan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <h1 class="h3 mb-0 text-gray-800">Detail {{ $jurusan->nama_jurusan }}</h1>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Kode Jurusan</small></p>
                    <p class="fw-bold"><code>{{ $jurusan->kode_jurusan }}</code></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Kuota</small></p>
                    <p class="fw-bold">{{ $jurusan->kuota }} orang</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Pendaftar</small></p>
                    <p class="fw-bold text-info">{{ $pendaftar->total() }} orang</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Status</small></p>
                    <p>
                        @if($jurusan->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($jurusan->deskripsi)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-2">Deskripsi</h6>
                <p>{{ $jurusan->deskripsi }}</p>
            </div>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Pendaftar Jurusan {{ $jurusan->nama_jurusan }} ({{ $pendaftar->total() }} orang)</h5>
        </div>
        <div class="card-body">
            @if($pendaftar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama</th>
                                <th width="15%">NISN</th>
                                <th width="15%">Gelombang</th>
                                <th width="20%">Status</th>
                                <th width="15%">Tanggal Daftar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar as $key => $item)
                                <tr>
                                    <td>{{ ($pendaftar->currentPage() - 1) * $pendaftar->perPage() + $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->siswa->nama_lengkap ?? $item->pengguna->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        {{ $item->siswa->nisn ?? $item->biodata->nisn ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">Gelombang {{ $item->gelombang ?? '-' }}</span>
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
                    {{ $pendaftar->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada pendaftar untuk jurusan ini
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

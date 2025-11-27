@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Data Pendaftaran
                </h2>
            </div>
            <div class="col-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.pendaftaran.export') }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama/nomor pendaftaran..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @forelse($statusList ?? [] as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->label }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="jalur" class="form-select">
                            <option value="">Semua Jalur</option>
                            <option value="reguler" {{ request('jalur') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="prestasi" {{ request('jalur') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="afirmasi" {{ request('jalur') == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun" class="form-select">
                            <option value="">Tahun Ajaran</option>
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}/{{ $i+1 }}" {{ request('tahun') == "$i/".($i+1) ? 'selected' : '' }}>
                                    {{ $i }}/{{ $i+1 }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row row-deck row-cards mb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h3">{{ $totalPendaftaran ?? 0 }}</div>
                        <div class="text-muted">Total Pendaftaran</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h3 text-success">{{ $diterima ?? 0 }}</div>
                        <div class="text-muted">Diterima</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h3 text-warning">{{ $menunggu ?? 0 }}</div>
                        <div class="text-muted">Menunggu Verifikasi</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h3 text-danger">{{ $ditolak ?? 0 }}</div>
                        <div class="text-muted">Ditolak</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Jalur</th>
                            <th>Jurusan Pilihan</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran ?? [] as $item)
                            <tr>
                                <td>
                                    <span class="font-monospace">{{ $item->nomor_pendaftaran }}</span>
                                </td>
                                <td>
                                    <div class="font-weight-medium">{{ $item->siswa->nama_lengkap ?? '-' }}</div>
                                    <div class="text-muted text-sm">{{ $item->pengguna->email ?? '-' }}</div>
                                </td>
                                <td>{{ $item->siswa->nisn ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-blue">{{ $item->jalur_pendaftaran ?? '-' }}</span>
                                </td>
                                <td>
                                    <div class="text-sm">{{ $item->jurusanPilihan1->nama ?? '-' }}</div>
                                    @if($item->jurusan_pilihan_2)
                                        <div class="text-muted text-sm">{{ $item->jurusanPilihan2->nama ?? '-' }}</div>
                                    @endif
                                </td>
                                <td>{{ $item->tanggal_daftar?->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    @switch($item->statusPendaftaran->kode ?? 'pending')
                                        @case('accepted')
                                            <span class="badge bg-success">Diterima</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $item->statusPendaftaran->label ?? '-' }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="font-monospace">{{ $item->rata_nilai ?? '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.pendaftaran.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pendaftaran.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">Belum ada data pendaftaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pendaftaran ?? null)
                <div class="card-footer d-flex align-items-center">
                    {{ $pendaftaran->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

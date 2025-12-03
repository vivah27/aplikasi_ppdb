@extends('layouts.master')

@section('page_title', 'Daftar Siswa')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <i class="fas fa-users" style="margin-right: 10px;"></i>Daftar Siswa Pendaftar
                    </h2>
                    <div class="text-muted mt-1">
                        Total: <strong>{{ $siswa->total() }}</strong> siswa
                        @if ($gelombang)
                            di Gelombang <strong>{{ $gelombang }}</strong>
                        @endif
                        @if ($search)
                            | Pencarian: <strong>"{{ $search }}"</strong>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('admin.siswa.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Gelombang</label>
                        <select name="gelombang" class="form-select">
                            <option value="">-- Semua Gelombang --</option>
                            @foreach ($gelombangList as $gb)
                                <option value="{{ $gb }}" {{ $gelombang == $gb ? 'selected' : '' }}>
                                    Gelombang {{ $gb }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cari Siswa</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama atau NISN..." value="{{ $search }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Gelombang</th>
                            <th>Jurusan Pilihan</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                                <td>
                                    <div class="font-weight-medium">{{ $item->nama_lengkap }}</div>
                                    <div class="text-muted text-sm">{{ $item->asal_sekolah ?? '-' }}</div>
                                </td>
                                <td class="font-monospace">{{ $item->nisn }}</td>
                                <td>
                                    @php
                                        $pendaftaran = $item->pendaftaran()->first();
                                        $gelombangColors = [
                                            1 => 'bg-primary',
                                            2 => 'bg-success', 
                                            3 => 'bg-danger',
                                            4 => 'bg-warning',
                                        ];
                                        $badgeColor = $gelombangColors[$pendaftaran?->gelombang] ?? 'bg-secondary';
                                    @endphp
                                    @if ($pendaftaran)
                                        <span class="badge {{ $badgeColor }} text-white">Gelombang {{ $pendaftaran->gelombang }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                    @endphp
                                    @if ($pendaftaran?->jurusanPilihan1)
                                        <span class="badge bg-info text-white">{{ $pendaftaran->jurusanPilihan1->nama_jurusan }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                    @endphp
                                    @if ($pendaftaran?->statusPendaftaran)
                                        @php
                                            $statusKode = $pendaftaran->statusPendaftaran->kode;
                                            $statusBadge = match($statusKode) {
                                                'diterima' => 'bg-success',
                                                'menunggu' => 'bg-warning',
                                                'ditolak' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusBadge }} text-white">
                                            {{ $pendaftaran->statusPendaftaran->label }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                    @endphp
                                    @if ($pendaftaran?->tanggal_daftar)
                                        {{ $pendaftaran->tanggal_daftar->format('d M Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                        $status = $pendaftaran?->statusPendaftaran?->kode;
                                    @endphp
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.siswa.show', $item->id) }}" class="btn btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($status === 'menunggu')
                                            <button type="button" class="btn btn-success btn-accept" data-siswa-id="{{ $item->id }}" data-siswa-name="{{ $item->nama_lengkap }}" title="Terima">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-reject" data-siswa-id="{{ $item->id }}" data-siswa-name="{{ $item->nama_lengkap }}" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                    <p>Tidak ada data siswa</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                {{ $siswa->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // Accept student
    document.querySelectorAll('.btn-accept').forEach(btn => {
        btn.addEventListener('click', function() {
            const siswaId = this.dataset.siswaId;
            const siswaName = this.dataset.siswaName;

            Swal.fire({
                title: 'Terima Pendaftar?',
                html: `<strong>${siswaName}</strong> akan diterima sebagai siswa baru`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/siswa/${siswaId}/accept`;
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="siswa_id" value="${siswaId}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Reject student
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const siswaId = this.dataset.siswaId;
            const siswaName = this.dataset.siswaName;

            Swal.fire({
                title: 'Tolak Pendaftar?',
                html: `<strong>${siswaName}</strong> akan ditolak dan tidak diterima`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/siswa/${siswaId}/reject`;
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="siswa_id" value="${siswaId}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

@extends('layouts.master')

@section('page_title', 'Dokumen')

@section('extra_css')
    <style>
        /* Themed centered card to match landing auth style */
        .themed-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .themed-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .themed-card .card-top {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 22px 24px;
        }

        .themed-card .card-top h3 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.2px;
        }

        .themed-card .card-top p {
            margin: 6px 0 0 0;
            opacity: 0.9;
            font-size: 13px;
        }

        .themed-card .card-body {
            padding: 20px;
            background: white;
        }

        .actions-row {
            display:flex;
            gap:12px;
            align-items:center;
            justify-content:flex-end;
        }

        @media (max-width: 768px) {
            .themed-wrapper { padding: 0 12px; }
            .actions-row { justify-content: center; margin-top: 12px; }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title">Kelola Dokumen</h1>
        <p class="page-subtitle">Upload, unduh, dan pantau status verifikasi dokumen pendaftaran Anda</p>
    </div>

    <div class="themed-wrapper">
        <div class="card themed-card mb-4">
            <div class="card-top d-flex align-items-center justify-content-between">
                <div>
                    <h3>Kelola Dokumen Pendaftaran</h3>
                    <p>Kelola dokumen pendukung pendaftaran dengan mudah dan aman.</p>
                </div>
                <div class="actions-row">
                    <a href="{{ route('user.dokumen.create') }}" class="btn btn-primary">
                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Dokumen Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="stat-card primary">
                            <div>
                                <div class="stat-value">{{ count($dokumen) ?? 0 }}</div>
                                <div class="stat-label">Total Dokumen</div>
                            </div>
                            <div class="stat-icon primary"><i class="fas fa-file-alt"></i></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="stat-card success">
                            <div>
                                <div class="stat-value">{{ $dokumen->where('status_verifikasi_id', 1)->count() ?? 0 }}</div>
                                <div class="stat-label">Terverifikasi</div>
                            </div>
                            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="stat-card warning">
                            <div>
                                <div class="stat-value">{{ $dokumen->whereNull('status_verifikasi_id')->count() ?? 0 }}</div>
                                <div class="stat-label">Menunggu</div>
                            </div>
                            <div class="stat-icon warning"><i class="fas fa-hourglass-half"></i></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="stat-card danger">
                            <div>
                                <div class="stat-value">{{ $dokumen->where('status_verifikasi_id', 3)->count() ?? 0 }}</div>
                                <div class="stat-label">Ditolak</div>
                            </div>
                            <div class="stat-icon danger"><i class="fas fa-times-circle"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('user.dokumen.index') }}" method="GET" class="row g-2">
                            <div class="col-md-4">
                                <select name="jenis" class="form-select">
                                    <option value="">Semua Jenis Dokumen</option>
                                    @forelse($jenisDokumen ?? [] as $jenis)
                                        <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Tertunda</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="revision" {{ request('status') == 'revision' ? 'selected' : '' }}>Revisi</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('user.dokumen.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Documents Table -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumen ?? [] as $item)
                                    <tr>
                                        <td>{{ ($dokumen->currentPage() - 1) * $dokumen->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="font-weight-medium">{{ $item->jenisDokumen->nama }}</div>
                                            @if($item->jenisDokumen->wajib)
                                                <span class="badge badge-danger">Wajib</span>
                                            @else
                                                <span class="badge badge-secondary">Opsional</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($item->statusVerifikasi)
                                                @php $k = $item->statusVerifikasi->kode; @endphp
                                                @if($k === 'verified')
                                                    <span class="badge badge-success"><i class="fas fa-check"></i> Terverifikasi</span>
                                                @elseif($k === 'pending')
                                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Tertunda</span>
                                                @elseif($k === 'rejected')
                                                    <span class="badge badge-danger"><i class="fas fa-times"></i> Ditolak</span>
                                                @elseif($k === 'revision')
                                                    <span class="badge badge-info"><i class="fas fa-edit"></i> Revisi</span>
                                                @endif
                                            @else
                                                <span class="badge badge-secondary">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->catatan)
                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#catatanModal{{ $item->id }}">
                                                    <i class="fas fa-sticky-note"></i> Lihat
                                                </button>
                                                <!-- Catatan Modal -->
                                                <div class="modal fade" id="catatanModal{{ $item->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Catatan untuk {{ $item->jenisDokumen->nama }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $item->catatan }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('user.dokumen.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.dokumen.download', $item->id) }}" class="btn btn-sm btn-success" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @if(in_array(optional($item->statusVerifikasi)->kode, ['rejected', 'revision']))
                                                <form action="{{ route('user.dokumen.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus dokumen ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">
                                            <p>Belum ada dokumen yang diunggah</p>
                                            <a href="{{ route('user.dokumen.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Upload Dokumen
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($dokumen ?? null)
                        <div class="card-footer d-flex align-items-center">
                            {{ $dokumen->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

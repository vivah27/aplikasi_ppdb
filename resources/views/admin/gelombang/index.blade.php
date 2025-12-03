@extends('layouts.master')

@section('page_title', 'Atur Gelombang')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Atur Gelombang</h1>
        <a href="{{ route('admin.gelombang.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Gelombang
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

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-3" id="gelombangTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab">
                <i class="fas fa-calendar-alt me-2"></i>Jadwal Gelombang
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="harga-tab" data-bs-toggle="tab" data-bs-target="#harga" type="button" role="tab">
                <i class="fas fa-money-bill-wave me-2"></i>Atur Harga & Pembayaran
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="gelombangTabsContent">
        <!-- Jadwal Gelombang Tab -->
        <div class="tab-pane fade show active" id="jadwal" role="tabpanel" aria-labelledby="jadwal-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-wave-square me-2"></i>Daftar Gelombang</h5>
                </div>
                <div class="card-body">
                    @if($gelombang->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="8%">No</th>
                                        <th width="15%">Gelombang</th>
                                        <th width="20%">Tanggal Buka</th>
                                        <th width="20%">Tanggal Tutup</th>
                                        <th width="12%">Harga</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gelombang as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->nama_gelombang }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $item->tanggal_buka->format('d M Y H:i') }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $item->tanggal_tutup->format('d M Y H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($item->harga)
                                                    <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->is_active)
                                                    @if($item->isOpen())
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-warning">Belum/Sudah Ditutup</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.gelombang.show', $item) }}" class="btn btn-sm btn-info" title="Lihat Pendaftar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.gelombang.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.gelombang.destroy', $item) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus? {{ $item->hasPendaftar() ? 'Gelombang ini memiliki pendaftar!' : '' }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Belum ada gelombang. <a href="{{ route('admin.gelombang.create') }}" class="alert-link">Buat gelombang baru</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Harga & Pembayaran Tab -->
        <div class="tab-pane fade" id="harga" role="tabpanel" aria-labelledby="harga-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Atur Harga & Metode Pembayaran</h5>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>Konfigurasi ini akan ditampilkan kepada user saat pendaftaran dan pembayaran
                    </small>
                </div>
                <div class="card-body">
                    @if($gelombang->count() > 0)
                        <form action="{{ route('admin.harga-gelombang.update') }}" method="POST">
                            @csrf

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="12%"><i class="fas fa-wave-square me-2"></i>Gelombang</th>
                                            <th width="25%"><i class="fas fa-tag me-2"></i>Jenis Pembayaran</th>
                                            <th width="20%"><i class="fas fa-money-bill-wave me-2"></i>Harga (Rp)</th>
                                            <th width="20%"><i class="fas fa-bank me-2"></i>Tujuan Rekening</th>
                                            <th width="23%" class="text-center"><i class="fas fa-cog me-2"></i>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gelombang as $item)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $item->nama_gelombang }}</span>
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           name="jenis_pembayaran[{{ $item->id }}]" 
                                                           class="form-control" 
                                                           value="{{ old('jenis_pembayaran.' . $item->id, $item->jenis_pembayaran ?? 'Uang Pendaftaran') }}"
                                                           placeholder="Contoh: Uang Pendaftaran">
                                                    @error('jenis_pembayaran.' . $item->id)
                                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" 
                                                               name="harga[{{ $item->id }}]" 
                                                               class="form-control text-end" 
                                                               value="{{ old('harga.' . $item->id, $item->harga ?? 0) }}"
                                                               placeholder="0"
                                                               step="1000"
                                                               min="0">
                                                    </div>
                                                    @error('harga.' . $item->id)
                                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           name="tujuan_rekening[{{ $item->id }}]" 
                                                           class="form-control" 
                                                           value="{{ old('tujuan_rekening.' . $item->id, $item->tujuan_rekening ?? '') }}"
                                                           placeholder="Contoh: Bank BNI No. 12345678 (a.n. Sekolah)">
                                                    @error('tujuan_rekening.' . $item->id)
                                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                    @enderror
                                                    <small class="text-muted d-block mt-1">Akan ditampilkan readonly untuk user</small>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.siswa.index', ['gelombang' => $item->nomor_gelombang]) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Lihat Siswa">
                                                        <i class="fas fa-users me-1"></i>Lihat Siswa
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid gap-2 gap-md-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Konfigurasi Gelombang
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                                </a>
                            </div>
                        </form>

                        <!-- Info Box -->
                        <div class="alert alert-info mt-4">
                            <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Catatan Penting</h6>
                            <ul class="mb-0">
                                <li>Pastikan semua data sudah benar sebelum menyimpan</li>
                                <li>Jenis pembayaran akan ditampilkan dalam formulir pembayaran user</li>
                                <li>Tujuan rekening akan ditampilkan sebagai read-only untuk user saat melakukan pembayaran</li>
                                <li>Harga akan otomatis ditampilkan berdasarkan gelombang aktif yang dipilih user</li>
                                <li>Pastikan ada satu gelombang dengan status "Aktif" agar user bisa mendaftar</li>
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-warning me-2"></i>
                            <strong>Belum ada data gelombang</strong>
                            <p class="mb-0 mt-2">Harap membuat gelombang terlebih dahulu di tab "Jadwal Gelombang".</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border: none;
        font-weight: 600;
        color: #5a6c7d;
        background-color: #f8f9fa;
        padding: 15px 12px;
    }

    .table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        font-weight: 600;
    }

    .form-control, .input-group-text {
        border-radius: 6px;
    }

    input.form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 0.75rem 1rem;
        font-weight: 500;
    }

    .nav-tabs .nav-link:hover {
        color: #4f46e5;
        border-bottom-color: #e9ecef;
    }

    .nav-tabs .nav-link.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
        background-color: transparent;
    }
</style>
@endsection

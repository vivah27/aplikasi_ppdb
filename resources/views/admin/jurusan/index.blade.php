@extends('layouts.master')

@section('page_title', 'Kelola Jurusan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Jurusan</h1>
        <a href="{{ route('admin.jurusan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jurusan
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

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Jurusan</h5>
        </div>
        <div class="card-body">
            @if($jurusan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="8%">No</th>
                                <th width="12%">Kode</th>
                                <th width="25%">Nama Jurusan</th>
                                <th width="12%">Kuota</th>
                                <th width="15%">Pendaftar</th>
                                <th width="10%">Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jurusan as $key => $item)
                                <tr>
                                    <td>{{ ($jurusan->currentPage() - 1) * $jurusan->perPage() + $key + 1 }}</td>
                                    <td>
                                        <code>{{ $item->kode_jurusan }}</code>
                                    </td>
                                    <td>
                                        <strong>{{ $item->nama_jurusan }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->kuota }} orang</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->pendaftarans()->count() }} orang</span>
                                    </td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.jurusan.show', $item) }}" class="btn btn-sm btn-info" title="Lihat Pendaftar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.jurusan.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!$item->pendaftarans()->exists())
                                            <form action="{{ route('admin.jurusan.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <nav>
                    {{ $jurusan->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada jurusan. <a href="{{ route('admin.jurusan.create') }}" class="alert-link">Buat jurusan baru</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

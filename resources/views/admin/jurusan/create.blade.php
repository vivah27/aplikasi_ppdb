@extends('layouts.master')

@section('page_title', 'Tambah Jurusan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <h1 class="h3 mb-0 text-gray-800">Tambah Jurusan</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.jurusan.store') }}" method="POST">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="kode_jurusan" class="form-label">
                            Kode Jurusan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control @error('kode_jurusan') is-invalid @enderror"
                               placeholder="Contoh: RPL, TSM" value="{{ old('kode_jurusan') }}" required>
                        @error('kode_jurusan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama_jurusan" class="form-label">
                            Nama Jurusan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror"
                               placeholder="Contoh: Rekayasa Perangkat Lunak" value="{{ old('nama_jurusan') }}" required>
                        @error('nama_jurusan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="kuota" class="form-label">
                            Kuota <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="kuota" id="kuota" class="form-control @error('kuota') is-invalid @enderror"
                               placeholder="Contoh: 40" value="{{ old('kuota') }}" min="1" required>
                        @error('kuota')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                                   value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan jurusan ini
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                              placeholder="Deskripsi jurusan" rows="4">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

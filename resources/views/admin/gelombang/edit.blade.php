@extends('layouts.master')

@section('page_title', 'Edit Gelombang')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.gelombang.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <h1 class="h3 mb-0 text-gray-800">Edit Gelombang</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.gelombang.update', $gelombang) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nama_gelombang" class="form-label">
                            Nama Gelombang <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_gelombang" id="nama_gelombang" class="form-control @error('nama_gelombang') is-invalid @enderror"
                               placeholder="Contoh: Gelombang 1" value="{{ old('nama_gelombang', $gelombang->nama_gelombang) }}" required>
                        @error('nama_gelombang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nomor_gelombang" class="form-label">
                            Nomor Gelombang <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="nomor_gelombang" id="nomor_gelombang" class="form-control @error('nomor_gelombang') is-invalid @enderror"
                               placeholder="Contoh: 1" value="{{ old('nomor_gelombang', $gelombang->nomor_gelombang) }}" required>
                        @error('nomor_gelombang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="tanggal_buka" class="form-label">
                            Tanggal Buka <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_buka" id="tanggal_buka" class="form-control @error('tanggal_buka') is-invalid @enderror"
                               value="{{ old('tanggal_buka', $gelombang->tanggal_buka->format('Y-m-d\TH:i')) }}" required>
                        @error('tanggal_buka')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_tutup" class="form-label">
                            Tanggal Tutup <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_tutup" id="tanggal_tutup" class="form-control @error('tanggal_tutup') is-invalid @enderror"
                               value="{{ old('tanggal_tutup', $gelombang->tanggal_tutup->format('Y-m-d\TH:i')) }}" required>
                        @error('tanggal_tutup')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="harga" class="form-label">Harga Pendaftaran</label>
                        <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror"
                               placeholder="Contoh: 50000000" value="{{ old('harga', $gelombang->harga) }}" min="0">
                        @error('harga')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                        <input type="text" name="jenis_pembayaran" id="jenis_pembayaran" class="form-control @error('jenis_pembayaran') is-invalid @enderror"
                               placeholder="Contoh: Uang Pendaftaran" value="{{ old('jenis_pembayaran', $gelombang->jenis_pembayaran) }}">
                        @error('jenis_pembayaran')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="tujuan_rekening" class="form-label">Tujuan Rekening (Bank Account)</label>
                    <textarea name="tujuan_rekening" id="tujuan_rekening" class="form-control @error('tujuan_rekening') is-invalid @enderror"
                              placeholder="Masukkan informasi rekening bank" rows="3">{{ old('tujuan_rekening', $gelombang->tujuan_rekening) }}</textarea>
                    <small class="text-muted">Format: Bank BCA No.0125251 (Nama Pemilik)</small>
                    @error('tujuan_rekening')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                               value="1" {{ old('is_active', $gelombang->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktifkan gelombang ini
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Perbarui
                    </button>
                    <a href="{{ route('admin.gelombang.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

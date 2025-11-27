@extends('layouts.master')

@section('page_title', 'Tambah Peran')

@section('content')
<style>
    .form-header {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
    }
    .form-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }
    .form-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 8px 0 0 0;
    }
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 30px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .form-group input.is-invalid,
    .form-group textarea.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }
    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-back {
        background: #f3f4f6;
        color: #1f2937;
    }
    .btn-back:hover {
        background: #e5e7eb;
    }
    .btn-submit {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        margin-left: auto;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #991b1b;
    }
    .alert-danger strong {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
    .alert-danger li {
        margin: 4px 0;
    }
</style>

<div class="form-header">
    <h1>Tambah Peran Baru</h1>
    <p>Buat peran pengguna baru untuk sistem</p>
</div>

<div class="form-card" style="max-width: 600px; margin: 0 auto;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Validasi Gagal!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.peran.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Peran <span style="color: #ef4444;">*</span></label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" 
                   placeholder="contoh: admin, guru, siswa" required
                   class="@error('nama') is-invalid @enderror">
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="5"
                      placeholder="Jelaskan deskripsi dan tanggung jawab peran ini"
                      class="@error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.peran.index') }}" class="btn btn-back">
                ← Kembali
            </a>
            <button type="submit" class="btn btn-submit">
                ✓ Simpan Peran
            </button>
        </div>
    </form>
</div>
@endsection

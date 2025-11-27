@extends('layouts.master')

@section('page_title', 'Profil Siswa Baru')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Profil Siswa Baru</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="fw-bold mb-3 text-primary"> Data Pribadi</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? $siswa->nama_lengkap ?? '') }}" placeholder="Masukkan nama lengkap" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NISN</label>
                        <input type="text" class="form-control" name="nisn" value="{{ old('nisn', $biodata->nisn ?? $siswa->nisn ?? '') }}" placeholder="Masukkan NISN" required>
                        @error('nisn')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NIK</label>
                        <input type="text" id="nik" class="form-control" name="nik" value="{{ old('nik', $biodata->nik ?? $siswa->nik ?? '') }}" placeholder="Masukkan NIK" required>
                        <div id="nik-error" class="invalid-feedback d-none"></div>
                        @error('nik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? $siswa->tempat_lahir ?? '') }}" placeholder="Contoh: Sidoarjo" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? $siswa->tanggal_lahir ?? '') }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? $siswa->jenis_kelamin ?? '') == 'Laki-laki' || old('jenis_kelamin', $biodata->jenis_kelamin ?? $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? $siswa->jenis_kelamin ?? '') == 'Perempuan' || old('jenis_kelamin', $biodata->jenis_kelamin ?? $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Agama</label>
                        <select class="form-select" name="agama" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama', $biodata->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat" rows="2" placeholder="Tuliskan alamat lengkap sesuai KK" required>{{ old('alamat', $biodata->alamat ?? $siswa->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. HP Siswa</label>
                        <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $biodata->no_hp ?? $siswa->no_telepon ?? '') }}" placeholder="08xxxxxxxxxx" required>
                        @error('no_hp')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold mb-3 text-primary"> Data Orang Tua / Wali</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" name="nama_ayah" value="{{ old('nama_ayah', $biodata->nama_ayah ?? '') }}" required>
                        @error('nama_ayah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $biodata->pekerjaan_ayah ?? '') }}" required>
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu" value="{{ old('nama_ibu', $biodata->nama_ibu ?? '') }}" required>
                        @error('nama_ibu')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $biodata->pekerjaan_ibu ?? '') }}" required>
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Wali (Opsional)</label>
                        <input type="text" class="form-control" name="nama_wali" value="{{ old('nama_wali', $biodata->nama_wali ?? '') }}">
                        @error('nama_wali')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. HP Orang Tua/Wali</label>
                        <input type="text" class="form-control" name="no_hp_wali" value="{{ old('no_hp_wali', $biodata->no_hp_wali ?? '') }}" placeholder="08xxxxxxxxxx" required>
                        @error('no_hp_wali')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold mb-3 text-primary">Data Sekolah Asal</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Sekolah Asal</label>
                        <input type="text" class="form-control" name="asal_sekolah" value="{{ old('asal_sekolah', $biodata->asal_sekolah ?? $siswa->asal_sekolah ?? '') }}" required>
                        @error('asal_sekolah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NPSN Sekolah</label>
                        <input type="text" class="form-control" name="npsn" value="{{ old('npsn', $biodata->npsn ?? '') }}" placeholder="(jika ada)">
                        @error('npsn')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun Lulus</label>
                        <input type="text" class="form-control" name="tahun_lulus" value="{{ old('tahun_lulus', $biodata->tahun_lulus ?? '') }}" placeholder="Contoh: 2025" required>
                        @error('tahun_lulus')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold mb-3 text-primary">Upload Foto</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Foto Diri</label>
                        <input type="file" class="form-control" name="foto" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Maksimal 2MB | Format JPG/PNG</small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 text-center">
                        <img id="preview" src="#" alt="Preview Foto" class="img-thumbnail mt-2" style="max-width: 200px; display:none;">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<script>
// Client-side NIK validation: numeric and 16 digits (Indonesia NIK standard)
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="{{ route('biodata.store') }}"]');
    const nikInput = document.getElementById('nik');
    const nikErrorEl = document.getElementById('nik-error');

    if (!form || !nikInput) return;

    form.addEventListener('submit', function (e) {
        const val = (nikInput.value || '').trim();
        const onlyDigits = /^[0-9]+$/.test(val);
        if (!onlyDigits || val.length !== 16) {
            e.preventDefault();
            nikErrorEl.textContent = 'NIK harus berisi 16 digit angka.';
            nikErrorEl.classList.remove('d-none');
            nikErrorEl.classList.add('d-block');
            nikInput.focus();
            return false;
        }
        // hide error if valid
        nikErrorEl.classList.remove('d-block');
        nikErrorEl.classList.add('d-none');
    });
});
</script>
@endsection

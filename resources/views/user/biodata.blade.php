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

    <!-- Alert Error Merah jika Formulir belum diisi -->
    @if($formulirBelumDiisi)
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>⚠️ Perhatian!</strong><br>
            Anda belum mengisi <strong>Formulir Pendaftaran</strong>. Silakan <a href="{{ route('formulir.index') }}" class="alert-link fw-bold">isi Formulir Pendaftaran terlebih dahulu</a> sebelum melanjutkan ke biodata.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Info Box untuk Urutan -->
    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <strong>✅ Langkah 2 dari 3:</strong> Sekarang isi biodata pribadi Anda
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if($isSubmitted)
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Data Sudah Tersimpan!</strong> Data biodata Anda sudah disimpan. Anda hanya bisa melihat data yang sudah diisi.
                    Jika perlu mengubah, silakan hubungi admin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="fw-bold mb-3 text-primary"> Data Pribadi</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? $siswa->nama_lengkap ?? '') }}" placeholder="Masukkan nama lengkap" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya huruf dan spasi</small>
                        @error('nama_lengkap')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NISN</label>
                        <input type="text" class="form-control" name="nisn" id="nisn" value="{{ old('nisn', $biodata->nisn ?? $siswa->nisn ?? '') }}" placeholder="Masukkan NISN" pattern="[0-9]*" inputmode="numeric" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya angka (10 digit)</small>
                        @error('nisn')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NIK</label>
                        <input type="text" id="nik" class="form-control" name="nik" value="{{ old('nik', $biodata->nik ?? $siswa->nik ?? '') }}" placeholder="Masukkan NIK" pattern="[0-9]*" inputmode="numeric" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya angka (16 digit)</small>
                        <div id="nik-error" class="invalid-feedback d-none"></div>
                        @error('nik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? $siswa->tempat_lahir ?? '') }}" placeholder="Contoh: Sidoarjo" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya huruf dan spasi</small>
                        @error('tempat_lahir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" {{ $isSubmitted ? 'readonly' : 'required' }} value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? $siswa->tanggal_lahir ?? '') }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis_kelamin" {{ $isSubmitted ? 'disabled' : 'required' }}>
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
                        <select class="form-select" name="agama" {{ $isSubmitted ? 'disabled' : 'required' }}>
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
                        <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Tuliskan alamat lengkap sesuai KK" {{ $isSubmitted ? 'readonly' : 'required' }}>{{ old('alamat', $biodata->alamat ?? $siswa->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. HP Siswa</label>
                        <input type="tel" class="form-control" name="no_hp" id="no_hp" value="{{ old('no_hp', $biodata->no_hp ?? $siswa->no_telepon ?? '') }}" placeholder="08xxxxxxxxxx" pattern="[0-9]+" inputmode="numeric" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya angka, contoh: 08xxxxxxxxxx</small>
                        @error('no_hp')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold mb-3 text-primary">Data Orang Tua / Wali</h5>
                
                <!-- Toggle untuk memilih antara Orang Tua atau Wali -->
                <div class="mb-4">
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="jenis_pendamping" id="ortu_option" value="ortu" 
                               {{ old('jenis_pendamping', ($biodata->nama_ayah ?? null) ? 'ortu' : 'wali') == 'ortu' ? 'checked' : '' }}
                               {{ $isSubmitted ? 'disabled' : '' }}>
                        <label class="btn btn-outline-primary" for="ortu_option">
                            <i class="fas fa-users me-2"></i>Orang Tua (Ayah & Ibu)
                        </label>
                        
                        <input type="radio" class="btn-check" name="jenis_pendamping" id="wali_option" value="wali"
                               {{ old('jenis_pendamping', ($biodata->nama_ayah ?? null) ? 'ortu' : 'wali') == 'wali' ? 'checked' : '' }}
                               {{ $isSubmitted ? 'disabled' : '' }}>
                        <label class="btn btn-outline-primary" for="wali_option">
                            <i class="fas fa-user-tie me-2"></i>Wali
                        </label>
                    </div>
                    <small class="text-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i>Pilih salah satu: Isi data Orang Tua ATAU data Wali, tidak keduanya</small>
                </div>

                <!-- Bagian Data Orang Tua -->
                <div id="ortu_section" class="mb-4">
                    <h6 class="fw-bold text-info mb-3"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" class="form-control ortu-field" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $biodata->nama_ayah ?? '') }}" placeholder="Masukkan nama ayah" {{ $isSubmitted ? 'readonly' : '' }}>
                            <small class="text-muted">Hanya huruf dan spasi</small>
                            @error('nama_ayah')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" class="form-control ortu-field" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $biodata->pekerjaan_ayah ?? '') }}" placeholder="Masukkan pekerjaan ayah" {{ $isSubmitted ? 'readonly' : '' }}>
                            <small class="text-muted">Hanya huruf dan spasi</small>
                            @error('pekerjaan_ayah')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" class="form-control ortu-field" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $biodata->nama_ibu ?? '') }}" placeholder="Masukkan nama ibu" {{ $isSubmitted ? 'readonly' : '' }}>
                            <small class="text-muted">Hanya huruf dan spasi</small>
                            @error('nama_ibu')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" class="form-control ortu-field" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $biodata->pekerjaan_ibu ?? '') }}" placeholder="Masukkan pekerjaan ibu" {{ $isSubmitted ? 'readonly' : '' }}>
                            <small class="text-muted">Hanya huruf dan spasi</small>
                            @error('pekerjaan_ibu')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Bagian Data Wali -->
                <div id="wali_section" class="mb-4" style="display: none;">
                    <h6 class="fw-bold text-info mb-3"><i class="fas fa-user-tie me-2"></i>Data Wali</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Wali <span class="text-danger">*</span></label>
                            <input type="text" class="form-control wali-field" name="nama_wali" id="nama_wali" value="{{ old('nama_wali', $biodata->nama_wali ?? '') }}" placeholder="Masukkan nama wali" {{ $isSubmitted ? 'readonly' : '' }}>
                            <small class="text-muted">Hanya huruf dan spasi</small>
                            @error('nama_wali')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- No. HP (Dinamis sesuai pilihan) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" id="no_hp_label">No. HP Orang Tua</label>
                        <input type="text" class="form-control" name="no_hp_wali" id="no_hp_wali" value="{{ old('no_hp_wali', $biodata->no_hp_wali ?? '') }}" placeholder="08xxxxxxxxxx" inputmode="numeric" {{ $isSubmitted ? 'readonly' : 'required' }}>
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
                        <input type="text" class="form-control" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah', $biodata->asal_sekolah ?? $siswa->asal_sekolah ?? '') }}" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya huruf dan spasi</small>
                        @error('asal_sekolah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NPSN Sekolah</label>
                        <input type="text" class="form-control" name="npsn" id="npsn" value="{{ old('npsn', $biodata->npsn ?? '') }}" placeholder="(jika ada)" pattern="[0-9]*" inputmode="numeric" {{ $isSubmitted ? 'readonly' : '' }}>
                        <small class="text-muted">Hanya angka</small>
                        @error('npsn')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun Lulus</label>
                        <input type="text" class="form-control" name="tahun_lulus" id="tahun_lulus" value="{{ old('tahun_lulus', $biodata->tahun_lulus ?? '') }}" placeholder="Contoh: 2025" pattern="[0-9]{4}" inputmode="numeric" maxlength="4" {{ $isSubmitted ? 'readonly' : 'required' }}>
                        <small class="text-muted">Hanya 4 digit angka</small>
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
                        <input type="file" class="form-control" name="foto" accept="image/*" onchange="previewImage(event)" {{ $isSubmitted ? 'disabled' : '' }}>
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
                    @if(!$isSubmitted)
                        <button type="submit" class="btn btn-primary px-4" {{ $formulirBelumDiisi ? 'disabled' : '' }}>
                            <i class="bi bi-save"></i> Simpan Data
                        </button>
                        @if($formulirBelumDiisi)
                            <small class="text-danger d-block mt-2">
                                <i class="fas fa-lock me-1"></i>Tombol simpan dinonaktifkan sampai Anda isi Formulir Pendaftaran
                            </small>
                        @endif
                    @else
                        <span class="text-muted">
                            <i class="fas fa-check-circle text-success me-2"></i>Data sudah tersimpan
                        </span>
                    @endif
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

// Validasi input real-time untuk field yang hanya boleh huruf
function validateLettersOnly(input) {
    // Hanya izinkan huruf (a-z, A-Z) dan spasi, hapus karakter lain secara real-time
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
}

// Validasi input real-time untuk field yang hanya boleh angka
function validateNumbersOnly(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}

// Setup validasi pada input fields
document.addEventListener('DOMContentLoaded', function () {
    // Fields yang hanya boleh huruf dan spasi
    const lettersOnlyFields = [
        'nama_lengkap', 'tempat_lahir', 
        'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu', 
        'nama_wali', 'asal_sekolah'
    ];
    
    // Fields yang hanya boleh angka
    const numbersOnlyFields = [
        'nisn', 'nik', 'no_hp', 'npsn', 'tahun_lulus'
    ];
    
    // Add real-time validation untuk letters only fields
    lettersOnlyFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                validateLettersOnly(this);
            });
        }
    });
    
    // Add real-time validation untuk numbers only fields
    numbersOnlyFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                validateNumbersOnly(this);
            });
        }
    });

    // Toggle antara Orang Tua dan Wali
    const ortuOption = document.getElementById('ortu_option');
    const waliOption = document.getElementById('wali_option');
    const ortuSection = document.getElementById('ortu_section');
    const waliSection = document.getElementById('wali_section');
    const noHpLabel = document.getElementById('no_hp_label');
    
    // Field-field Orang Tua
    const ortuFields = document.querySelectorAll('.ortu-field');
    const namaAyah = document.getElementById('nama_ayah');
    const pekerjaanAyah = document.getElementById('pekerjaan_ayah');
    const namaIbu = document.getElementById('nama_ibu');
    const pekerjaanIbu = document.getElementById('pekerjaan_ibu');
    
    // Field-field Wali
    const waliFields = document.querySelectorAll('.wali-field');
    const namaWali = document.getElementById('nama_wali');
    const hubunganWali = document.getElementById('hubungan_wali');

    function clearOrtuFields() {
        ortuFields.forEach(field => field.value = '');
    }

    function clearWaliFields() {
        waliFields.forEach(field => field.value = '');
    }

    function disableOrtuFields() {
        ortuFields.forEach(field => {
            field.disabled = true;
            field.required = false;
        });
    }

    function enableOrtuFields() {
        ortuFields.forEach(field => {
            field.disabled = false;
            field.required = true;
        });
    }

    function disableWaliFields() {
        waliFields.forEach(field => {
            field.disabled = true;
            field.required = false;
        });
    }

    function enableWaliFields() {
        waliFields.forEach(field => {
            field.disabled = false;
            field.required = true;
        });
    }

    function updateVisibility() {
        if (ortuOption.checked) {
            // Tampilkan ortu, sembunyikan wali
            ortuSection.style.display = 'block';
            waliSection.style.display = 'none';
            noHpLabel.textContent = 'No. HP Orang Tua';
            
            // Enable ortu fields, disable wali fields
            enableOrtuFields();
            disableWaliFields();
            clearWaliFields();
        } else {
            // Tampilkan wali, sembunyikan ortu
            ortuSection.style.display = 'none';
            waliSection.style.display = 'block';
            noHpLabel.textContent = 'No. HP Wali';
            
            // Enable wali fields, disable ortu fields
            disableOrtuFields();
            enableWaliFields();
            clearOrtuFields();
        }
    }

    function initializeFieldStates() {
        // Jika sudah ada data ortu yang terisi
        if (namaAyah.value || pekerjaanAyah.value || namaIbu.value || pekerjaanIbu.value) {
            ortuOption.checked = true;
            ortuOption.dispatchEvent(new Event('change'));
        }
        // Jika sudah ada data wali yang terisi
        else if (namaWali.value || hubunganWali.value) {
            waliOption.checked = true;
            waliOption.dispatchEvent(new Event('change'));
        }
    }

    ortuOption.addEventListener('change', updateVisibility);
    waliOption.addEventListener('change', updateVisibility);

    // Initialize on page load
    updateVisibility();
    initializeFieldStates();

    // Form validation
    const form = document.querySelector('form[action="{{ route('biodata.store') }}"]');
    if (form) {
        form.addEventListener('submit', function (e) {
            const ortuSelected = ortuOption.checked;
            
            // PENTING: Clear data yang tidak dipilih sebelum submit
            if (ortuSelected) {
                // Hapus data wali
                clearWaliFields();
                
                // Validasi orang tua
                if (!namaAyah.value.trim() || !pekerjaanAyah.value.trim() || 
                    !namaIbu.value.trim() || !pekerjaanIbu.value.trim()) {
                    e.preventDefault();
                    alert('Harap isi semua data Orang Tua (Nama dan Pekerjaan Ayah & Ibu)');
                    return false;
                }
            } else {
                // Hapus data orang tua
                clearOrtuFields();
                
                // Validasi wali
                if (!namaWali.value.trim() || !hubunganWali.value.trim()) {
                    e.preventDefault();
                    alert('Harap isi Nama Wali dan Hubungan dengan Siswa');
                    return false;
                }
            }
        });
    }
});

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

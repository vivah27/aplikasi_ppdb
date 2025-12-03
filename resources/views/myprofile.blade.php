@extends('layouts.master')

@section('page_title', 'Profil Saya')

@section('content')
<div class="page-header mb-3">
    <h1 class="page-title"><i class="fas fa-user-circle me-2"></i>Profil Saya</h1>
    <p class="page-subtitle">Lihat dan perbarui informasi profil Anda</p>
</div>

@php
    $user = auth()->user();
    $siswa = $user ? $user->siswa : null;
    // Biodata passed dari controller - gunakan langsung jika tersedia
    // Gunakan biodata jika tersedia, jika tidak gunakan siswa
    $profileData = ($biodata ?? null) ?? $siswa;
    // ✅ Untuk foto, prioritaskan biodata->foto karena itu sumber kebenaran (single source of truth)
    $fotoDisplay = ($biodata && $biodata->foto) ? $biodata->foto : ($siswa && $siswa->foto ? $siswa->foto : null);
    
    // DEBUG
    \Log::debug('MyProfile Debug', [
        'biodata_exists' => $biodata ? true : false,
        'biodata_foto' => $biodata ? $biodata->foto : null,
        'siswa_exists' => $siswa ? true : false,
        'siswa_foto' => $siswa ? $siswa->foto : null,
        'fotoDisplay' => $fotoDisplay,
    ]);
    
    $dokumenCount = $siswa ? $siswa->dokumen()->count() : 0;
    $pendaftaran = $siswa ? $siswa->pendaftaran()->first() : null;
    $statusPendaftaran = $pendaftaran ? $pendaftaran->statusPendaftaran : null;
@endphp

<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                @if($fotoDisplay)
                    <img src="{{ asset('storage/' . $fotoDisplay) }}" alt="Foto Profil" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover;">
                @elseif($user && $user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover;">
                @else
                    <div class="user-avatar mb-3" style="width:110px;height:110px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;background:#e9ecef;">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                @endif

                <h4 class="mb-0">{{ optional($profileData)->nama_lengkap ?? $user->name ?? 'Pengguna' }}</h4>
                <p class="text-muted">{{ optional($profileData)->nisn ?? '-' }}</p>

                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('profil.edit') }}" class="btn btn-primary"><i class="fas fa-edit me-1"></i>Edit Profil</a>
                    <a href="{{ route('password.change') }}" class="btn btn-outline-secondary"><i class="fas fa-key me-1"></i>Ubah Password</a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3">Ringkasan</h6>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Dokumen</small>
                    <strong>{{ $dokumenCount }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Pendaftaran</small>
                    <strong>{{ optional($pendaftaran)->nomor_pendaftaran ?? '-' }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Status</small>
                    <span class="badge badge-{{ $statusPendaftaran && $statusPendaftaran->label == 'Diterima' ? 'success' : ($statusPendaftaran && $statusPendaftaran->label == 'Menunggu' ? 'warning' : 'secondary') }}">
                        {{ $statusPendaftaran ? $statusPendaftaran->label : 'Belum Daftar' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Tentang Saya</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ optional($siswa)->bio ?? 'Belum ada deskripsi tentang diri.' }}</p>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Detail Personal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <small class="text-muted">Nama Lengkap</small>
                        <div>{{ optional($profileData)->nama_lengkap ?? $user->name ?? '-' }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Email</small>
                        <div>{{ $user->email ?? '-' }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">NISN</small>
                        <div>{{ optional($profileData)->nisn ?? '-' }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">NIK</small>
                        <div>{{ optional($profileData)->nik ?? '-' }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Tempat, Tanggal Lahir</small>
                        <div>
                            @php
                                $tempat = optional($profileData)->tempat_lahir ?? '-';
                                $tanggal = '-';
                                if ($profileData && $profileData->tanggal_lahir) {
                                    $tglLahir = $profileData->tanggal_lahir;
                                    if (is_object($tglLahir) && method_exists($tglLahir, 'format')) {
                                        $tanggal = $tglLahir->format('d M Y');
                                    } else {
                                        $tanggal = $tglLahir;
                                    }
                                }
                            @endphp
                            {{ $tempat . ', ' . $tanggal }}
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Jenis Kelamin</small>
                        <div>{{ optional($profileData)->jenis_kelamin ?? '-' }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Asal Sekolah</small>
                        <div>{{ optional($profileData)->asal_sekolah ?? '-' }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">No. Telepon</small>
                        <div>{{ optional($profileData)->no_hp ?? optional($profileData)->no_telepon ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <small class="text-muted">Alamat</small>
                        <div>{{ optional($profileData)->alamat ?? '-' }}</div>
                    </div>
                    @if($biodata && $biodata->agama)
                    <div class="col-6 mb-3">
                        <small class="text-muted">Agama</small>
                        <div>{{ $biodata->agama ?? '-' }}</div>
                    </div>
                    @endif
                    @if($biodata && $biodata->nama_ayah)
                    <div class="col-6 mb-3">
                        <small class="text-muted">Nama Ayah</small>
                        <div>{{ $biodata->nama_ayah ?? '-' }}</div>
                    </div>
                    @endif
                    @if($biodata && $biodata->nama_ibu)
                    <div class="col-6 mb-3">
                        <small class="text-muted">Nama Ibu</small>
                        <div>{{ $biodata->nama_ibu ?? '-' }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @if($siswa)
                        @forelse($siswa->dokumen()->latest()->limit(5)->get() as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ optional($doc->jenisDokumen)->nama ?? 'Dokumen' }}</strong>
                                    <div class="text-muted small">{{ $doc->created_at->diffForHumans() }}</div>
                                </div>
                                <div>
                                    <a href="{{ route('user.dokumen.download', $doc->id) }}" class="btn btn-sm btn-outline-primary">Download</a>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada dokumen.</li>
                        @endforelse
                    @else
                        <li class="list-group-item text-muted">Belum ada data siswa.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

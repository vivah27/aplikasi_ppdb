@extends('layouts.master')

@section('page_title', 'Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Form Pembayaran</h1>

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
            <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Isi Data Pembayaran</h5>
        </div>
        <div class="card-body">
            <!-- Info Biaya Gelombang - Dynamic -->
            <div id="info-biaya-gelombang">
                @if($pendaftaran && $pendaftaran->harga_gelombang > 0)
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi Pembayaran:</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Gelombang:</strong> <span id="info-gelombang">{{ $pendaftaran->gelombang }}</span></li>
                            <li><strong>Jenis Pembayaran:</strong> <span id="info-jenis-pembayaran">{{ $pendaftaran->jenis_pembayaran ?? 'Uang Pendaftaran' }}</span></li>
                            <li><strong>Jumlah Pembayaran:</strong> <span class="text-success fw-bold" id="info-harga">Rp {{ number_format($pendaftaran->harga_gelombang, 0, ',', '.') }}</span></li>
                            <div id="info-tujuan-rekening-container">
                                @if($pendaftaran->tujuan_rekening)
                                    <li><strong>Tujuan Rekening:</strong>
                                        <div id="info-tujuan-rekening" style="margin-top: 8px; padding: 10px; background-color: #e7f3ff; border-left: 3px solid #0ea5e9; border-radius: 4px;">
                                            {{ $pendaftaran->tujuan_rekening }}
                                        </div>
                                    </li>
                                @endif
                            </div>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @else
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-warning me-2"></i>
                        <strong>Perhatian:</strong> Harga gelombang belum ditentukan oleh admin. Silakan hubungi admin untuk mengatur harga.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            @if($pendaftaran)
                <form action="{{ route('user.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Metode Pembayaran -->
                    <div class="mb-3">
                        <label for="metode_id" class="form-label">
                            <i class="fas fa-credit-card me-1"></i>Pilih Metode Pembayaran <span class="text-danger">*</span>
                        </label>
                        <select name="metode_id" id="metode_id" class="form-select @error('metode_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            @foreach($metode as $m)
                                <option value="{{ $m->id }}" data-kode="{{ $m->kode }}" {{ old('metode_id') == $m->id ? 'selected' : '' }}>
                                    @if($m->kode === 'transfer_bank')
                                        <i class="fas fa-university"></i> {{ $m->label }}
                                    @elseif($m->kode === 'e_wallet')
                                        <i class="fas fa-mobile-alt"></i> {{ $m->label }}
                                    @else
                                        {{ $m->label }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('metode_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TRANSFER BANK SECTION -->
                    <div id="transfer_bank_section" style="display: none;" class="mb-4 p-3 border border-info rounded" style="background-color: #f0f7ff;">
                        <h6 class="fw-bold text-info mb-3"><i class="fas fa-university me-2"></i>Detail Transfer Bank</h6>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_bank" class="form-label">
                                    Nama Bank <span class="text-danger">*</span>
                                </label>
                                <select name="nama_bank" id="nama_bank" class="form-select @error('nama_bank') is-invalid @enderror">
                                    <option value="">-- Pilih Bank --</option>
                                    <option value="Bank Mandiri" {{ old('nama_bank') == 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                    <option value="Bank BCA" {{ old('nama_bank') == 'Bank BCA' ? 'selected' : '' }}>Bank BCA</option>
                                    <option value="Bank BNI" {{ old('nama_bank') == 'Bank BNI' ? 'selected' : '' }}>Bank BNI</option>
                                    <option value="Bank BTN" {{ old('nama_bank') == 'Bank BTN' ? 'selected' : '' }}>Bank BTN</option>
                                    <option value="Bank CIMB Niaga" {{ old('nama_bank') == 'Bank CIMB Niaga' ? 'selected' : '' }}>Bank CIMB Niaga</option>
                                    <option value="Bank Permata" {{ old('nama_bank') == 'Bank Permata' ? 'selected' : '' }}>Bank Permata</option>
                                    <option value="Bank Danamon" {{ old('nama_bank') == 'Bank Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                                </select>
                                @error('nama_bank')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nomor_rekening" class="form-label">
                                    Nomor Rekening <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nomor_rekening" id="nomor_rekening" 
                                       class="form-control @error('nomor_rekening') is-invalid @enderror"
                                       placeholder="Contoh: 1234567890" value="{{ old('nomor_rekening') }}"
                                       inputmode="numeric" required>
                                <small class="text-muted d-block mt-1">Hanya angka</small>
                                @error('nomor_rekening')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="atas_nama_rekening" class="form-label">
                                    Atas Nama Rekening <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="atas_nama_rekening" id="atas_nama_rekening"
                                       class="form-control @error('atas_nama_rekening') is-invalid @enderror"
                                       placeholder="Nama pemilik rekening" value="{{ old('atas_nama_rekening') }}">
                                @error('atas_nama_rekening')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <small><i class="fas fa-info-circle me-2"></i><strong>Catatan:</strong> Pastikan data rekening sesuai dengan bukti transfer Anda.</small>
                        </div>
                    </div>

                    <!-- E-WALLET SECTION -->
                    <div id="ewallet_section" style="display: none;" class="mb-4 p-3 border border-success rounded" style="background-color: #f0fff4;">
                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-mobile-alt me-2"></i>Detail E-Wallet</h6>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="jenis_ewallet" class="form-label">
                                    Jenis E-Wallet <span class="text-danger">*</span>
                                </label>
                                <select name="jenis_ewallet" id="jenis_ewallet" class="form-select @error('jenis_ewallet') is-invalid @enderror">
                                    <option value="">-- Pilih E-Wallet --</option>
                                    <option value="GoPay" {{ old('jenis_ewallet') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                    <option value="OVO" {{ old('jenis_ewallet') == 'OVO' ? 'selected' : '' }}>OVO</option>
                                    <option value="DANA" {{ old('jenis_ewallet') == 'DANA' ? 'selected' : '' }}>DANA</option>
                                    <option value="LinkAja" {{ old('jenis_ewallet') == 'LinkAja' ? 'selected' : '' }}>LinkAja</option>
                                </select>
                                @error('jenis_ewallet')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nomor_ewallet" class="form-label">
                                    Nomor/ID E-Wallet <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nomor_ewallet" id="nomor_ewallet"
                                       class="form-control @error('nomor_ewallet') is-invalid @enderror"
                                       placeholder="Contoh: 08xxxxxxxxxx atau ID Anda"
                                       value="{{ old('nomor_ewallet') }}">
                                <small class="text-muted d-block mt-1">Nomor HP atau ID yang terdaftar di e-wallet</small>
                                @error('nomor_ewallet')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <small><i class="fas fa-info-circle me-2"></i><strong>Catatan:</strong> Masukkan nomor e-wallet yang sesuai dengan bukti transfer Anda.</small>
                        </div>
                    </div>

                    <!-- Upload Bukti Pembayaran -->
                    <div class="mb-3">
                        <label for="bukti" class="form-label">
                            <i class="fas fa-file-upload me-1"></i>Upload Bukti Pembayaran <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="bukti" id="bukti" class="form-control @error('bukti') is-invalid @enderror" 
                               accept=".jpg,.jpeg,.png,.pdf" required>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>Format: JPG, PNG, PDF | Maksimal: 2MB
                        </small>
                        @error('bukti')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan (Optional) -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i>Keterangan (Opsional)
                        </label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" 
                                  placeholder="Tambahkan catatan jika diperlukan...">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="d-grid gap-2 gap-md-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            @else
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-warning me-2"></i>
                    <strong>Peringatan!</strong> Anda belum mengisi formulir pendaftaran. 
                    <a href="{{ route('formulir.index') }}" class="alert-link">Isi formulir sekarang</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const metodeSelect = document.getElementById('metode_id');
    const transferBankSection = document.getElementById('transfer_bank_section');
    const ewalletSection = document.getElementById('ewallet_section');
    
    // Form fields
    const namaBank = document.getElementById('nama_bank');
    const nomorRekening = document.getElementById('nomor_rekening');
    const atasNamaRekening = document.getElementById('atas_nama_rekening');
    const jenisEwallet = document.getElementById('jenis_ewallet');
    const nomorEwallet = document.getElementById('nomor_ewallet');
    
    // Load harga gelombang on page load
    loadHargaGelombang();
    
    function loadHargaGelombang() {
        const gelombang = '{{ $pendaftaran->gelombang ?? "" }}';
        
        if (!gelombang) {
            return;
        }
        
        fetch(`/pembayaran/api/harga-gelombang/${gelombang}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBiayaInfo(data);
            } else {
                console.warn('Failed to load harga gelombang:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading harga gelombang:', error);
        });
    }
    
    function updateBiayaInfo(data) {
        // Update info display
        document.getElementById('info-harga').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.harga);
        document.getElementById('info-jenis-pembayaran').textContent = data.jenis_pembayaran;
        
        // Update tujuan rekening if exists
        const tujuanRekeningContainer = document.getElementById('info-tujuan-rekening-container');
        if (data.tujuan_rekening) {
            let tujuanRekeningHtml = '<li><strong>Tujuan Rekening:</strong>';
            tujuanRekeningHtml += '<div id="info-tujuan-rekening" style="margin-top: 8px; padding: 10px; background-color: #e7f3ff; border-left: 3px solid #0ea5e9; border-radius: 4px;">';
            tujuanRekeningHtml += data.tujuan_rekening;
            tujuanRekeningHtml += '</div></li>';
            tujuanRekeningContainer.innerHTML = tujuanRekeningHtml;
        } else {
            tujuanRekeningContainer.innerHTML = '';
        }
    }
    
    function updateFields() {
        const selectedOption = metodeSelect.options[metodeSelect.selectedIndex];
        const kode = selectedOption.getAttribute('data-kode');
        
        // Hide all sections
        transferBankSection.style.display = 'none';
        ewalletSection.style.display = 'none';
        
        // Clear required attributes
        namaBank.required = false;
        nomorRekening.required = false;
        atasNamaRekening.required = false;
        jenisEwallet.required = false;
        nomorEwallet.required = false;
        
        // Show appropriate section and set required
        if (kode === 'transfer_bank') {
            transferBankSection.style.display = 'block';
            namaBank.required = true;
            nomorRekening.required = true;
            atasNamaRekening.required = true;
        } else if (kode === 'e_wallet') {
            ewalletSection.style.display = 'block';
            jenisEwallet.required = true;
            nomorEwallet.required = true;
        }
    }
    
    // Trigger on page load if metode already selected
    if (metodeSelect.value) {
        updateFields();
    }
    
    // Listen for changes
    metodeSelect.addEventListener('change', updateFields);
});
</script>
@endsection

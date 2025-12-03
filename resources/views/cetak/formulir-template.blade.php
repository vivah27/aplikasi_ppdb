<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran PPDB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            width: 100%;
            height: 100%;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }

        .container {
            width: 100%;
            padding: 30px 40px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #003366;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            color: #003366;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #003366;
            color: white;
            padding: 10px 12px;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .form-group {
            margin-bottom: 10px;
            display: flex;
            border-bottom: 1px dotted #999;
            padding: 6px 0;
        }

        .form-label {
            width: 35%;
            font-weight: bold;
            color: #003366;
            padding-right: 12px;
        }

        .form-value {
            width: 65%;
            padding-left: 12px;
        }

        .two-column {
            display: flex;
            gap: 25px;
        }

        .two-column .section {
            flex: 1;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        .signature-area {
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
            gap: 20px;
        }

        .signature-block {
            flex: 1;
            text-align: center;
        }

        .signature-line {
            height: 50px;
            margin-bottom: 8px;
        }

        .signature-label {
            font-size: 11px;
            margin-top: 8px;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
            
            body {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>FORMULIR PENDAFTARAN PPDB</h1>
            <p>Penerimaan Peserta Didik Baru Tahun Ajaran {{ $pendaftaran->tahun_ajaran ?? '-' }}</p>
        </div>

        <!-- Nomor Pendaftaran & Status -->
        <div class="section">
            <div style="background: #f0f0f0; padding: 10px; border-left: 4px solid #003366; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Nomor Pendaftaran:</strong> {{ $pendaftaran->nomor_pendaftaran ?? '-' }}
                    </div>
                    <div>
                        <strong>Status:</strong> {{ $pendaftaran->statusPendaftaran->label ?? 'Menunggu' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pribadi -->
        <div class="section">
            <div class="section-title">I. DATA PRIBADI</div>

            <div class="form-group">
                <div class="form-label">Nama Lengkap</div>
                <div class="form-value">{{ $siswa->nama_lengkap ?? '-' }}</div>
            </div>

            <div class="two-column">
                <div>
                    <div class="form-group">
                        <div class="form-label">NISN</div>
                        <div class="form-value">{{ $siswa->nisn ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-label">NIK</div>
                        <div class="form-value">{{ $siswa->nik ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="two-column">
                <div>
                    <div class="form-group">
                        <div class="form-label">Tempat Lahir</div>
                        <div class="form-value">{{ $siswa->tempat_lahir ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-label">Tanggal Lahir</div>
                        <div class="form-value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="two-column">
                <div>
                    <div class="form-group">
                        <div class="form-label">Jenis Kelamin</div>
                        <div class="form-value">
                            @if($siswa->jenis_kelamin == 'L')
                                Laki-laki
                            @elseif($siswa->jenis_kelamin == 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-label">Agama</div>
                        <div class="form-value">{{ $siswa->agama ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="section">
            <div class="section-title">II. ALAMAT</div>

            <div class="form-group">
                <div class="form-label">Alamat</div>
                <div class="form-value">{{ $siswa->alamat ?? '-' }}</div>
            </div>

            <div class="form-group">
                <div class="form-label">Nomor Telepon</div>
                <div class="form-value">{{ $siswa->no_telepon ?? '-' }}</div>
            </div>

            <div class="form-group">
                <div class="form-label">Asal Sekolah</div>
                <div class="form-value">{{ $siswa->asal_sekolah ?? '-' }}</div>
            </div>
        </div>

        <!-- Pilihan Jurusan -->
        <div class="section">
            <div class="section-title">III. PILIHAN JURUSAN</div>

            <div class="two-column">
                <div>
                    <div class="form-group">
                        <div class="form-label">Pilihan 1</div>
                        <div class="form-value">{{ $jurusan1->nama ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-label">Pilihan 2</div>
                        <div class="form-value">{{ $jurusan2->nama ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pendaftaran -->
        <div class="section">
            <div class="section-title">IV. STATUS PENDAFTARAN</div>

            <div class="form-group">
                <div class="form-label">Status</div>
                <div class="form-value">{{ $pendaftaran->statusPendaftaran->label ?? 'BELUM DIVERIFIKASI' }}</div>
            </div>

            <div class="form-group">
                <div class="form-label">Tanggal Pendaftaran</div>
                <div class="form-value">{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d/m/Y H:i') : '-' }}</div>
            </div>
        </div>

        <!-- Signature Area -->
        <div class="signature-area">
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Peserta Didik</div>
                <p style="font-size: 10px; margin-top: 5px;">{{ $siswa->nama_lengkap ?? '-' }}</p>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Orang Tua/Wali</div>
                <p style="font-size: 10px; margin-top: 5px;">.............................</p>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Penerima</div>
                <p style="font-size: 10px; margin-top: 5px;">.............................</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Formulir ini adalah bukti pendaftaran PPDB yang sah</p>
            <p>Dicetak: {{ now()->format('d/m/Y H:i:s') }}</p>
            <button class="no-print" onclick="window.print()" style="margin-top: 20px; padding: 10px 20px; background: #003366; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                Cetak Dokumen
            </button>
        </div>
    </div>
</body>
</html>

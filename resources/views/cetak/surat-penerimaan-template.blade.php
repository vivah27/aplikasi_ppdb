<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penerimaan PPDB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Times New Roman', serif;
            font-size: 13px;
            line-height: 1.6;
            color: #000;
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
            max-width: 850px;
            margin: 0 auto;
            padding: 45px 55px;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
        }

        .header-kop {
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header-subtitle {
            font-size: 13px;
            margin-bottom: 3px;
        }

        .letter-number {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .letter-number span {
            font-weight: bold;
        }

        .greeting {
            margin-bottom: 20px;
        }

        .content {
            text-align: justify;
            margin-bottom: 20px;
        }

        .content p {
            margin-bottom: 15px;
            text-indent: 40px;
        }

        .content p:first-child {
            text-indent: 0;
        }

        .student-info {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            width: 25%;
            font-weight: bold;
        }

        .info-value {
            width: 75%;
            padding-left: 20px;
            border-bottom: 1px dotted #999;
        }

        .closing {
            margin-top: 30px;
            text-align: center;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-block {
            width: 45%;
            text-align: center;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 50px;
        }

        .signature-name {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: center;
            color: #666;
        }

        .date-place {
            margin-bottom: 15px;
            text-align: right;
        }

        .print-button-container {
            margin-top: 30px;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            background: #003366;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        @media print {
            .no-print {
                display: none;
            }
            
            .print-button-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-kop">
                <div class="header-title">SURAT PENERIMAAN PESERTA DIDIK BARU</div>
                <div class="header-subtitle">Penerimaan Peserta Didik Baru (PPDB)</div>
                <div class="header-subtitle">Tahun Ajaran {{ $pendaftaran->tahun_ajaran ?? '-' }}</div>
            </div>
        </div>

        <!-- Letter Number -->
        <div class="letter-number">
            No. <span>{{ $pendaftaran->id }}/PPDB/{{ now()->year }}</span>
        </div>

        <!-- Greeting -->
        <div class="greeting">
            Dengan hormat,
        </div>

        <!-- Content -->
        <div class="content">
            <p>
                Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran {{ $pendaftaran->tahun_ajaran ?? '-' }}, 
                dengan ini kami dengan senang hati memberitahukan bahwa calon peserta didik dengan identitas sebagai berikut:
            </p>

            <!-- Student Information -->
            <div class="student-info">
                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">: {{ strtoupper($siswa->nama_lengkap ?? '-') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">NISN</div>
                    <div class="info-value">: {{ $siswa->nisn ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tempat Tanggal Lahir</div>
                    <div class="info-value">: {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Asal Sekolah</div>
                    <div class="info-value">: {{ $siswa->asal_sekolah ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jurusan Diterima</div>
                    <div class="info-value">: {{ strtoupper($jurusan->nama ?? '-') }}</div>
                </div>
            </div>

            <p>
                <strong>DITERIMA</strong> sebagai peserta didik baru di institusi kami untuk tahun ajaran {{ $pendaftaran->tahun_ajaran ?? '-' }}.
            </p>

            <p>
                Untuk melengkapi proses pendaftaran, calon peserta didik dimohon untuk:
            </p>

            <ol style="text-align: justify; margin-left: 40px; margin-bottom: 15px;">
                <li>Melaporkan diri ke sekolah pada tanggal yang telah ditentukan</li>
                <li>Membawa berkas-berkas yang diperlukan sesuai dengan pengumuman</li>
                <li>Menyelesaikan administrasi yang masih tertunda</li>
                <li>Mengikuti kegiatan orientasi peserta didik baru</li>
            </ol>

            <p>
                Demikianlah surat penerimaan ini dibuat dengan sebenarnya. Kami mengucapkan selamat atas diterima di institusi kami 
                dan berharap calon peserta didik dapat menunjukkan prestasi akademik dan non-akademik yang baik selama mengikuti pendidikan.
            </p>
        </div>

        <!-- Date and Place -->
        <div class="date-place">
            {{ $tanggal }}
        </div>

        <!-- Signatures -->
        <div class="signature-section">
            <div class="signature-block">
                <div class="signature-title">Peserta Didik</div>
                <div style="height: 50px;"></div>
                <div class="signature-name">{{ strtoupper($siswa->nama_lengkap ?? '-') }}</div>
            </div>
            <div class="signature-block">
                <div class="signature-title">Kepala Sekolah</div>
                <div style="height: 50px;"></div>
                <div class="signature-name">.............................</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Surat ini adalah bukti resmi penerimaan peserta didik baru</p>
            <p>Dicetak: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <div class="print-button-container no-print">
        <button onclick="window.print()">Cetak Surat Penerimaan</button>
    </div>
</body>
</html>

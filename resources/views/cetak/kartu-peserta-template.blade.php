<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta PPDB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.3;
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
            height: 100vh;
            padding: 30px;
        }

        .card-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            height: auto;
        }

        .card {
            width: 100%;
            border: 3px solid #003366;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 300px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #003366;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .header-title {
            font-size: 14px;
            font-weight: bold;
            color: #003366;
        }

        .header-subtitle {
            font-size: 8px;
            color: #666;
        }

        .info-section {
            margin-bottom: 10px;
        }

        .info-label {
            font-size: 8px;
            color: #666;
            font-weight: bold;
        }

        .info-value {
            font-size: 11px;
            color: #003366;
            font-weight: bold;
            margin-top: 2px;
        }

        .barcode-section {
            text-align: center;
            margin: 12px 0;
            padding: 12px;
            background: white;
            border-radius: 4px;
        }

        .barcode {
            font-family: 'Code 128';
            font-size: 20px;
            letter-spacing: 2px;
            margin: 5px 0;
        }

        .barcode-text {
            font-size: 8px;
            color: #666;
            margin-top: 3px;
        }

        .footer {
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            font-size: 7px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            margin-top: 5px;
        }

        .two-column {
            display: flex;
            gap: 12px;
        }

        .two-column .info-section {
            flex: 1;
            margin-bottom: 0;
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
        <div class="card-container">
            <div class="card">
                <!-- Header -->
                <div class="header">
                    <div class="header-title">KARTU PESERTA</div>
                    <div class="header-subtitle">PPDB Tahun Ajaran {{ $pendaftaran->tahun_ajaran ?? '-' }}</div>
                </div>

                <!-- Biodata Peserta -->
                <div class="info-section">
                    <div class="info-label">NAMA PESERTA</div>
                    <div class="info-value">{{ strtoupper($siswa->nama_lengkap ?? '-') }}</div>
                </div>

                <div class="two-column">
                    <div class="info-section">
                        <div class="info-label">NISN</div>
                        <div class="info-value">{{ $siswa->nisn ?? '-' }}</div>
                    </div>
                    <div class="info-section">
                        <div class="info-label">TGL LAHIR</div>
                        <div class="info-value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                    </div>
                </div>

                <!-- Pilihan Jurusan -->
                <div class="info-section">
                    <div class="info-label">PILIHAN JURUSAN</div>
                    <div class="info-value">{{ $jurusan->nama ?? '-' }}</div>
                </div>

                <!-- Barcode Section -->
                <div class="barcode-section">
                    <div class="barcode">{{ $barcode }}</div>
                    <div class="barcode-text">{{ $barcode }}</div>
                    <div class="status-badge">✓ TERDAFTAR</div>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <p>Sekolah: {{ config('app.name', 'PPDB') }}</p>
                    <p>Berlaku untuk keperluan resmi PPDB</p>
                    <p>Dicetak: {{ now()->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="print-button-container no-print">
            <button onclick="window.print()">Cetak Kartu Peserta</button>
        </div>
    </div>
</body>
</html>

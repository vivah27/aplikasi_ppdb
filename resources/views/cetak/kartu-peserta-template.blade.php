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
            font-family: 'Segoe UI', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #2c3e50;
            background-color: #ecf0f1;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }
        }

        .container {
            width: 100%;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .card {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            border-top: 6px solid #1a5490;
        }

        .card-header {
            background: linear-gradient(135deg, #1a5490 0%, #2e7cb0 100%);
            color: white;
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid #e8eaed;
        }

        .card-header-main {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .card-header-sub {
            font-size: 10px;
            opacity: 0.95;
            font-weight: 500;
        }

        .card-body {
            padding: 24px 20px;
        }

        .info-group {
            margin-bottom: 18px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-group:last-of-type {
            border-bottom: none;
            margin-bottom: 12px;
            padding-bottom: 0;
        }

        .info-row {
            display: flex;
            gap: 24px;
            margin-bottom: 12px;
        }

        .info-field {
            flex: 1;
        }

        .info-label {
            font-size: 9px;
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 13px;
            color: #1a5490;
            font-weight: 600;
            word-break: break-word;
        }

        .full-width {
            flex: 0 0 100%;
        }

        .barcode-section {
            background: #f8f9fa;
            border: 2px dashed #e0e0e0;
            border-radius: 6px;
            padding: 16px;
            text-align: center;
            margin: 20px 0;
        }

        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 2px;
            margin: 8px 0;
            word-break: break-all;
        }

        .barcode-label {
            font-size: 8px;
            color: #95a5a6;
            margin-top: 4px;
            text-transform: uppercase;
        }

        .status-badge {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 12px 20px;
            text-align: center;
            border-top: 1px solid #e8eaed;
            font-size: 8px;
            color: #95a5a6;
        }

        .footer-item {
            margin: 3px 0;
        }

        .footer-item strong {
            color: #2c3e50;
        }

        .print-button-container {
            margin-top: 32px;
            text-align: center;
        }

        .print-btn {
            padding: 12px 32px;
            background: linear-gradient(135deg, #1a5490 0%, #2e7cb0 100%);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 84, 144, 0.3);
        }

        .print-btn:active {
            transform: translateY(0);
        }

        @media print {
            .no-print {
                display: none !important;
            }
            
            .card {
                box-shadow: none;
                max-width: 100%;
                border-radius: 0;
            }

            .container {
                padding: 0;
                background-color: white;
            }

            body {
                background-color: white;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px 10px;
            }

            .card-body {
                padding: 18px 16px;
            }

            .card-header {
                padding: 18px 16px;
            }

            .info-row {
                flex-direction: column;
                gap: 0;
            }

            .card-header-main {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card-wrapper">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header">
                    <div class="card-header-main">KARTU PESERTA</div>
                    <div class="card-header-sub">PPDB Tahun Ajaran {{ $pendaftaran->tahun_ajaran ?? '-' }}/{{ intval($pendaftaran->tahun_ajaran) + 1 ?? '-' }}</div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Nama Peserta -->
                    <div class="info-group">
                        <div class="info-field full-width">
                            <div class="info-label">Nama Peserta</div>
                            <div class="info-value">{{ strtoupper($siswa->nama_lengkap ?? '-') }}</div>
                        </div>
                    </div>

                    <!-- NISN & Tanggal Lahir -->
                    <div class="info-group">
                        <div class="info-row">
                            <div class="info-field">
                                <div class="info-label">NISN</div>
                                <div class="info-value">{{ $siswa->nisn ?? '-' }}</div>
                            </div>
                            <div class="info-field">
                                <div class="info-label">Tanggal Lahir</div>
                                <div class="info-value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Jurusan -->
                    <div class="info-group">
                        <div class="info-field full-width">
                            <div class="info-label">Pilihan Jurusan</div>
                            <div class="info-value">
                                @if($jurusan && $jurusan->nama_jurusan)
                                    {{ $jurusan->nama_jurusan }}
                                @elseif($jurusan && $jurusan->nama)
                                    {{ $jurusan->nama }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Pendaftaran -->
                    <div class="info-group">
                        <div class="info-field full-width">
                            <div class="info-label">Nomor Pendaftaran</div>
                            <div class="info-value">{{ $pendaftaran->nomor_pendaftaran ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Barcode Section -->
                    <div class="barcode-section">
                        <div class="barcode-text">{{ $barcode }}</div>
                        <div class="barcode-label">Barcode Peserta</div>
                        <div class="status-badge">✓ TERDAFTAR</div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                    <div class="footer-item"><strong>{{ config('app.name', 'PPDB') }}</strong></div>
                    <div class="footer-item">Berlaku untuk keperluan resmi PPDB</div>
                    <div class="footer-item">Dicetak: {{ now()->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="print-button-container no-print">
            <button class="print-btn" onclick="window.print()">🖨️ Cetak Kartu Peserta</button>
        </div>
    </div>

    <script>
        // Optimize print experience
        window.addEventListener('beforeprint', function() {
            document.body.style.backgroundColor = '#fff';
        });
    </script>
</body>
</html>

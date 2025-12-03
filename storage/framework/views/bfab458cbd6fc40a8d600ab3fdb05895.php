<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran PPDB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
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
            max-width: 950px;
            margin: 0 auto;
            padding: 35px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 28px;
            border-bottom: 3px solid #003366;
            padding-bottom: 15px;
        }

        .receipt-title {
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            margin-bottom: 5px;
        }

        .receipt-subtitle {
            font-size: 12px;
            color: #666;
        }

        .receipt-number {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }

        .receipt-number-left, .receipt-number-right {
            flex: 1;
        }

        .receipt-number-right {
            text-align: right;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #f0f0f0;
            border-left: 4px solid #003366;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px dotted #ccc;
        }

        .info-label {
            width: 30%;
            font-weight: bold;
            color: #003366;
        }

        .info-value {
            width: 70%;
            padding-left: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .items-table th {
            background-color: #003366;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 11px;
        }

        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-section {
            margin: 20px 0;
            border-top: 2px solid #003366;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            padding-right: 50px;
        }

        .total-label {
            width: 200px;
            text-align: right;
            font-weight: bold;
            padding-right: 20px;
        }

        .total-value {
            width: 150px;
            text-align: right;
            font-weight: bold;
            border-bottom: 1px solid #000;
        }

        .payment-method {
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 4px;
        }

        .signature-area {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }

        .signature-block {
            width: 30%;
            text-align: center;
        }

        .signature-line {
            height: 40px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
        }

        .signature-name {
            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        .stamp-area {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #999;
        }

        .status-badge {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
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
        <div class="receipt-header">
            <div class="receipt-title">KUITANSI PEMBAYARAN</div>
            <div class="receipt-subtitle">Penerimaan Peserta Didik Baru (PPDB)</div>
        </div>

        <!-- Receipt Numbers -->
        <div class="receipt-number">
            <div class="receipt-number-left">
                <strong>No. Kuitansi:</strong> <?php echo e($pembayaran->id); ?>/<?php echo e(now()->year); ?>

            </div>
            <div class="receipt-number-right">
                <strong>Tanggal:</strong> <?php echo e(now()->format('d/m/Y')); ?>

            </div>
        </div>

        <!-- Payer Information -->
        <div class="section">
            <div class="section-title">DATA PEMBAYAR</div>
            <div class="info-row">
                <div class="info-label">Nama Peserta Didik</div>
                <div class="info-value"><?php echo e(strtoupper($siswa->nama_lengkap ?? '-')); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">NISN</div>
                <div class="info-value"><?php echo e($siswa->nisn ?? '-'); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Tahun Ajaran</div>
                <div class="info-value"><?php echo e($pembayaran->pendaftaran->tahun_ajaran ?? '-'); ?></div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="section">
            <div class="section-title">RINCIAN PEMBAYARAN</div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th width="50%">Keterangan</th>
                        <th width="25%" style="text-align: center;">Jumlah</th>
                        <th width="25%" style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Biaya Pendaftaran PPDB</td>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: right;">
                            Rp <?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?>

                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-row">
                    <div class="total-label">Jumlah Pembayaran:</div>
                    <div class="total-value">Rp <?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?></div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <div class="section-title">INFORMASI PEMBAYARAN</div>
            <div class="info-row">
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value"><?php echo e($pembayaran->metodePembayaran->nama ?? ($pembayaran->metode ?? 'TRANSFER BANK')); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Status Pembayaran</div>
                <div class="info-value">
                    <span class="status-badge"><?php echo e(strtoupper($pembayaran->statusPembayaran->nama ?? $pembayaran->status ?? 'LUNAS')); ?></span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pembayaran</div>
                <div class="info-value"><?php echo e($pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y H:i') : '-'); ?></div>
            </div>
        </div>

        <!-- Payment Method Details -->
        <?php if($pembayaran->metodePembayaran && $pembayaran->metodePembayaran->nama != 'TRANSFER BANK'): ?>
        <div class="payment-method">
            <strong>Metode:</strong> <?php echo e($pembayaran->metodePembayaran->nama ?? '-'); ?>

            <?php if($pembayaran->reference): ?>
                <br><strong>Referensi:</strong> <?php echo e($pembayaran->reference); ?>

            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Signature -->
        <div class="signature-area">
            <div class="signature-block">
                <div style="font-weight: bold; margin-bottom: 10px;">Pembayar</div>
                <div class="signature-line"></div>
                <div class="signature-name"><?php echo e(strtoupper($siswa->nama_lengkap ?? '-')); ?></div>
            </div>
            <div class="signature-block">
                <div style="font-weight: bold; margin-bottom: 10px;">Penerima</div>
                <div class="signature-line"></div>
                <div class="signature-name">.............................</div>
                <div style="font-size: 10px; margin-top: 5px;">Tanggal: _______________</div>
            </div>
        </div>

        <!-- Stamp Area -->
        <div class="stamp-area">
            <p style="margin-top: 30px;">[ Tempat Stempel/Cap Sekolah ]</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Kuitansi ini adalah bukti sah pembayaran pendaftaran PPDB</p>
            <p>Dicetak: <?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
            <p style="color: #999; margin-top: 10px;">Harap simpan kuitansi ini sebagai bukti pembayaran</p>
        </div>
    </div>

    <div class="print-button-container no-print">
        <button onclick="window.print()">Cetak Kuitansi Pembayaran</button>
    </div>
</body>
</html>
<?php /**PATH C:\ppdb_denico_09\resources\views/cetak/kuitansi-template.blade.php ENDPATH**/ ?>
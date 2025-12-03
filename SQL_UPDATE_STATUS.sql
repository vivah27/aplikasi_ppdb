<?php
// Script SQL untuk update status Denico - jalankan di phpmyadmin atau database tool

// 1. Pastikan status DITERIMA ada di tabel status_pendaftarans
INSERT INTO `status_pendaftarans` (`nama`, `label`, `created_at`, `updated_at`) 
VALUES ('DITERIMA', 'DITERIMA', NOW(), NOW())
ON DUPLICATE KEY UPDATE `label` = 'DITERIMA';

-- 2. Cari pendaftaran Denico (berdasarkan nama atau email)
-- Jika Denico sudah ada di database, gunakan query ini:

SELECT p.id, p.status_id, s.nama_lengkap, u.email, p.tahun_ajaran
FROM pendaftarans p
JOIN siswas s ON p.siswa_id = s.id
JOIN users u ON s.pengguna_id = u.id
WHERE s.nama_lengkap LIKE '%DENICO%' OR u.email LIKE '%denico%';

-- 3. Update status Denico ke DITERIMA
-- Ganti ID 1 dengan ID pendaftaran Denico yang sebenarnya

UPDATE pendaftarans 
SET status_id = (SELECT id FROM status_pendaftarans WHERE nama = 'DITERIMA' LIMIT 1)
WHERE id = 1;

-- 4. Verify update berhasil
SELECT * FROM pendaftarans WHERE id = 1;
?>

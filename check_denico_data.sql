SELECT 
    'USERS' as entity,
    COUNT(*) as total_count
FROM users
WHERE email LIKE '%denico%'

UNION ALL

SELECT 
    'SISWAS',
    COUNT(*)
FROM siswas
WHERE nama LIKE '%denico%'

UNION ALL

SELECT 
    'PENDAFTARANS',
    COUNT(*)
FROM pendaftarans
WHERE siswa_id IN (
    SELECT id FROM siswas WHERE pengguna_id IN (
        SELECT id FROM users WHERE email = 'denicottuesdyoesmana@gmail.com'
    )
)

UNION ALL

SELECT 
    'PEMBAYARAN',
    COUNT(*)
FROM pembayaran
WHERE pendaftaran_id IN (
    SELECT id FROM pendaftarans WHERE siswa_id IN (
        SELECT id FROM siswas WHERE pengguna_id IN (
            SELECT id FROM users WHERE email = 'denicottuesdyoesmana@gmail.com'
        )
    )
);

-- Detailed pembayaran data
SELECT CONCAT('\n=== PEMBAYARAN DATA ===') as info;

SELECT 
    p.id,
    p.pendaftaran_id,
    p.nama,
    p.status,
    p.jumlah,
    p.metode,
    p.tanggal_bayar,
    p.created_at
FROM pembayaran p
WHERE p.pendaftaran_id IN (
    SELECT id FROM pendaftarans WHERE siswa_id IN (
        SELECT id FROM siswas WHERE pengguna_id IN (
            SELECT id FROM users WHERE email = 'denicottuesdyoesmana@gmail.com'
        )
    )
);

-- Detailed user-siswa-pendaftaran chain
SELECT CONCAT('\n=== USER CHAIN ===') as info;

SELECT 
    u.id as user_id,
    u.email,
    s.id as siswa_id,
    s.nama as siswa_nama,
    pd.id as pendaftaran_id,
    pd.nomor_pendaftaran,
    pd.tahun_ajaran
FROM users u
LEFT JOIN siswas s ON s.pengguna_id = u.id
LEFT JOIN pendaftarans pd ON pd.siswa_id = s.id
WHERE u.email = 'denicottuesdyoesmana@gmail.com';

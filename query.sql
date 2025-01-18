-- Tambahkan pengguna dengan role 'hrd'
INSERT INTO users (username, password, name, email, role)
VALUES ('hrd_user', MD5('password123'), 'HRD Manager', 'hrd@example.com', 'hrd');

-- Tambahkan pengguna dengan role 'keuangan'
INSERT INTO users (username, password, name, email, role)
VALUES ('keuangan_user', MD5('password123'), 'Finance Officer', 'keuangan@example.com', 'keuangan');

-- Tambahkan pengguna dengan role 'pimpinan'
INSERT INTO users (username, password, name, email, role)
VALUES ('pimpinan_user', MD5('password123'), 'CEO', 'pimpinan@example.com', 'pimpinan');

CREATE TABLE tb_karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nik VARCHAR(50) NOT NULL UNIQUE,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    gaji INT  NOT NULL
);

CREATE TABLE tb_absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    karyawan_id INT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME NOT NULL,
    jam_keluar TIME NOT NULL,
    lembur INT DEFAULT 0,  -- dalam menit
    status ENUM('Hadir', 'Alpha') NOT NULL, -- Status absensi menggunakan ENUM'Cuti', 'Sakit', 'Izin',
    FOREIGN KEY (karyawan_id) REFERENCES tb_karyawan(id)
);

-- query untuk mendapatkna data absensi sorrang karyawan pada bulan tertentu
SELECT
    k.nama AS nama_karyawan,
    k.nik,
    a.tanggal,
    a.jam_masuk,
    a.jam_keluar,
    a.lembur,
    a.status
FROM
    tb_absensi a
JOIN
    tb_karyawan k ON a.karyawan_id = k.id
WHERE
    k.id = ? -- Ganti dengan ID karyawan yang diinginkan
    AND DATE_FORMAT(a.tanggal, '%Y-%m') = ?; -- Ganti dengan format 'YYYY-MM' untuk bulan tertentu

INSERT INTO tb_absensi (karyawan_id, tanggal, jam_masuk, jam_keluar, lembur, status)
VALUES (6, '2025-01-14', '08:00:00', '20:00:00', 120, 'Hadir');

-- Data Dummy untuk Tabel Absensi
INSERT INTO tb_absensi (karyawan_id, tanggal, jam_masuk, jam_keluar, lembur, status)
VALUES
(6, '2025-01-12', '08:00:00', '17:00:00', 0, 'Hadir'),
(7, '2025-01-12', '08:15:00', '17:15:00', 15, 'Hadir'),
(8, '2025-01-12', '09:00:00', '17:00:00', 0, 'Izin'),
(9, '2025-01-12', '08:00:00', '16:00:00', 0, 'Cuti'),
(10, '2025-01-12', '08:30:00', '17:30:00', 30, 'Hadir'),
(11, '2025-01-12', '08:00:00', '17:00:00', 0, 'Sakit'),
(13, '2025-01-12', '08:00:00', '18:00:00', 60, 'Hadir');

-- Data Dummy untuk Tabel Absensi
INSERT INTO tb_absensi (karyawan_id, tanggal, jam_masuk, jam_keluar, lembur, status)
VALUES
(6, '2025-01-13', '08:00:00', '17:00:00', 0, 'Hadir'),
(7, '2025-01-13', '08:15:00', '17:15:00', 15, 'Hadir'),
(8, '2025-01-13', '09:00:00', '17:00:00', 0, 'Izin'),
(9, '2025-01-13', '08:00:00', '16:00:00', 0, 'Cuti'),
(10, '2025-01-13', '08:30:00', '17:30:00', 30, 'Hadir'),
(13, '2025-01-13', '08:00:00', '18:00:00', 60, 'Hadir'),
(14, '2025-01-13', '08:00:00', '18:00:00', 60, 'Hadir'),
(15, '2025-01-13', '08:00:00', '18:00:00', 60, 'Hadir');


CREATE TABLE tb_gaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    karyawan_id INT NOT NULL,
    periode VARCHAR(7) NOT NULL,  -- Format contoh: '2025-01'
    gaji_pokok INT NOT NULL,
    gaji_lembur INT NOT NULL,
    gaji_total INT AS (gaji_pokok + gaji_lembur) STORED,  -- Contoh perhitungan lembur
    FOREIGN KEY (karyawan_id) REFERENCES tb_karyawan(id) ON DELETE CASCADE
);

CREATE TABLE tb_pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gaji_id INT NOT NULL,
    tanggal_bayar DATE NOT NULL,
    FOREIGN KEY (gaji_id) REFERENCES tb_gaji(id) ON DELETE CASCADE
);

-- metode_bayar ENUM('Transfer', 'Tunai') NOT NULL,
-- status ENUM('Lunas', 'Belum Lunas') NOT NULL,

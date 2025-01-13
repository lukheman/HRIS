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

CREATE TABLE absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    karyawan_id INT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME NOT NULL,
    jam_keluar TIME NOT NULL,
    lembur INT DEFAULT 0,  -- dalam menit
    status ENUM('Hadir', 'Cuti', 'Sakit', 'Izin', 'Alpha') NOT NULL, -- Status absensi menggunakan ENUM
    FOREIGN KEY (karyawan_id) REFERENCES tb_karyawan(id)
);


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


CREATE TABLE tb_gaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    karyawan_id INT NOT NULL,
    periode VARCHAR(7) NOT NULL,  -- Format contoh: '2025-01'
    gaji_pokok INT NOT NULL,
    gaji_lembur INT NOT NULL,
    gaji_total INT AS (gaji_pokok + gaji_lembur) STORED,  -- Contoh perhitungan lembur
    FOREIGN KEY (karyawan_id) REFERENCES tb_karyawan(id) ON DELETE CASCADE
);

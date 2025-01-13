<?php
// Menghubungkan ke database
$host = 'localhost';
$user = 'root';
$password = 'akmal';
$dbname = 'fbs'; // Ganti dengan nama database Anda

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Data dummy yang akan dimasukkan
$karyawanData = [
    ['nama' => 'John Doe', 'nik' => '123456789', 'tanggal_lahir' => '1990-01-01', 'alamat' => 'Jl. Raya No. 1', 'jabatan' => 'Kepala Teknik Tambah', 'gaji' => 5000000],
    ['nama' => 'Jane Smith', 'nik' => '987654321', 'tanggal_lahir' => '1988-05-15', 'alamat' => 'Jl. Merdeka No. 3', 'jabatan' => 'Engineering', 'gaji' => 6000000],
    ['nama' => 'Rudi Hartono', 'nik' => '456789123', 'tanggal_lahir' => '1992-08-10', 'alamat' => 'Jl. Sukarno Hatta No. 2', 'jabatan' => 'Kepala Produksi', 'gaji' => 7000000],
    ['nama' => 'Aminah Rahmawati', 'nik' => '345678912', 'tanggal_lahir' => '1991-03-21', 'alamat' => 'Jl. Bunga No. 4', 'jabatan' => 'SVP', 'gaji' => 5500000],
    ['nama' => 'Budi Santoso', 'nik' => '234567891', 'tanggal_lahir' => '1990-11-30', 'alamat' => 'Jl. Pahlawan No. 5', 'jabatan' => 'Jungler', 'gaji' => 6000000],
];

// Menyiapkan query untuk memasukkan data
$stmt = $conn->prepare("INSERT INTO tb_karyawan (nama, nik, tanggal_lahir, alamat, jabatan, gaji) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssd', $nama, $nik, $tanggal_lahir, $alamat, $jabatan, $gaji);

// Menambahkan data
foreach ($karyawanData as $data) {
    $nama = $data['nama'];
    $nik = $data['nik'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $alamat = $data['alamat'];
    $jabatan = $data['jabatan'];
    $gaji = $data['gaji'];

    $stmt->execute();
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();

echo "Data dummy berhasil ditambahkan!";
?>

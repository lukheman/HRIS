-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 15, 2025 at 03:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time DEFAULT NULL,
  `lembur` int(11) DEFAULT 0,
  `status` enum('Hadir','Cuti','Sakit','Izin','Alpha') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `periode` varchar(7) NOT NULL,
  `gaji_pokok` int(11) NOT NULL,
  `gaji_lembur` int(11) NOT NULL,
  `gaji_total` int(11) DEFAULT NULL,
  `total_lembur` int(11) DEFAULT 0,
  `status` enum('PENDING','DISETUJUI','DITOLAK') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `gaji` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`id`, `jabatan`, `gaji`) VALUES
(20, 'Direktur Utama', 100000000),
(21, 'Direktur Operasional', 80000000),
(22, 'General Manager (GM)', 60000000),
(24, 'Supervisor Tambang', 20000000),
(25, 'Geologis', 25000000),
(26, 'Insinyur Pertambangan', 22000000),
(27, 'Surveyor Tambang', 15000000),
(28, 'Quality Control (QC)', 12000000),
(29, 'Operator Alat Berat', 10000000),
(30, 'Driller & Blaster', 9000000),
(31, 'Teknisi Mekanik', 8500000),
(32, 'Welder (Tukang Las)', 8000000),
(33, 'Helper Tambang', 7000000),
(34, 'Staff Administrasi', 6500000),
(35, 'HRD & Payroll', 7500000),
(36, 'Keamanan (Security)', 5500000),
(37, 'Petugas Kebersihan & Catering', 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_karyawan`
--

CREATE TABLE `tb_karyawan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `gaji_lembur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`id`, `nama`, `nik`, `tanggal_lahir`, `alamat`, `id_jabatan`, `gaji_lembur`) VALUES
(171, '111', '22221', '5555-05-05', 'd3', 20, 1234),
(172, '2312', '12', '0033-03-31', '12', 36, 12),
(173, '23', '12111', '0011-11-11', '111', 35, 111);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL,
  `gaji_lembur` int(11) DEFAULT NULL,
  `radius_maksimal` int(11) DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`jam_masuk`, `jam_keluar`, `latitude`, `longitude`, `gaji_lembur`, `radius_maksimal`) VALUES
('07:00:00', '18:00:00', -4.193428, 121.607559, 50000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('HRD','KEUANGAN','PIMPINAN','KARYAWAN') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `name`, `email`, `role`, `created_at`) VALUES
(1, 'hrd_user', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'HRD', 'hrd@example.com', 'HRD', '2025-01-11 22:55:54'),
(2, 'keuangan_user', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Keuangan', 'keuangan@example.com', 'KEUANGAN', '2025-01-11 22:56:07'),
(3, 'pimpinan_user', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Pimpinan', 'pimpinan@example.com', 'PIMPINAN', '2025-01-11 22:56:15'),
(52, '1113756122052501', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Eli Wijaya', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(53, '1901083092054966', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Reza Maheswara', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(54, '7820178728029543', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'drg. Zamira Salahudin, S.T.', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(55, '4575650901371277', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Juli Firgantoro, S.I.Kom', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(56, '1817781856554201', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Ikin Safitri', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(57, '5037178734486011', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dimas Padmasari', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(58, '2962027249209348', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Drs. Dian Widodo, S.Psi', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(59, '7022151289456558', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Yunita Mandala', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(60, '7393126250278563', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'R. Vanya Saragih, S.Gz', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(61, '1869335902169333', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Padma Mustofa', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(62, '8991418179865440', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dalima Pranowo', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(63, '8237554104890837', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Sarah Gunarto', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(64, '6811283710032941', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dodo Simanjuntak, S.T.', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(65, '6114710248492531', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Raisa Salahudin', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(66, '8920441208086291', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Tgk. Vanesa Handayani', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(67, '5750723496530464', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Oskar Padmasari', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(68, '8785851558325925', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Tgk. Enteng Gunawan', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(69, '4554937555001597', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Cut Sari Waskita', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(70, '5981397530053751', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Ajimin Lazuardi', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(71, '6085095101180096', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Martani Utami, M.M.', NULL, 'KARYAWAN', '2025-02-01 10:09:13'),
(90, '2009816999778726', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Sakura Laksmiwati', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(91, '4835374996748798', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Uchita Hastuti', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(92, '3753863031020746', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Artanto Rajasa', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(93, '6536493223288653', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Harjo Winarno, M.Ak', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(94, '4859516706845009', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dr. Irnanto Budiman', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(95, '2164000829141882', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Lasmanto Kurniawan, S.Sos', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(96, '3823729461262110', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Cut Ella Maulana, S.E.', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(97, '1345423944400182', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Yulia Nuraini', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(98, '9262818737465625', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Langgeng Anggraini, S.Pd', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(99, '1702626842908945', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dariati Prasetyo', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(100, '5197036983812129', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dt. Martaka Nasyiah, S.Kom', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(101, '9492920227302917', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Ir. Dina Puspasari, M.TI.', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(102, '6491082652393811', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Atmaja Mustofa', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(103, '4677808385120635', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Aswani Damanik', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(104, '8178610442088491', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Wirda Mandala', NULL, 'KARYAWAN', '2025-02-27 03:11:01'),
(105, '4797667847657686', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'R.M. Wardaya Gunarto, S.I.Kom', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(106, '1780437031917782', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Indah Suryono', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(107, '8862344852010992', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Daruna Mandasari', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(108, '8366877432974831', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Hafshah Suryono', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(109, '5331281198029916', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Vera Uwais', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(110, '9210142938937480', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'H. Sidiq Halim, S.E.', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(111, '5419499803241201', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Dalima Mardhiyah', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(112, '9729964562227348', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Tgk. Fathonah Waluyo', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(113, '3036000995529341', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Suci Hartati', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(114, '2491200172817689', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Jamalia Purnawati', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(115, '9436457644674541', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Ganda Lazuardi, M.TI.', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(116, '5477355310578372', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Kezia Firgantoro', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(117, '1590955695162556', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Sutan Raihan Budiman, S.Pd', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(118, '7137676782254311', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Hasna Lestari', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(119, '1739857628188285', '$2y$10$ghHa5eVSoTDW7WP6Yl4Vuuw4.gCOxRWXEpADTk5DsFKIimOfT2JMa', 'Maria Damanik, M.Kom.', NULL, 'KARYAWAN', '2025-02-27 04:26:22'),
(120, '10101010', '$2y$10$gryD4Xh0D7kteD/O8wBCge1xwWurClD72eSodRUTV1WfI2Pn3YTve', 'Akmal', NULL, 'KARYAWAN', '2025-02-27 04:31:37'),
(121, '222', '$2y$10$Jh.k0r8ZUPaIZX0iHrW2he0ZTctXkgLop7xvzKcBTLCoSsblPBoPW', '111', NULL, 'KARYAWAN', '2025-03-11 12:43:27'),
(122, '12', '$2y$10$hvClHNC5WqZ9cMx024jwZ.BKs1QOIiSgDWpy5uF/Wd7PNn4FeCovS', '23', NULL, 'KARYAWAN', '2025-03-13 02:50:49'),
(123, '12111', '$2y$10$vkSigLtVr0oyvfE7Q6Krwu8RqNMJSZakE6yk5lOckD9tKCx2j0Pua', '23', NULL, 'KARYAWAN', '2025-03-13 03:00:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_absensi_ibfk_2` (`karyawan_id`);

--
-- Indexes for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9154;

--
-- AUTO_INCREMENT for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=772;

--
-- AUTO_INCREMENT for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD CONSTRAINT `tb_absensi_ibfk_2` FOREIGN KEY (`karyawan_id`) REFERENCES `tb_karyawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD CONSTRAINT `tb_gaji_ibfk_1` FOREIGN KEY (`karyawan_id`) REFERENCES `tb_karyawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD CONSTRAINT `fk_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `tb_jabatan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 07:05 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_tiket_evanza`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_penerbangan`
--

CREATE TABLE `jadwal_penerbangan` (
  `id_jadwal` int NOT NULL,
  `id_rute` int NOT NULL,
  `waktu_berangkat` time NOT NULL,
  `waktu_tiba` time NOT NULL,
  `harga` int NOT NULL,
  `kapasitas_kursi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_penerbangan`
--

INSERT INTO `jadwal_penerbangan` (`id_jadwal`, `id_rute`, `waktu_berangkat`, `waktu_tiba`, `harga`, `kapasitas_kursi`) VALUES
(1, 1, '13:00:00', '14:00:00', 1000000, 211),
(2, 2, '15:00:00', '16:00:00', 950000, 230),
(4, 8, '13:00:00', '13:30:00', 900000, 174),
(5, 7, '18:00:00', '19:00:00', 1200000, 190),
(6, 1, '11:00:00', '12:00:00', 50000000, 118),
(7, 10, '00:31:00', '12:31:00', 100000, 197),
(8, 11, '00:04:00', '02:44:00', 2000000, 200);

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` int NOT NULL,
  `nama_kota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`) VALUES
(1, 'Jakarta'),
(2, 'Bali'),
(3, 'Surabaya'),
(4, 'Yogyakarta'),
(5, 'Bengkulu'),
(6, 'Lombok'),
(7, 'Aceh'),
(8, 'Banten'),
(10, 'Medan'),
(11, 'Padang'),
(12, 'Malang');

-- --------------------------------------------------------

--
-- Table structure for table `maskapai`
--

CREATE TABLE `maskapai` (
  `id_maskapai` int NOT NULL,
  `logo_maskapai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nama_maskapai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kapasitas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maskapai`
--

INSERT INTO `maskapai` (`id_maskapai`, `logo_maskapai`, `nama_maskapai`, `kapasitas`) VALUES
(1, 'Garuda-Indonesia-Logo.png', 'Garuda Indonesia', 25),
(2, 'AirAsia_New_Logo.svg.png', 'Air Asia', 200),
(3, 'lion.png', 'Lion Air', 150),
(6, 'Qatar_Airways_logo.svg.png', 'Qatar Airways', 200);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int NOT NULL,
  `id_user` int NOT NULL,
  `id_penerbangan` int NOT NULL,
  `id_order` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_tiket` int NOT NULL,
  `total_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `id_user`, `id_penerbangan`, `id_order`, `jumlah_tiket`, `total_harga`) VALUES
(1, 1, 1, '67e0cb6319bb4', 1, 1000000),
(2, 3, 4, '67e0dc4e6c9e5', 10, 9000000),
(3, 3, 7, '67e10bad8c98c', 3, 300000),
(4, 3, 4, '67e10bad8c98c', 5, 4500000),
(5, 3, 6, '67e10ff25777d', 2, 100000000),
(6, 3, 4, '68106ef94b5e3', 10, 9000000),
(7, 3, 6, '68109fcdd6b54', 1, 50000000),
(8, 7, 4, '6810a32446e07', 1, 900000),
(9, 7, 6, '6810b5bace7ad', 2, 100000000),
(10, 7, 1, '6810c83c95d3d', 1, 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `order_tiket`
--

CREATE TABLE `order_tiket` (
  `id_order` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `struk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('proses','Approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tiket`
--

INSERT INTO `order_tiket` (`id_order`, `tanggal_transaksi`, `struk`, `status`) VALUES
('67e0cb6319bb4', '2025-03-24', '88ed3fa4c38dc396af79', 'Approved'),
('67e0dc4e6c9e5', '2025-03-24', '16f8e3f9087ab0f122cd', 'Approved'),
('67e10bad8c98c', '2025-03-24', '691783884912acc68d1b', 'Approved'),
('67e10ff25777d', '2025-03-24', 'fd7205cbebe2710a8ae4', 'Approved'),
('68106ef94b5e3', '2025-04-29', 'acf4e66f9dec9500d07e', 'Approved'),
('68109fcdd6b54', '2025-04-29', '0e2a34cfd4a1055eeba7', 'proses'),
('6810a32446e07', '2025-04-29', '2345758e24f13e6dec6f', 'proses'),
('6810b557d2453', '2025-04-29', 'ef11dc2dcb22a4704aff', 'proses'),
('6810b5ade9f2e', '2025-04-29', '8bdb7d2ae1bc3bf74018', 'proses'),
('6810b5aeb03b7', '2025-04-29', '3f64be672c665a403cc0', 'proses'),
('6810b5bace7ad', '2025-04-29', 'c73a00fb6da3e82106b4', 'proses'),
('6810c83c95d3d', '2025-04-29', '3c213b369317339eeb34', 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `id_rute` int NOT NULL,
  `id_maskapai` int NOT NULL,
  `rute_asal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rute_tujuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pergi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id_rute`, `id_maskapai`, `rute_asal`, `rute_tujuan`, `tanggal_pergi`) VALUES
(1, 1, 'Jakarta', 'Bali', '2024-02-24'),
(2, 2, 'Jakarta', 'Bali', '2024-02-25'),
(3, 3, 'Bali', 'Yogyakarta', '2024-02-24'),
(7, 3, 'Jakarta', 'Bali', '2024-02-24'),
(8, 2, 'Bali', 'Yogyakarta', '2024-02-24'),
(10, 2, 'Malang', 'Jakarta', '2025-03-24'),
(11, 6, 'Malang', 'Padang', '2025-03-24'),
(12, 6, 'Lombok', 'Aceh', '2025-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `roles` enum('Admin','Petugas','Penumpang') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `nama_lengkap`, `password`, `roles`) VALUES
(1, 'rendiadmin', 'Rendi Admin', 'rendiadmin', 'Admin'),
(2, 'rendipetugas', 'Rendi Petugas', 'rendipetugas', 'Petugas'),
(3, 'rendiuser', 'Rendi User', 'rendiuser', 'Penumpang'),
(6, 'teshhh', 'teshhh', 'teshh', 'Petugas'),
(7, 'evan', 'evanza putra', 'evanza123', 'Penumpang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_rute` (`id_rute`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indexes for table `maskapai`
--
ALTER TABLE `maskapai`
  ADD PRIMARY KEY (`id_maskapai`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_penerbangan` (`id_penerbangan`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `order_tiket`
--
ALTER TABLE `order_tiket`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id_rute`),
  ADD KEY `id_maskapai` (`id_maskapai`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id_kota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `maskapai`
--
ALTER TABLE `maskapai`
  MODIFY `id_maskapai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `id_rute` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  ADD CONSTRAINT `jadwal_penerbangan_ibfk_1` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id_rute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`id_penerbangan`) REFERENCES `jadwal_penerbangan` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `order_tiket` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rute`
--
ALTER TABLE `rute`
  ADD CONSTRAINT `rute_ibfk_1` FOREIGN KEY (`id_maskapai`) REFERENCES `maskapai` (`id_maskapai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

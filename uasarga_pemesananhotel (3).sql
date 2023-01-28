-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221125.2e001c186a
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2022 at 04:43 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uasarga_pemesananhotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` varchar(20) NOT NULL,
  `password` binary(16) NOT NULL,
  `tipeakun` enum('tamu','admin','resepsionis') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `password`, `tipeakun`) VALUES
('useradmin', 0x87609bba68062a90bf47467b643ec9a4, 'admin'),
('userresepsionis', 0xc12a3ecf90ec740dc7e20e5c96c52b0c, 'resepsionis'),
('usertamu', 0xc28147ca62523c7582790a7d64ee311c, 'tamu');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitashotel`
--

CREATE TABLE `fasilitashotel` (
  `namafasilitas` varchar(25) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `gambar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fasilitashotel`
--

INSERT INTO `fasilitashotel` (`namafasilitas`, `keterangan`, `gambar`) VALUES
('Gym', 'Lantai 1 sebelah kolam renang', 'fasilitasgym.jpg'),
('Kolam Renang', 'Lantai 1 berukuran 250m x 500m', 'fasilitaskolamrenang.jpg'),
('Restoran', 'Berada di lantai 1 dengan 100 kursi dan 50 meja', 'fasilitasrestoran.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitaskamar`
--

CREATE TABLE `fasilitaskamar` (
  `kamar_tipekamar` varchar(10) NOT NULL,
  `namafasilitas` varchar(50) NOT NULL,
  `id_fasilitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fasilitaskamar`
--

INSERT INTO `fasilitaskamar` (`kamar_tipekamar`, `namafasilitas`, `id_fasilitas`) VALUES
('Superior', 'Kamar berukuran luas 32 m', 1),
('Superior', 'Kamar mandi shower', 2),
('Superior', 'Coffee Maker', 3),
('Superior', 'AC', 4),
('Superior', 'LED TV 32 inch', 5),
('Deluxe', 'Kamar berukuran luas 45 m', 6),
('Deluxe', 'Kamar mandi shower dan Bath Tub', 7),
('Deluxe', 'Coffee Maker', 8),
('Deluxe', 'Sofa', 9),
('Deluxe', 'LED TV 40 inch', 10),
('Deluxe', 'AC', 11);

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `tipekamar` varchar(10) NOT NULL,
  `jumlahkamar` int(11) NOT NULL,
  `gambar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`tipekamar`, `jumlahkamar`, `gambar`) VALUES
('Deluxe', 40, 'kamardeluxe.jpg'),
('Superior', 32, 'kamarsuperior.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `namapemesanan` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `nohandphone` varchar(13) NOT NULL,
  `namatamu` varchar(25) NOT NULL,
  `kamar_tipekamar` varchar(10) NOT NULL,
  `tanggalcekin` date NOT NULL,
  `tanggalcekout` date NOT NULL,
  `jumlahkamar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`namapemesanan`, `email`, `nohandphone`, `namatamu`, `kamar_tipekamar`, `tanggalcekin`, `tanggalcekout`, `jumlahkamar`) VALUES
('pesan-arga', 'arga@email.com', '081234567890', 'Arga', 'Deluxe', '2022-12-06', '2022-12-06', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `fasilitashotel`
--
ALTER TABLE `fasilitashotel`
  ADD PRIMARY KEY (`namafasilitas`);

--
-- Indexes for table `fasilitaskamar`
--
ALTER TABLE `fasilitaskamar`
  ADD PRIMARY KEY (`id_fasilitas`),
  ADD KEY `fasilitaskamar_kamar_fk` (`kamar_tipekamar`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`tipekamar`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`namapemesanan`),
  ADD KEY `pemesanan_kamar_fk` (`kamar_tipekamar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasilitaskamar`
--
ALTER TABLE `fasilitaskamar`
  MODIFY `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fasilitaskamar`
--
ALTER TABLE `fasilitaskamar`
  ADD CONSTRAINT `fasilitaskamar_kamar_fk` FOREIGN KEY (`kamar_tipekamar`) REFERENCES `kamar` (`tipekamar`) ON DELETE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_kamar_fk` FOREIGN KEY (`kamar_tipekamar`) REFERENCES `kamar` (`tipekamar`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

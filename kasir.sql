-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 08:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_produk`, `qty`, `created_at`) VALUES
(5, 69, 10, 3, '2024-01-31 20:23:22'),
(6, 69, 11, 2, '2024-01-31 20:23:22'),
(7, 70, 10, 4, '2024-01-31 20:24:20'),
(8, 70, 11, 3, '2024-01-31 20:24:20'),
(9, 71, 10, 1, '2024-02-15 09:06:37'),
(10, 71, 11, 2, '2024-02-15 09:06:37'),
(11, 72, 10, 1, '2024-02-15 09:24:58'),
(12, 72, 11, 2, '2024-02-15 09:24:58'),
(13, 73, 10, 2, '2024-02-15 11:14:29'),
(14, 74, 10, 2, '2024-02-15 12:14:42'),
(15, 74, 11, 1, '2024-02-15 12:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `kategori`) VALUES
(4, 'Makanan Berat'),
(5, 'Minuman'),
(6, 'Snack'),
(7, 'Topping'),
(8, 'Bahan Baku');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` set('Pria','Wanita','Lainya') NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `alamat`, `telepon`) VALUES
(4, 'Pria', 'Pria', 'Jakarta', '081234567890'),
(5, 'Wanita', 'Wanita', 'Jakarta', '081234567891');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`, `role`) VALUES
(1, 'admin', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', 'Admin', '1'),
(6, 'ariel', '$2y$10$2Ufb.IB4hOAWJEum.GeDPuHiOdz5dHzJnqG0Zh4zCDGEzXCrrCCiu', 'Ariel Adhidevara', '2'),
(7, 'kasir', '$2y$10$DRzKnHgc9dYJW9lj56Wf0ePTfgHYKmny.nNrcGAu6hXbO9Qu3YTRK', 'kasir', '2');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori` int(11) NOT NULL,
  `satuan` int(11) NOT NULL,
  `harga` varchar(10) NOT NULL,
  `stok` int(11) NOT NULL,
  `terjual` varchar(10) NOT NULL,
  `imageUrl` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `nama_produk`, `kategori`, `satuan`, `harga`, `stok`, `terjual`, `imageUrl`) VALUES
(11, 'S1', 'French Fries', 6, 4, '8000', 10, '1', NULL),
(12, 'S2', 'Nugget', 6, 4, '8000', 0, '', NULL),
(13, 'S3', 'Sosis', 6, 4, '8000', 0, '', NULL),
(14, 'S4', 'Omelet', 6, 4, '8000', 0, '', NULL),
(15, 'S5', 'Otak-Otak', 6, 4, '8000', 0, '', NULL),
(16, 'Ma1', 'Mie Goreng', 4, 4, '6000', 0, '', NULL),
(17, 'Ma2', 'Mie Rebus', 4, 4, '6000', 0, '', NULL),
(18, 'Ma3', 'Mie Nyemek', 4, 4, '10000', 0, '', NULL),
(19, 'Ma4', 'Mie Nyemek Jumbo', 4, 4, '11000', 0, '', NULL),
(20, 'Ma5', 'Mie Dok Dok', 4, 4, '10000', 0, '', NULL),
(21, 'Ma6', 'Mie Dok Dok Jumbo', 4, 4, '11000', 0, '', NULL),
(22, 'Ma7', 'Nasi Goreng', 4, 4, '10000', 0, '', NULL),
(23, 'Ma8', 'Nasi Sarden', 4, 4, '8000', 0, '', NULL),
(24, 'Ma9', 'Nasi Telor', 4, 4, '8000', 0, '', NULL),
(25, 'Ma10', 'Nasi Telor Orak-Arik', 4, 4, '8000', 0, '', NULL),
(26, 'Ma11', 'Nasi Oseng', 4, 4, '8000', 0, '', NULL),
(27, 'Ma12', 'Magelangan', 4, 4, '12000', 0, '', NULL),
(28, 'Ma13', 'Nasi Putih', 4, 4, '3000', 0, '', NULL),
(29, 'To1', 'Sosis', 7, 4, '3000', 0, '', NULL),
(30, 'To2', 'Nugget', 7, 4, '4000', 0, '', NULL),
(31, 'To3', 'Telor', 7, 4, '3000', 0, '', NULL),
(32, 'To4', 'Bakso', 7, 4, '3000', 0, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `satuan_produk`
--

CREATE TABLE `satuan_produk` (
  `id` int(11) NOT NULL,
  `satuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_produk`
--

INSERT INTO `satuan_produk` (`id`, `satuan`) VALUES
(4, 'Pcs'),
(5, 'Porsi');

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` int(11) NOT NULL,
  `jumlah` varchar(10) NOT NULL,
  `Keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` int(11) NOT NULL,
  `jumlah` varchar(11) NOT NULL,
  `keterangan` varchar(10) NOT NULL,
  `supplier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id`, `tanggal`, `barcode`, `jumlah`, `keterangan`, `supplier`) VALUES
(14, '2024-01-31 14:10:59', 10, '30', 'penambahan', 3),
(15, '2024-01-31 14:11:09', 11, '20', 'penambahan', 3);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `telepon`, `keterangan`) VALUES
(3, 'Pasar', 'Pasar', '081231827391', 'Beli di Pasar');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `nama`, `alamat`) VALUES
(1, 'Warkopmie Berdikari', 'Jl Kabut, Surakarta');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `total_bayar` varchar(10) NOT NULL,
  `jumlah_uang` varchar(10) NOT NULL,
  `diskon` varchar(10) NOT NULL,
  `pelanggan` int(11) DEFAULT NULL,
  `nota` varchar(15) NOT NULL,
  `kasir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `total_bayar`, `jumlah_uang`, `diskon`, `pelanggan`, `nota`, `kasir`) VALUES
(69, '2024-01-31 20:23:17', '34000', '40000', '', 4, 'Q3CDES1V59UILE5', 1),
(70, '2024-01-31 20:24:16', '47000', '50000', '', 5, '4B8REN9FHARNLK1', 1),
(71, '2024-02-15 09:06:25', '18000', '20000', '', 4, 'VU6U7VJ1UAIT7K8', 7),
(72, '2024-02-15 09:24:31', '18000', '20000', '', 4, 'IYH9PT3X0ZM2FZ4', 1),
(73, '2024-02-15 11:14:17', '16000', '20000', '', 0, '0A2UZ0EYF2DWNPM', 1),
(74, '2024-02-15 12:13:59', '24000', '50000', '', 0, 'L0DZHMOT4F3XCBO', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

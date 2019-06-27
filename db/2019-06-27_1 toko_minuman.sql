-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2019 at 01:52 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_minuman`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bahan`
--

CREATE TABLE `tb_bahan` (
  `id_bahan` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `nama` varchar(255) NOT NULL,
  `stok` decimal(11,2) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bahan`
--

INSERT INTO `tb_bahan` (`id_bahan`, `created_at`, `updated_at`, `nama`, `stok`, `satuan`) VALUES
(4, '2019-06-24 16:36:52', '2019-06-26 15:58:39', 'Gula', '8.50', 'kg'),
(5, '2019-06-25 15:48:48', '2019-06-26 15:54:31', 'aaa', '18.80', 'kg'),
(6, '2019-06-26 00:56:24', '2019-06-26 00:56:24', 'Bahan Multi 1', '0.00', 'kg1'),
(7, '2019-06-26 00:56:24', '2019-06-26 00:56:24', 'Bahan multi 2', '1.95', 'kg2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bahan_produk`
--

CREATE TABLE `tb_bahan_produk` (
  `id_bahan_produk` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `jumlah` decimal(5,2) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `id_bahan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bahan_produk`
--

INSERT INTO `tb_bahan_produk` (`id_bahan_produk`, `created_at`, `jumlah`, `id_produk`, `id_bahan`) VALUES
(1, '2019-06-27 06:42:47', '0.00', 22, 5),
(2, '2019-06-27 06:44:07', '0.05', 23, 5),
(3, '2019-06-27 06:47:09', '0.01', 24, 7),
(4, '2019-06-27 06:47:09', '0.10', 24, 6),
(5, '2019-06-27 06:47:09', '0.05', 24, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_penggunaan_bahan`
--

CREATE TABLE `tb_penggunaan_bahan` (
  `id_penggunaan_bahan` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `id_bahan` int(10) NOT NULL,
  `id_bahan_produk` int(10) NOT NULL,
  `jumlah` decimal(3,2) NOT NULL,
  `satuan` varchar(5) NOT NULL,
  `keterangan` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_penggunaan_bahan`
--

INSERT INTO `tb_penggunaan_bahan` (`id_penggunaan_bahan`, `created_at`, `id_bahan`, `id_bahan_produk`, `jumlah`, `satuan`, `keterangan`) VALUES
(1, '2019-06-25 14:23:20', 4, 0, '1.00', 'kg', ''),
(2, '2019-06-27 06:42:47', 5, 1, '0.00', 'kg', 'Untuk Teh Gula Batu'),
(3, '2019-06-27 06:44:07', 5, 2, '0.10', 'kg', 'Untuk Teh Gula Batu'),
(4, '2019-06-27 06:47:09', 7, 3, '0.05', 'kg2', 'Untuk Teh Dingin'),
(5, '2019-06-27 06:47:09', 6, 4, '1.00', 'kg1', 'Untuk Teh Dingin'),
(6, '2019-06-27 06:47:09', 4, 5, '0.50', 'kg', 'Untuk Teh Dingin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` bigint(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(15) NOT NULL,
  `stok` int(5) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `created_at`, `updated_at`, `nama`, `harga`, `stok`, `img`) VALUES
(1, '2019-04-24 16:59:32', '0000-00-00 00:00:00', 'Teh Botol Sosro', 5000, 0, 'produk28220190424165932'),
(2, '2019-04-24 17:13:12', '2019-06-26 16:53:41', 'Teh Botol Sosro', 5000, 3, 'produk70320190424171312'),
(3, '2019-04-24 17:14:29', '2019-06-26 16:53:41', 'Teh Botol Sosro', 5000, 22, 'produk65620190424171429'),
(4, '2019-04-24 17:15:35', '0000-00-00 00:00:00', 'Teh Botol Sosro', 5000, 2, 'produk32920190424171535'),
(5, '2019-04-29 16:30:58', '2019-06-26 01:52:39', 'Teh Botol Sosro 1', 5001, 1, 'produk94820190424171843.jpeg'),
(6, '2019-04-25 15:57:13', '2019-06-26 17:12:56', 'Teh Botol Sosro', 7000, 0, 'produk86420190425155713.jpeg'),
(7, '2019-04-25 15:57:51', '0000-00-00 00:00:00', 'Teh Botol Sosro', 7000, 2, 'produk21620190425155751.jpeg'),
(8, '2019-04-29 17:09:15', '2019-06-26 17:12:56', 'Teh Botol Sosro', 5000, 2, 'produk14220190426172651.jpeg'),
(9, '2019-06-17 16:47:46', '2019-06-26 01:52:39', 'Teh 1', 10000, 2, 'produk36720190617164746.png'),
(10, '2019-06-27 06:32:25', '2019-06-27 06:32:25', 'Teh Gula Batu', 10000, 5, 'produk48720190627063225.png'),
(11, '2019-06-27 06:33:24', '2019-06-27 06:33:24', 'Teh Gula Batu', 10000, 2, 'produk47620190627063324.png'),
(12, '2019-06-27 06:34:29', '2019-06-27 06:34:29', 'Teh Gula Batu', 10000, 2, 'produk98520190627063429.png'),
(13, '2019-06-27 06:35:02', '2019-06-27 06:35:02', 'Teh Gula Batu', 10000, 3, 'produk60020190627063502.png'),
(14, '2019-06-27 06:37:26', '2019-06-27 06:37:26', 'Teh Gula Batu', 10000, 3, 'produk92620190627063726.png'),
(15, '2019-06-27 06:37:55', '2019-06-27 06:37:55', 'Teh Gula Batu', 10000, 3, 'produk51020190627063755.png'),
(16, '2019-06-27 06:38:15', '2019-06-27 06:38:15', 'Teh Gula Batu', 10000, 3, 'produk31120190627063815.png'),
(17, '2019-06-27 06:38:19', '2019-06-27 06:38:19', 'Teh Gula Batu', 10000, 3, 'produk60020190627063819.png'),
(18, '2019-06-27 06:40:32', '2019-06-27 06:40:32', 'Teh Gula Batu', 10000, 3, 'produk97220190627064032.png'),
(19, '2019-06-27 06:40:49', '2019-06-27 06:40:49', 'Teh Gula Batu', 10000, 3, 'produk24820190627064049.png'),
(20, '2019-06-27 06:41:10', '2019-06-27 06:41:10', 'Teh Gula Batu', 10000, 3, 'produk38020190627064110.png'),
(21, '2019-06-27 06:42:03', '2019-06-27 06:42:03', 'Teh Gula Batu', 10000, 3, 'produk42420190627064203.png'),
(22, '2019-06-27 06:42:47', '2019-06-27 06:42:47', 'Teh Gula Batu', 10000, 2, 'produk70420190627064247.png'),
(23, '2019-06-27 06:44:07', '2019-06-27 06:44:07', 'Teh Gula Batu', 10000, 2, 'produk10220190627064407.png'),
(24, '2019-06-27 06:47:09', '2019-06-27 06:47:09', 'Teh Dingin', 10000, 10, 'produk94820190627064709.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `created_at`, `nama`, `alamat`, `telp`) VALUES
(1, '2019-06-16 16:08:37', 'Pabrik Gula no 1 Indonesia', 'AAAA', ''),
(2, '2019-06-16 16:09:28', 'Pabrik Gula no 1 Indonesia', 'AAAA', ''),
(3, '2019-06-17 17:01:10', 'Supplier Gula No 3', 'Di situ', '08712222222'),
(4, '2019-06-17 17:02:36', 'Supplier Gula No 3', 'Di situ', '08712222222'),
(5, '2019-06-17 17:03:51', 'Supplier Gula No 4', 'Di rumah', '093021');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_beli`
--

CREATE TABLE `tb_transaksi_beli` (
  `id_transaksi_beli` int(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `total_harga` int(10) NOT NULL,
  `id_supplier` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi_beli`
--

INSERT INTO `tb_transaksi_beli` (`id_transaksi_beli`, `created_at`, `total_harga`, `id_supplier`) VALUES
(14, '2019-06-24 16:36:52', 10000, 3),
(15, '2019-06-24 16:37:16', 15000, 3),
(16, '2019-06-24 16:48:41', 100000, 3),
(17, '2019-06-25 15:48:48', 10000, 2),
(18, '2019-06-26 00:39:03', 0, 2),
(19, '2019-06-26 00:52:38', 0, 2),
(20, '2019-06-26 00:53:40', 0, 3),
(21, '2019-06-26 00:56:24', 30000, 4),
(22, '2019-06-26 15:53:45', 15000, 3),
(23, '2019-06-26 15:54:31', 15000, 3),
(24, '2019-06-26 15:55:25', 15000, 2),
(25, '2019-06-26 15:58:39', 15000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_beli_detail`
--

CREATE TABLE `tb_transaksi_beli_detail` (
  `id_detail` int(10) NOT NULL,
  `id_transaksi_beli` int(10) NOT NULL,
  `id_bahan` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `satuan` varchar(5) NOT NULL,
  `harga` int(10) NOT NULL,
  `total_harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi_beli_detail`
--

INSERT INTO `tb_transaksi_beli_detail` (`id_detail`, `id_transaksi_beli`, `id_bahan`, `jumlah`, `satuan`, `harga`, `total_harga`) VALUES
(2, 14, 4, 1, 'kg', 10000, 10000),
(3, 15, 4, 4, 'kg', 3750, 15000),
(4, 16, 4, 10, 'kg', 10000, 100000),
(5, 17, 5, 1, 'kg', 10000, 10000),
(6, 21, 6, 1, 'kg1', 10000, 10000),
(7, 21, 7, 2, 'kg2', 10000, 20000),
(8, 22, 5, 3, 'kg', 5000, 15000),
(9, 23, 5, 15, 'kg', 1000, 15000),
(10, 24, 4, 1, 'kg', 15000, 15000),
(11, 25, 4, 4, 'kg', 3750, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_jual`
--

CREATE TABLE `tb_transaksi_jual` (
  `id_transaksi_jual` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `total_harga` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi_jual`
--

INSERT INTO `tb_transaksi_jual` (`id_transaksi_jual`, `created_at`, `total_harga`, `id_user`, `nama`, `alamat`) VALUES
(10, '2019-06-25 15:53:12', 10000, 1, 'Si B', 'AA'),
(11, '2019-06-25 16:17:05', 10000, 3, 'Akun Test', 'rumah'),
(12, '2019-06-26 01:52:39', 25001, 1, 'Rahasia', 'Rhs'),
(13, '2019-06-26 16:53:41', 10000, 1, 'Teh', 'q'),
(14, '2019-06-26 17:12:56', 24000, 3, 'Akun Test', 'rumah');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_jual_detail`
--

CREATE TABLE `tb_transaksi_jual_detail` (
  `id_detail` int(10) NOT NULL,
  `id_transaksi_jual` int(10) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `harga` int(10) NOT NULL,
  `total_harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi_jual_detail`
--

INSERT INTO `tb_transaksi_jual_detail` (`id_detail`, `id_transaksi_jual`, `id_produk`, `jumlah`, `harga`, `total_harga`) VALUES
(1, 10, 2, 2, 5000, 10000),
(2, 11, 2, 2, 5000, 10000),
(3, 12, 5, 1, 5001, 5001),
(4, 12, 9, 2, 10000, 20000),
(5, 13, 2, 1, 5000, 5000),
(6, 13, 3, 1, 5000, 5000),
(7, 14, 8, 2, 5000, 10000),
(8, 14, 6, 2, 7000, 14000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` char(1) NOT NULL COMMENT 'A = admin, M = member',
  `email` varchar(100) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `created_at`, `nama`, `level`, `email`, `telp`, `password`, `alamat`) VALUES
(1, '2019-04-21 20:57:00', 'Admin', 'A', 'admin@gmail.com', '812345678', 'fcea920f7412b5da7be0cf42b8c93759', ''),
(3, '2019-04-25 17:27:00', 'Akun Test', 'M', 'email@gmail.com', '123456789', 'fcea920f7412b5da7be0cf42b8c93759', 'rumah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bahan`
--
ALTER TABLE `tb_bahan`
  ADD PRIMARY KEY (`id_bahan`);

--
-- Indexes for table `tb_bahan_produk`
--
ALTER TABLE `tb_bahan_produk`
  ADD PRIMARY KEY (`id_bahan_produk`);

--
-- Indexes for table `tb_penggunaan_bahan`
--
ALTER TABLE `tb_penggunaan_bahan`
  ADD PRIMARY KEY (`id_penggunaan_bahan`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tb_transaksi_beli`
--
ALTER TABLE `tb_transaksi_beli`
  ADD PRIMARY KEY (`id_transaksi_beli`);

--
-- Indexes for table `tb_transaksi_beli_detail`
--
ALTER TABLE `tb_transaksi_beli_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_transaksi_jual`
--
ALTER TABLE `tb_transaksi_jual`
  ADD PRIMARY KEY (`id_transaksi_jual`);

--
-- Indexes for table `tb_transaksi_jual_detail`
--
ALTER TABLE `tb_transaksi_jual_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telp` (`telp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_bahan`
--
ALTER TABLE `tb_bahan`
  MODIFY `id_bahan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_bahan_produk`
--
ALTER TABLE `tb_bahan_produk`
  MODIFY `id_bahan_produk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_penggunaan_bahan`
--
ALTER TABLE `tb_penggunaan_bahan`
  MODIFY `id_penggunaan_bahan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_transaksi_beli`
--
ALTER TABLE `tb_transaksi_beli`
  MODIFY `id_transaksi_beli` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_transaksi_beli_detail`
--
ALTER TABLE `tb_transaksi_beli_detail`
  MODIFY `id_detail` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_transaksi_jual`
--
ALTER TABLE `tb_transaksi_jual`
  MODIFY `id_transaksi_jual` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_transaksi_jual_detail`
--
ALTER TABLE `tb_transaksi_jual_detail`
  MODIFY `id_detail` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

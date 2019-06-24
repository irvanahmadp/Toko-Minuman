-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2019 at 05:30 PM
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
  `stok` int(11) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bahan`
--

INSERT INTO `tb_bahan` (`id_bahan`, `created_at`, `updated_at`, `nama`, `stok`, `satuan`) VALUES
(4, '2019-06-24 16:36:52', '2019-06-24 17:16:08', 'Gula', 5, 'kg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penggunaan_bahan`
--

CREATE TABLE `tb_penggunaan_bahan` (
  `id_penggunaan_bahan` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `id_bahan` int(10) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `satuan` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(2, '2019-04-24 17:13:12', '2019-06-23 11:10:04', 'Teh Botol Sosro', 5000, 8, 'produk70320190424171312'),
(3, '2019-04-24 17:14:29', '2019-06-23 10:21:29', 'Teh Botol Sosro', 5000, 23, 'produk65620190424171429'),
(4, '2019-04-24 17:15:35', '0000-00-00 00:00:00', 'Teh Botol Sosro', 5000, 2, 'produk32920190424171535'),
(5, '2019-04-29 16:30:58', '0000-00-00 00:00:00', 'Teh Botol Sosro 1', 5001, 2, 'produk94820190424171843.jpeg'),
(6, '2019-04-25 15:57:13', '0000-00-00 00:00:00', 'Teh Botol Sosro', 7000, 2, 'produk86420190425155713.jpeg'),
(7, '2019-04-25 15:57:51', '0000-00-00 00:00:00', 'Teh Botol Sosro', 7000, 2, 'produk21620190425155751.jpeg'),
(8, '2019-04-29 17:09:15', '0000-00-00 00:00:00', 'Teh Botol Sosro', 5000, 4, 'produk14220190426172651.jpeg'),
(9, '2019-06-17 16:47:46', '2019-06-17 16:48:23', 'Teh 1', 10000, 4, 'produk36720190617164746.png');

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
(16, '2019-06-24 16:48:41', 100000, 3);

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
(4, 16, 4, 10, 'kg', 10000, 100000);

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
  MODIFY `id_bahan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_penggunaan_bahan`
--
ALTER TABLE `tb_penggunaan_bahan`
  MODIFY `id_penggunaan_bahan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_transaksi_beli`
--
ALTER TABLE `tb_transaksi_beli`
  MODIFY `id_transaksi_beli` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_transaksi_beli_detail`
--
ALTER TABLE `tb_transaksi_beli_detail`
  MODIFY `id_detail` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_transaksi_jual`
--
ALTER TABLE `tb_transaksi_jual`
  MODIFY `id_transaksi_jual` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_transaksi_jual_detail`
--
ALTER TABLE `tb_transaksi_jual_detail`
  MODIFY `id_detail` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2019 at 04:36 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

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
  `tanggal_key` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(255) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat_supplier` varchar(255) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `satuan` varchar(35) NOT NULL,
  `harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bahan`
--

INSERT INTO `tb_bahan` (`id_bahan`, `tanggal_key`, `tanggal`, `nama`, `nama_supplier`, `alamat_supplier`, `jumlah`, `satuan`, `harga`) VALUES
(1, '2019-05-05 14:12:13', '2019-05-05 16:12:13', 'Gula', '', '', 1, 'kg', 0),
(2, '2019-05-05 14:53:04', '2019-05-05 16:53:04', 'Gula', 'Pabrik Gula No 1 Indonesia', '', 2, 'kg', 20000),
(3, '2019-05-05 14:53:53', '2019-05-05 16:53:53', 'Gula', 'Pabrik Gula No 1 Indonesia', '', 2, 'kg', 20000),
(4, '2019-05-05 14:55:11', '2019-05-05 16:55:11', 'Gula', 'Pabrik Gula No 1 Indonesia', 'Bumi', 2, 'kg', 20000),
(5, '2019-05-05 15:12:03', '2019-05-05 17:12:03', 'Gula', 'Pabrik Gula No 1 Indonesia', '', 2, 'kg', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` bigint(15) NOT NULL,
  `tanggal_key` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal` datetime NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(15) NOT NULL,
  `stok` int(5) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `tanggal_key`, `tanggal`, `nama`, `harga`, `stok`, `img`) VALUES
(1, '2019-04-24 14:59:32', '2019-04-24 16:59:32', 'Teh Botol Sosro', 5000, 1, 'produk28220190424165932'),
(2, '2019-04-24 15:13:12', '2019-04-24 17:13:12', 'Teh Botol Sosro', 5000, 25, 'produk70320190424171312'),
(3, '2019-04-24 15:14:29', '2019-04-24 17:14:29', 'Teh Botol Sosro', 5000, 25, 'produk65620190424171429'),
(4, '2019-04-24 15:15:35', '2019-04-24 17:15:35', 'Teh Botol Sosro', 5000, 2, 'produk32920190424171535'),
(5, '2019-04-24 15:18:43', '2019-04-29 16:30:58', 'Teh Botol Sosro 1', 5001, 2, 'produk94820190424171843.jpeg'),
(6, '2019-04-25 13:57:13', '2019-04-25 15:57:13', 'Teh Botol Sosro', 7000, 2, 'produk86420190425155713.jpeg'),
(7, '2019-04-25 13:57:51', '2019-04-25 15:57:51', 'Teh Botol Sosro', 7000, 2, 'produk21620190425155751.jpeg'),
(8, '2019-04-26 15:26:51', '2019-04-29 17:09:15', 'Teh Botol Sosro', 5000, 4, 'produk14220190426172651.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(10) NOT NULL,
  `tanggal_key` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal` datetime NOT NULL,
  `id_user` int(10) NOT NULL,
  `type` enum('produk','bahan') NOT NULL COMMENT 'Produk = produk, bahan = bahan',
  `id_produk` int(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `debit` int(10) NOT NULL DEFAULT '0' COMMENT 'Pengeluaran toko atau ketika membeli dari supplier',
  `credit` int(10) NOT NULL DEFAULT '0' COMMENT 'Pemasukan toko atau pembelian oleh konsumen',
  `nama` varchar(255) NOT NULL COMMENT 'Untuk menyimpan data berupa nama supplier atau nama pelanggan ketika pembelian dilakukan secara langsung',
  `alamat` varchar(255) NOT NULL COMMENT 'alamat supplier atau alamat pembeli',
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `tanggal_key`, `tanggal`, `id_user`, `type`, `id_produk`, `jumlah`, `debit`, `credit`, `nama`, `alamat`, `keterangan`) VALUES
(9, '2019-05-05 14:12:13', '2019-05-05 16:12:13', 1, 'bahan', 1, 1, 10000, 0, '', '', 'Pembelian bahan'),
(10, '2019-05-05 14:53:04', '2019-05-05 16:53:04', 1, 'bahan', 2, 2, 20000, 0, '', '', 'Pembelian bahan'),
(11, '2019-05-05 14:53:53', '2019-05-05 16:53:53', 1, 'bahan', 3, 2, 20000, 0, '', '', 'Pembelian bahan'),
(12, '2019-05-05 14:55:11', '2019-05-05 16:55:11', 1, 'bahan', 4, 2, 20000, 0, '', '', 'Pembelian bahan'),
(13, '2019-05-05 15:12:03', '2019-05-05 17:12:03', 1, 'bahan', 5, 2, 20000, 0, 'Pabrik Gula No 1 Indonesia', '', 'Pembelian bahan'),
(14, '2019-05-06 15:18:45', '2019-05-06 00:00:00', 1, 'produk', 0, 3, 0, 15, 'Bela', '', 'Penjualan Produk'),
(15, '2019-05-06 15:19:34', '2019-05-06 00:00:00', 1, 'produk', 1, 3, 0, 15, 'Bela', '', 'Penjualan Produk'),
(16, '2019-05-06 15:20:08', '2019-05-06 00:00:00', 1, 'produk', 1, 3, 0, 15, 'Bela', 'Rumah', 'Penjualan Produk'),
(17, '2019-05-06 15:21:56', '2019-05-06 00:00:00', 1, 'produk', 1, 3, 0, 15000, 'Bela', 'Rumah', 'Penjualan Produk'),
(18, '2019-05-06 15:22:48', '2019-05-06 00:00:00', 1, 'produk', 1, 3, 0, 15000, 'Bela', 'Rumah', 'Penjualan Produk'),
(19, '2019-05-06 15:26:10', '2019-05-06 00:00:00', 1, 'produk', 1, 3, 0, 15000, 'Hoho', '', 'Penjualan Produk'),
(20, '2019-05-06 15:28:11', '2019-05-06 00:00:00', 3, 'produk', 1, 1, 0, 5000, 'Akun Test', 'Dihatimu', 'Penjualan Produk'),
(21, '2019-05-06 15:28:30', '2019-05-06 00:00:00', 3, 'produk', 1, 20, 0, 100000, 'Akun Test', 'AAA', 'Penjualan Produk');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(10) NOT NULL,
  `tanggal_key` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal` datetime NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` char(1) NOT NULL COMMENT 'A = admin, M = member',
  `email` varchar(100) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `tanggal_key`, `tanggal`, `nama`, `level`, `email`, `telp`, `password`) VALUES
(1, '2019-04-21 13:58:46', '2019-04-21 20:57:00', 'Admin', 'A', 'admin@gmail.com', '812345678', 'fcea920f7412b5da7be0cf42b8c93759'),
(3, '2019-04-25 15:27:01', '2019-04-25 17:27:00', 'Akun Test', 'M', 'email@gmail.com', '123456789', 'fcea920f7412b5da7be0cf42b8c93759');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bahan`
--
ALTER TABLE `tb_bahan`
  ADD PRIMARY KEY (`id_bahan`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

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
  MODIFY `id_bahan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_transaksi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

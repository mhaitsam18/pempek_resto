-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2021 at 10:45 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pempek_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `agama`
--

CREATE TABLE `agama` (
  `id` int(11) NOT NULL,
  `agama` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agama`
--

INSERT INTO `agama` (`id`, `agama`) VALUES
(1, 'Islam'),
(2, 'Kristen Protestan'),
(3, 'Kristen Katolik'),
(4, 'Budha'),
(5, 'Hindu');

-- --------------------------------------------------------

--
-- Table structure for table `beban`
--

CREATE TABLE `beban` (
  `id` int(11) NOT NULL,
  `nama_beban` varchar(128) NOT NULL,
  `biaya_beban` float(16,2) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beban`
--

INSERT INTO `beban` (`id`, `nama_beban`, `biaya_beban`, `tanggal`) VALUES
(1, 'Biaya Transportasi', 20000.00, '2021-06-08'),
(2, 'Bayar Listrik', 30000.00, '2021-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_transfer`
--

CREATE TABLE `bukti_transfer` (
  `id` int(11) NOT NULL,
  `id_checkout` int(11) NOT NULL,
  `id_rekening_tujuan` int(11) NOT NULL,
  `rekening_pengirim` varchar(128) NOT NULL,
  `bank_pengirim` varchar(100) NOT NULL,
  `nama_pengirim` varchar(128) NOT NULL,
  `waktu_transfer` datetime NOT NULL,
  `nominal_transfer` float(14,2) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bukti_transfer`
--

INSERT INTO `bukti_transfer` (`id`, `id_checkout`, `id_rekening_tujuan`, `rekening_pengirim`, `bank_pengirim`, `nama_pengirim`, `waktu_transfer`, `nominal_transfer`, `bukti_pembayaran`, `catatan`, `status`) VALUES
(1, 1, 2, '0123', 'BNI', 'Olga Paurenta', '2021-04-02 17:57:00', 2000000.00, 'Olga_Paurenta.png', 'makasih yak', 'Pembayaran tidak%20valid'),
(2, 1, 2, '012345', 'BNI', 'Olga Paurenta', '2021-04-02 17:57:00', 2000000.00, 'Olga_Paurenta1.png', 'makasih yak', 'Pembayaran valid'),
(3, 3, 1, '1203129039213', 'BNI', 'Hariadi Arfah', '2021-04-14 23:52:00', 207000.00, '0.jpg', 'makasih ya', 'Pembayaran tidak%20valid'),
(4, 5, 1, '1203129039213', 'BNI', 'Olga Paurenta', '2021-04-15 11:10:00', 12000.00, 'pempek.jpg', 'oke', 'Pembayaran valid'),
(5, 6, 1, '821982173', 'BNI', 'Olga Paurenta', '2021-04-08 17:28:00', 12000.00, 'foto.jpg', '', 'Pembayaran valid');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_bayar` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `no_hp_penerima` varchar(50) NOT NULL,
  `alamat_penerima` varchar(255) NOT NULL,
  `id_kurir` int(11) NOT NULL,
  `total_harga` float(14,2) NOT NULL,
  `waktu_pemesanan` datetime NOT NULL,
  `id_metode_bayar` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id`, `id_user`, `kode_bayar`, `nama_penerima`, `no_hp_penerima`, `alamat_penerima`, `id_kurir`, `total_harga`, `waktu_pemesanan`, `id_metode_bayar`, `status`) VALUES
(2, 1, '4102FE967A078974F3C1E7E262F35496', 'Olga Paurenta', '081201232133', 'Medan', 2, 0.00, '2021-04-02 17:45:59', 1, 'Pesanan diterima');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `footer` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `header`, `content`, `footer`, `last_updated`) VALUES
(1, 'Illustration', '<p>Add some quality, svg illustrations to your project courtesy of <a\r\n                                            target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">unDraw</a>, a\r\n                                        constantly updated collection of beautiful svg images that you can use\r\n                                        completely free and without attribution!</p>\r\n                                    <a target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">Browse Illustrations on\r\n                                        unDraw &rarr;</a>', '', '2021-03-05 03:51:54'),
(2, 'Development Approach', '<p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce\r\n                                        CSS bloat and poor page performance. Custom CSS classes are used to create\r\n                                        custom components and custom utility classes.</p>\r\n                                    <p class=\"mb-0\">Before working with this theme, you should become familiar with the\r\n                                        Bootstrap framework, especially the utility classes.</p>', '', '2021-03-05 03:49:49'),
(3, 'Illustration', '<p>Add some quality, svg illustrations to your project courtesy of <a\r\n                                            target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">unDraw</a>, a\r\n                                        constantly updated collection of beautiful svg images that you can use\r\n                                        completely free and without attribution!</p>\r\n                                    <a target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">Browse Illustrations on\r\n                                        unDraw &rarr;</a>', '', '2021-03-05 03:51:44'),
(4, 'Development Approach', '<p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce\r\n                                        CSS bloat and poor page performance. Custom CSS classes are used to create\r\n                                        custom components and custom utility classes.</p>\r\n                                    <p class=\"mb-0\">Before working with this theme, you should become familiar with the\r\n                                        Bootstrap framework, especially the utility classes.</p>', '', '2021-03-05 03:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `footer` varchar(256) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `header`, `title`, `content`, `footer`, `icon`) VALUES
(1, 'Dashboard', 'Pempek Cek Yuli', 'pempek cek yuli adalah toko pempek palembang yang menjual aneka macam jenis pempek', '-', 'fas fa-fish');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(8, 'Rebus'),
(9, 'Goreng');

-- --------------------------------------------------------

--
-- Table structure for table `kurir`
--

CREATE TABLE `kurir` (
  `id` int(11) NOT NULL,
  `kurir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kurir`
--

INSERT INTO `kurir` (`id`, `kurir`) VALUES
(1, 'JNE'),
(2, 'POS Indonesia'),
(3, 'SAP Express'),
(4, 'Sicepat'),
(5, 'J&T'),
(6, 'Standard Express');

-- --------------------------------------------------------

--
-- Table structure for table `metode_bayar`
--

CREATE TABLE `metode_bayar` (
  `id` int(11) NOT NULL,
  `metode_bayar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `metode_bayar`
--

INSERT INTO `metode_bayar` (`id`, `metode_bayar`) VALUES
(1, 'Transfer'),
(2, 'Virtual Account'),
(3, 'OVO'),
(4, 'DANA');

-- --------------------------------------------------------

--
-- Table structure for table `pasokan`
--

CREATE TABLE `pasokan` (
  `id` int(11) NOT NULL,
  `pemasok` varchar(255) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_pempek` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sub_total_harga` float(14,2) NOT NULL,
  `waktu_transaksi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasokan`
--

INSERT INTO `pasokan` (`id`, `pemasok`, `id_petugas`, `id_pempek`, `jumlah`, `sub_total_harga`, `waktu_transaksi`) VALUES
(21, 'Pempek Resto', 1, 16, 20, 40000.00, '2021-04-21 22:13:37'),
(22, 'Pempek Resto', 1, 17, 10, 20000.00, '2021-04-21 22:18:51'),
(23, 'Pempek Resto', 1, 18, 10, 20000.00, '2021-04-21 22:22:31'),
(24, 'Pempek Resto', 1, 19, 10, 20000.00, '2021-04-21 22:24:34'),
(25, 'Pempek Resto', 1, 20, 10, 20000.00, '2021-04-21 22:25:19'),
(26, 'Pempek Resto', 1, 21, 10, 20000.00, '2021-04-21 22:26:01'),
(27, 'Pempek Resto', 1, 22, 10, 20000.00, '2021-04-21 22:26:51'),
(28, 'Pempek Resto', 1, 23, 10, 20000.00, '2021-04-21 22:28:52'),
(29, 'Pempek Resto', 1, 24, 10, 20000.00, '2021-04-21 22:29:52'),
(30, 'Pempek Resto', 1, 25, 10, 50000.00, '2021-04-21 22:31:00'),
(31, 'Pempek Resto', 1, 26, 10, 20000.00, '2021-04-21 22:32:19'),
(32, 'Pempek Resto', 1, 27, 10, 20000.00, '2021-04-21 22:33:01'),
(33, 'Pempek Resto', 1, 16, 4, 8000.00, '2021-04-21 22:49:14'),
(34, 'Pempek Resto', 1, 23, 3, 6000.00, '2021-04-21 22:51:39'),
(35, 'Pempek Resto', 1, 16, 2, 4000.00, '2021-05-26 14:58:44'),
(36, 'Pempek Resto', 1, 17, 1, 2000.00, '2021-05-28 14:58:40');

-- --------------------------------------------------------

--
-- Table structure for table `pempek`
--

CREATE TABLE `pempek` (
  `id` int(11) NOT NULL,
  `kode_pempek` varchar(255) NOT NULL,
  `nama_pempek` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_jual` float(14,2) NOT NULL,
  `harga_beli` float(14,2) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pempek`
--

INSERT INTO `pempek` (`id`, `kode_pempek`, `nama_pempek`, `merk`, `id_kategori`, `stok`, `harga_jual`, `harga_beli`, `deskripsi`, `gambar`, `aktif`) VALUES
(16, 'P001', 'Pempek Telur Kecil Rebus', 'Pempek Cek Yuli', 8, 5, 3000.00, 2000.00, 'pempek telur kecil rebus', 'pempek_telur_kecil.jpg', 1),
(17, 'P002', 'Pempek Telur Kecil Goreng', 'Pempek Cek Yuli', 9, 5, 3000.00, 2000.00, 'Pempek telur kecil goreng', 'pempek_telur_kecil1.jpg', 1),
(18, 'P003', 'Pempek Keriting Rebus', 'Pempek Cek Yuli', 8, 6, 3000.00, 2000.00, 'pempek keriting rebus', 'pempek_keriting.jpg', 1),
(19, 'P004', 'Pempek Keriting Goreng', 'Pempek Cek Yuli', 9, 10, 3000.00, 2000.00, 'Pempek keriting goreng', 'pempek_keriting1.jpg', 1),
(20, 'P005', 'Pempek Adaan Rebus', 'Pempek Cek Yuli', 8, 6, 3000.00, 2000.00, 'pempek adaan rebus', 'pempek_adaan.jpg', 1),
(21, 'P006', 'Pempek Adaan Goreng', 'Pempek Cek Yuli', 9, 0, 3000.00, 2000.00, 'pempek adaan goreng', 'pempek_adaan1.jpg', 1),
(22, 'P007', 'Pempek Kulit rebus', 'Pempek Cek Yuli', 8, 10, 3000.00, 2000.00, 'pempek kulit rebus', 'pempek_kulit.jpg', 1),
(23, 'P007', 'Pempek Kulit Goreng', 'Pempek Cek Yuli', 9, 12, 3000.00, 2000.00, 'pempek kulit goreng', 'pempek_kulit1.jpg', 1),
(24, 'P008', 'Pempek Telur Besar Rebus', 'Pempek Cek Yuli', 8, 10, 3000.00, 5000.00, 'Pempek Telur Besar Rebus', 'pempek_telur_besar.jpg', 1),
(25, 'P009', 'Pempek Telur Besar Goreng', 'Pempek Cek Yuli', 9, 10, 3000.00, 5000.00, 'Pempek Telur Besar Goreng', 'pempek_telur_besar1.jpg', 1),
(26, 'P0010', 'Pempek Pistel Rebus', 'Pempek Cek Yuli', 8, 10, 3000.00, 2000.00, 'Pempek Pistel Rebus', 'pempek_pistel.jpg', 1),
(27, 'P0011', 'Pempek Pistel Goreng', 'Pempek Cek Yuli', 9, 7, 3000.00, 2000.00, 'Pempek Pistel Goreng', 'pempek_pistel1.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `id_checkout` int(11) NOT NULL,
  `id_pempek` int(11) NOT NULL,
  `kode_pesanan` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sub_total_harga` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int(11) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `no_rekening` varchar(255) NOT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `bank`, `no_rekening`, `atas_nama`, `email`) VALUES
(1, 'Mandiri', '1234567890', 'Nurul', 'nurul@gmail.com'),
(2, 'BNI', '0987654321', 'Annisa Yusmaniah', 'annisayusmaniah2001@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `kode_bayar` varchar(255) NOT NULL,
  `id_kasir` int(11) NOT NULL,
  `id_pempek` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sub_total_harga` float(14,2) NOT NULL,
  `waktu_transaksi` datetime NOT NULL,
  `catatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode_bayar`, `id_kasir`, `id_pempek`, `jumlah`, `sub_total_harga`, `waktu_transaksi`, `catatan`) VALUES
(20, 'F2809EB62C4C47A9F7C7', 1, 16, 1, 3000.00, '2021-04-21 22:34:27', '21/04/21'),
(21, 'F2809EB62C4C47A9F7C7', 1, 23, 1, 3000.00, '2021-04-21 22:34:27', '21/04/21'),
(22, '8E09A2D5916188C3ADEC', 1, 20, 4, 12000.00, '2021-04-21 22:38:59', ''),
(23, '8E09A2D5916188C3ADEC', 1, 18, 4, 12000.00, '2021-04-21 22:38:59', ''),
(24, '8E09A2D5916188C3ADEC', 1, 27, 3, 9000.00, '2021-04-21 22:38:59', ''),
(25, '8E09A2D5916188C3ADEC', 1, 17, 3, 9000.00, '2021-04-21 22:38:59', ''),
(26, '8E09A2D5916188C3ADEC', 1, 16, 3, 9000.00, '2021-04-21 22:38:59', ''),
(27, '83BE31B047871FC14E8D', 1, 17, 1, 3000.00, '2021-04-21 22:39:37', ''),
(28, 'FC5F02A964768346FA37', 23, 21, 10, 30000.00, '2021-04-21 22:59:53', ''),
(29, '8196AD1C2916585C224D', 23, 16, 1, 3000.00, '2021-05-26 14:33:59', ''),
(30, 'F59027E2F41A0FA63CB0', 23, 17, 1, 3000.00, '2021-05-26 14:35:41', ''),
(31, '52DA38EB1B723F1D7639', 1, 16, 1, 3000.00, '2021-05-26 14:45:59', ''),
(32, '52DA38EB1B723F1D7639', 1, 17, 1, 3000.00, '2021-05-26 14:45:59', ''),
(33, 'CE1561127AA7AC17EB03', 25, 16, 10, 30000.00, '2021-06-09 14:49:15', ''),
(34, 'DA07D073A63363D0B634', 25, 16, 5, 15000.00, '2021-06-09 14:51:16', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `gender` varchar(128) NOT NULL,
  `place_of_birth` varchar(128) NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `religion_id` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `gender`, `place_of_birth`, `birthday`, `phone_number`, `address`, `religion_id`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(0, 'Developer', 'developer@dev.com', 'Laki-laki', 'Developer', '2021-06-08', '000000000000', '-', 1, 'default.svg', '$2y$10$vbkWvgP62pRvI4GEVxv5b.PWW3Y0ZbfJOu9O32uS5sGcHR.g.PMF6', 0, 1, 1623120018),
(1, 'diko', 'diko@gmail.com', 'Laki-laki', 'Madinah', '1999-02-18', '082117503125', 'Jl. Raya Cilamaya, Dusun Kedung Asem, Desa Mekarmaya, Kec. Cilamaya Wetan, Kab. Karawang - Prov. Jawa barat', 1, 'akun1.jpg', '$2y$10$54Ajl0R.ArBF45hyXCsJZOnTdLzoegtv9nJbBRs3ICk1QBv1kS5yW', 1, 1, 1609656473),
(23, 'ko', 'ko@gmail.com', 'Perempuan', 'Palembang', '2021-04-21', '081367152437', 'jalan kancil', 1, 'akun.jpg', '$2y$10$4Ht7/uRQPIGc3kTKYGtucOGTVQ3mp0Ltia2eYBsEgm8bDghuj6jk.', 3, 1, 1619013913),
(25, 'gy', 'gy@gmail.com', 'Perempuan', 'Palembang', '2000-05-27', '085341127459', 'jalan kemuning', 1, 'Capture.PNG', '$2y$10$.HhYKuBAu4bVasXTqTiHOOL8/KDqeGVqonChXMtVv4UJrxypA4kx.', 1, 1, 1622392466),
(28, 'pupo', 'pupo@gmail.com', 'Perempuan', 'Palembang', '2021-04-27', '081212342136', 'jalan jalan', 1, 'akun2.jpg', '$2y$10$/WYI9oeNOFDKrQYbIiFWjO9RKKX/wraeqong0E97Ds9MJwwYQiWla', 3, 1, 1622393540),
(31, 'wawa', 'wawa@gmail.com', 'Perempuan', 'Palembang', '2006-03-16', '081324123187', 'jalan mawar no 3 b', 1, 'akun3.jpg', '$2y$10$oLJcQOVFVcv/g8UtcRk1puWJObrX2neMhoVP7p8Va3LdEnDeaFQ3.', 3, 1, 1623223391);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(0, 0, 0),
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(5, 1, 4),
(6, 1, 5),
(10, 2, 6),
(11, 2, 8),
(21, 3, 2),
(24, 3, 4),
(25, 0, 1),
(26, 0, 2),
(27, 0, 3),
(28, 0, 4),
(29, 0, 5),
(30, 0, 6),
(31, 0, 7),
(32, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `active`) VALUES
(0, 'Developer', 1),
(1, 'Admin', 1),
(2, 'User', 1),
(3, 'Menu', 1),
(4, 'Pempek', 1),
(5, 'Transaksi', 1),
(6, 'Member', 1),
(7, 'DataMaster', 1),
(8, 'Lainnya', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(0, 'developer\r\n'),
(1, 'admin kasir'),
(3, 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin/', 'fas fa-fw fa-tachometer-alt', 0),
(2, 2, 'My Profile', 'user/', 'fas fa-fw fa-user', 0),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu/', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/subMenu', 'fas fa-fw fa-folder-open', 1),
(6, 0, 'Role Management', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(7, 2, 'Ubah Password', 'user/changePassword', 'fas fa-fw fa-key', 1),
(8, 1, 'Data User', 'admin/dataUser/', 'fas fa-fw fa-user-tie', 1),
(9, 4, 'Beranda', 'pempek/', 'fas fa-fw fa-home', 0),
(10, 7, 'Data Master', 'DataMaster/', 'fas fa-fw fa-database', 1),
(11, 5, 'Pemesanan', 'Transaksi/', 'fas fa-fw fa-handshake', 1),
(12, 5, 'Pemesanan Online', 'Transaksi/online', 'fas fa-fw fa-shopping-bag', 0),
(13, 5, 'Data Penjualan', 'Transaksi/offline', 'fas fa-fw fa-shopping-cart', 0),
(14, 5, 'Pembayaran Online', 'Transaksi/pembayaranOnline/', 'fas fa-fw fa-money-bill-wave', 0),
(15, 6, 'Beranda', 'Member/', 'fas fa-fw fa-home', 1),
(16, 4, 'Data Pempek', 'Pempek/pempek', 'fab fa-fw fa-product-hunt', 1),
(17, 6, 'Pempek Resto', 'Member/pempekResto', 'fas fa-fw fa-fish', 1),
(18, 6, 'Keranjang', 'Member/keranjang', 'fas fa-fw fa-shopping-cart', 1),
(19, 6, 'Pesanan Saya', 'Member/pesanan', 'fas fa-fw fa-shopping-basket', 1),
(20, 6, 'Pembayaran', 'Member/pembayaran', 'fab fa-fw fa-shopify', 1),
(21, 4, 'Riwayat Data Stok', 'pempek/pasokan', 'fas fa-fw fa-store', 1),
(22, 7, 'Data Agama', 'DataMaster/agama/', 'fas fa-fw fa-pray', 1),
(23, 7, 'Data Dashboard', 'DataMaster/dashboard/', 'fas fa-fw fa-edit', 1),
(24, 7, 'Data Konten', 'DataMaster/konten', 'far fa-fw fa-newspaper', 0),
(25, 8, 'Tentang Aplikasi', 'Lainnya/tentang', 'fas fa-fw fa-address-card', 1),
(26, 8, 'Pengaturan', 'Lainnya/pengaturan', 'fas fa-fw fa-wrench', 0),
(27, 8, 'Hubungi Kami', 'Lainnya/hubungi', 'fas fa-fw fa-address-book', 1),
(28, 8, 'Bantuan', 'Lainnya/bantuan', 'far fa-fw fa-question-circle', 0),
(29, 8, 'FAQ', 'Lainnya/faq', 'fas fa-fw fa-question', 0),
(30, 7, 'Data Kategori', 'DataMaster/kategori', 'fas fa-fw fa-bars', 1),
(31, 7, 'Data Kurir', 'DataMaster/kurir', 'fas fa-fw fa-shipping-fast', 0),
(32, 6, 'Riwayat Pembayaran', 'Member/riwayatPembayaran/', 'fas fa-fw fa-history', 1),
(33, 7, 'Data Metode Bayar', 'DataMaster/metodeBayar', 'fas fa-fw fa-money-check', 0),
(34, 7, 'Data Rekening', 'DataMaster/rekening', 'fas fa-fw fa-file-invoice-dollar', 0),
(35, 4, 'Laporan Penjualan', 'Pempek/laporan', 'fas fa-fw fa-hand-holding-usd', 1),
(36, 4, 'Laba dan Rugi', 'Pempek/labaRugi', 'fas fa-fw fa-cash-register', 1),
(37, 5, 'Data Beban / Pengeluaran', 'Transaksi/beban', 'fas fa-fw fa-weight-hanging', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(4, 'haitsam03@gmail.com', 'iscmRCWne+lTCfqz/25n5R8VUX5MUkaN02Bhum3gVsU=', 1609930420),
(5, 'haitsam03@gmail.com', 'n5QKD1D9vUL9QiROw9MO4pgD/fbbdFGYrGd8znIJWe4=', 1609932048),
(6, 'haitsam03@gmail.com', 'wPG+3htmGqTKAArzVlpS/b0eoqor9TKqG16H5cDvMqA=', 1609932054),
(7, 'aa@aa.a', 'oIK0LUztcU02aYAE6HG86eh7Fq5/TcK17wF7B/To+/k=', 1609941391),
(8, 'wahyuhidayat@gmail.com', 'h5OYZb29deEXYS/1Bc69GOaWseVwGEhhSXVKert9Oog=', 1610019862),
(9, 'pramuko@gmail.com', 'ijlFNaUwBrUcqEbANwlEml1FluVkgWAOvEPf3VtE9H4=', 1610019892),
(10, 'elyrosely@gmail.com', 'zLt8OC5aT9LrQaCipRl09/n95aUTUUjwCiVtKM150uA=', 1610019940),
(11, 'inne@gmail.com', '6kl2FFh6027PAQ51K03uIlFz8f3+e59snpxLo3jAOBE=', 1610019985),
(12, 'wawa@gmail.com', '/g7m4I60ysY6Ljs6xsHhye5zWPyA0eR/4qwv7r7czlo=', 1610020015),
(13, 'fasaldo1999@gmail.com', 'fOSWX9UdFnoi7ejSOIkhye7te1tVdT+cXmd1hh0YZCQ=', 1610023446),
(15, 'muhammadbarja@gmail.com', 'VpatS/tgTK/bfTZLlDDoVX9aaD6Kb3YoeS2/ozJOhXI=', 1610280453),
(16, 'januarizqi5@gmail.com', '8QKHOpK1ROQrW679QbREt1fb2wdgcsffl5PLahNGPws=', 1610507816),
(17, 'suryatiningsih@gmail.com', 'IvVR3KjJpnh+lnQgeWOmpht3w235j9Vax2GkkDCzUBE=', 1610509684),
(18, 'ersanum@gmail.com', 'Tst2ygGt8n2wUa+RsqvtHguZMn1KPTaiNE63D4wwehQ=', 1610529882),
(19, 'haitsamhaitsam18@yahoo.com', '06vONmPAIi0hj/xgLH72Ck6FSDDyqs96P9pxA5bOU54=', 1610556667),
(20, 'shibghotul7@gmail.com', 'zLT3U4RCMM6pc1pVBCI3SodKzlAVJmG13PbfY8ijFnU=', 1610556792),
(21, 'haitsam03@gmail.com', 'oVyGSYjGv4lTvFvUKawPJ96cj42FYlkQW8QcyPDghSQ=', 1611588824),
(22, 'akibdahlan20@gmail.com', 'Q5sF4roomYzNnHkIS0zKCHKteza6KwrK5GYaHqlJr8w=', 1614472096),
(23, 'akibdahlan21@gmail.com', 'M23yBdkPPwctLera1YG1Eccpx5PFhn1vNyKEeEqVpT0=', 1614472317),
(24, 'gy@gmail.com', 'tD37nb4CUxwNCsb1hxDEeXyjd6sJWgFok+eSLeyjVLc=', 1619013913),
(25, 'pupo@gmail.com', '1AsGaRIFr6dD/dACKa4gXTVsLKpsN5t8A24HPUrQh7c=', 1622392176),
(26, 'gy@gmail.com', 'J7VbtM0R8v3dunXPd9iisLwLMYjuZZGtzQDvv8MS/vA=', 1622392466),
(27, 'a@gmail.com', 'vE9cD9YxCGyp2UAgBm5DrAiLp7J4n/uI2jRKbWdp1Xc=', 1622392740),
(28, 'pupo@gmail.com', 'leLO21ly8a457YVFLf8KqyH4/egYhd4TE6tomZgQ5hQ=', 1622392890),
(29, 'pupo@gmail.com', 'XJkunUs/KTl33fiesSHDqG13xAv0QmJZxK4Sdp//VHc=', 1622393540),
(30, 'developer@dev.com', 'Vn7AVCoNswm6JnqZcSI2Wnvj2jGm9BEg8CjnMvCAjmU=', 1623120018),
(31, 'olgapaurenta12@gmail.com', 'k7HEr31WS3SiSn61Au9WCnK0ci3r2n3atMuPamDXYZI=', 1623130747),
(32, 'wawa@gmail.com', 'BLDa7zs5ShR0+q1ttR779ff5uBDy3U6FMITqodpNuqk=', 1623223391);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beban`
--
ALTER TABLE `beban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bukti_transfer`
--
ALTER TABLE `bukti_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_bayar` (`kode_bayar`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kurir`
--
ALTER TABLE `kurir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasokan`
--
ALTER TABLE `pasokan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pempek`
--
ALTER TABLE `pempek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agama`
--
ALTER TABLE `agama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `beban`
--
ALTER TABLE `beban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bukti_transfer`
--
ALTER TABLE `bukti_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kurir`
--
ALTER TABLE `kurir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pasokan`
--
ALTER TABLE `pasokan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pempek`
--
ALTER TABLE `pempek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

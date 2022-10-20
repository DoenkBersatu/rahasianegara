-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Okt 2022 pada 05.33
-- Versi server: 10.1.34-MariaDB
-- Versi PHP: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dpmptgar_sijempol`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `l_kecamatan`
--

CREATE TABLE `l_kecamatan` (
  `k_id` int(10) UNSIGNED NOT NULL,
  `kecamatan` varchar(50) COLLATE utf8_bin NOT NULL,
  `kode_pos` varchar(45) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `l_kecamatan`
--

INSERT INTO `l_kecamatan` (`k_id`, `kecamatan`, `kode_pos`) VALUES
(1, 'Banjarwangi', '44172'),
(2, 'Banyuresmi', '44191'),
(3, 'Bayongbong', '44162'),
(4, 'Blubur Limbangan', '44186'),
(5, 'Bungbulang', '44165'),
(6, 'Caringin', '44161'),
(7, 'Cibalong', '44176'),
(8, 'Cibatu', '44185'),
(9, 'Cibiuk', '44193'),
(10, 'Cigedug', '44116'),
(11, 'Cihurip', '44173'),
(12, 'Cikajang', '44171'),
(13, 'Cikelet', '44177'),
(14, 'Cilawu', '44181'),
(15, 'Cisewu', '44166'),
(16, 'Cisompet', '44174'),
(17, 'Cisurupan', '44163'),
(18, 'Garut Kota', '44111'),
(19, 'Kadungora', '44153'),
(20, 'Karangpawitan', '44182'),
(21, 'Karangtengah', '44184'),
(22, ' Kersamanah', '44185'),
(23, 'Leles', '4419'),
(24, 'Leuwigoong', '44192'),
(25, 'Malangbong', '44188'),
(26, 'Mekarmukti', '44165'),
(27, 'Pakenjeng', '44164'),
(28, 'Pameungpeuk', '44175'),
(29, 'Pamulihan', '44164'),
(30, 'Pangatikan', '44183'),
(31, 'Pasirwangi', '44161'),
(32, 'Peundeuy', '44178'),
(33, 'Samarang', '44161'),
(34, 'Selaawi', '44187'),
(35, 'Singajaya', '44173'),
(36, 'Sucinaraja', '44115'),
(37, 'Sukaresmi', '44163'),
(38, 'Sukawening', '44184'),
(39, 'Talegong', '44167'),
(40, 'Tarogong Kaler', '44151'),
(41, 'Tarogong Kidul', '44151'),
(42, 'Wanaraja', '44183');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `l_kecamatan`
--
ALTER TABLE `l_kecamatan`
  ADD PRIMARY KEY (`k_id`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `l_kecamatan`
--
ALTER TABLE `l_kecamatan`
  MODIFY `k_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

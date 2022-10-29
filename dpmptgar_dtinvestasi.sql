-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Okt 2022 pada 07.52
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
-- Database: `dpmptgar_dtinvestasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis`) VALUES
(1, 'UMK'),
(2, 'Non-UMK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_perusahaan`
--

CREATE TABLE `jenis_perusahaan` (
  `id_jp` int(11) NOT NULL,
  `jenis_perusahaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_perusahaan`
--

INSERT INTO `jenis_perusahaan` (`id_jp`, `jenis_perusahaan`) VALUES
(1, 'Perorangan'),
(2, 'PT'),
(3, 'PT Perorangan'),
(4, 'CV'),
(5, 'Firma'),
(6, 'Persekutuan Perdata'),
(7, 'Koperasi'),
(8, 'Persyarikatan atau Perkumpulan'),
(9, 'Yayasan'),
(10, 'Perusahaan Umum (Perum)'),
(11, 'Perusahaan Umum Daerah (Perumda)'),
(12, 'Badan Layanan Umum'),
(13, 'Badan Hukum Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(10) UNSIGNED NOT NULL,
  `kecamatan` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`, `kecamatan`) VALUES
(1, 'Banjarwangi'),
(2, 'Banyuresmi'),
(3, 'Bayongbong'),
(4, 'Blubur Limbangan'),
(5, 'Bungbulang'),
(6, 'Caringin'),
(7, 'Cibalong'),
(8, 'Cibatu'),
(9, 'Cibiuk'),
(10, 'Cigedug'),
(11, 'Cihurip'),
(12, 'Cikajang'),
(13, 'Cikelet'),
(14, 'Cilawu'),
(15, 'Cisewu'),
(16, 'Cisompet'),
(17, 'Cisurupan'),
(18, 'Garut Kota'),
(19, 'Kadungora'),
(20, 'Karangpawitan'),
(21, 'Karangtengah'),
(22, ' Kersamanah'),
(23, 'Leles'),
(24, 'Leuwigoong'),
(25, 'Malangbong'),
(26, 'Mekarmukti'),
(27, 'Pakenjeng'),
(28, 'Pameungpeuk'),
(29, 'Pamulihan'),
(30, 'Pangatikan'),
(31, 'Pasirwangi'),
(32, 'Peundeuy'),
(33, 'Samarang'),
(34, 'Selaawi'),
(35, 'Singajaya'),
(36, 'Sucinaraja'),
(37, 'Sukaresmi'),
(38, 'Sukawening'),
(39, 'Talegong'),
(40, 'Tarogong Kaler'),
(41, 'Tarogong Kidul'),
(42, 'Wanaraja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `minat_investasi`
--

CREATE TABLE `minat_investasi` (
  `id_minat_investasi` int(11) NOT NULL,
  `nib` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `penanaman_modal` int(11) DEFAULT NULL,
  `jenis_perusahaan` int(11) DEFAULT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `sysdate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `minat_investasi`
--

INSERT INTO `minat_investasi` (`id_minat_investasi`, `nib`, `nama`, `penanaman_modal`, `jenis_perusahaan`, `id_kecamatan`, `id_jenis`, `sysdate`) VALUES
(1, '8120008702332', 'APOTEK MITRA SEHAT', 1, 1, 42, 1, '2022-10-25 14:32:11'),
(2, '8120107712662', 'SARI SARI', 1, 1, 20, 1, '2022-10-25 14:32:11'),
(3, '8120004850964', 'SAMPURNA', 1, 1, 20, 1, '2022-10-25 14:32:11'),
(4, '8120202830396', 'PD SINAR JAYA', 1, 1, 20, 1, '2022-10-25 14:32:11'),
(5, '8120003851659', 'PD JAYA SENTOSA', 1, 1, 18, 2, '2022-10-25 14:32:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyerapan_tk`
--

CREATE TABLE `penyerapan_tk` (
  `id_penyerapan_tk` int(11) NOT NULL,
  `id_triwulan` int(11) NOT NULL,
  `id_sektor` int(11) NOT NULL,
  `id_subsektor` int(11) NOT NULL,
  `jumlah_penyerapan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `realisasi_investasi`
--

CREATE TABLE `realisasi_investasi` (
  `id_realisasi_investasi` int(11) NOT NULL,
  `id_triwulan` int(11) NOT NULL,
  `id_sektor` int(11) NOT NULL,
  `id_subsektor` int(11) NOT NULL,
  `jumlah_investasi` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `realisasi_investasi`
--

INSERT INTO `realisasi_investasi` (`id_realisasi_investasi`, `id_triwulan`, `id_sektor`, `id_subsektor`, `jumlah_investasi`) VALUES
(1, 5, 1, 1, 123456),
(2, 6, 1, 1, 456321),
(3, 7, 1, 1, 342515),
(4, 8, 0, 0, 234543);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sektor`
--

CREATE TABLE `sektor` (
  `id_sektor` int(11) NOT NULL,
  `sektor` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sektor`
--

INSERT INTO `sektor` (`id_sektor`, `sektor`) VALUES
(1, 'PRIMER'),
(2, 'SEKUNDER'),
(3, 'TERSIER');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'PMDN'),
(2, 'PMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subsektor`
--

CREATE TABLE `subsektor` (
  `id_subsektor` int(11) NOT NULL,
  `subsektor` varchar(160) NOT NULL,
  `id_sektor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `subsektor`
--

INSERT INTO `subsektor` (`id_subsektor`, `subsektor`, `id_sektor`) VALUES
(1, 'Tanaman Pangan dan Perkebunan', 1),
(2, 'Perikanan', 1),
(3, 'Kehutanan', 1),
(4, 'Industri Makanan', 2),
(5, 'Industri Tekstil', 2),
(6, 'Industri Barang dari Kulit dan Alas Kaki', 2),
(7, 'Industri Kayu', 2),
(8, 'Industri Kertas dan Percetakan', 2),
(9, 'Industri Kimia dan Farmasi', 2),
(10, 'Industri Karet dan Plastik', 2),
(11, 'Industri Mineral Non Logam', 2),
(12, 'Industri Logam Dasar, Barang Logam, Bukan Mesin dan Peralatannya', 2),
(13, 'Industri Kendaraan Bermotor dan Alat Transportasi Lain', 2),
(14, 'Industri Mesin, Elektronik, Instrumen Kedokteran, Peralatan Listrik, Presisi, Optik dan Jam', 2),
(15, 'Industri Lainnya', 2),
(16, 'Listrik, gas  dan air', 3),
(17, 'Konstruksi', 3),
(18, 'Perdagangan dan Reparasi', 3),
(19, 'Hotel dan Restoran', 3),
(20, 'Perumahan, Kawasan Industri dan Perkantoran', 3),
(21, 'Transportasi, Gudang dan Telekomunikasi', 3),
(22, 'Jasa Lainnya', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `triwulan`
--

CREATE TABLE `triwulan` (
  `ID_triwulan` int(11) NOT NULL,
  `triwulan` varchar(32) NOT NULL,
  `tahun` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `triwulan`
--

INSERT INTO `triwulan` (`ID_triwulan`, `triwulan`, `tahun`) VALUES
(1, 'Triwulan 1', '2020'),
(2, 'Triwulan 2', '2020'),
(3, 'Triwulan 3', '2020'),
(4, 'Triwulan 4', '2020'),
(5, 'Triwulan 1', '2021'),
(6, 'Triwulan 2', '2021'),
(7, 'Triwulan 3', '2021'),
(8, 'Triwulan 4', '2021'),
(9, 'Triwulan 1', '2022'),
(10, 'Triwulan 2', '2022'),
(11, 'Triwulan 3', '2022'),
(12, 'Triwulan 4', '2022');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `userlevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `userlevel`) VALUES
(1, 'nego', 'Negova123!', 'nego@yaho.com', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `userlevelpermissions`
--

CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `userlevelpermissions`
--

INSERT INTO `userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}jenis', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}kecamatan', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}minat_investasi', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}penyerapan_tk', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}realisasi_investasi', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}sektor', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}subsektor', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}triwulan', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}user', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}userlevelpermissions', 0),
(-2, '{711D4B7A-499A-4AB9-B89B-D8472076C077}userlevels', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}jenis', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}kecamatan', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}minat_investasi', 109),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}penyerapan_tk', 109),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}realisasi_investasi', 109),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}sektor', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}subsektor', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}triwulan', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}user', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}userlevelpermissions', 0),
(0, '{711D4B7A-499A-4AB9-B89B-D8472076C077}userlevels', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `userlevels`
--

CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `userlevels`
--

INSERT INTO `userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `jenis_perusahaan`
--
ALTER TABLE `jenis_perusahaan`
  ADD PRIMARY KEY (`id_jp`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`) USING BTREE;

--
-- Indeks untuk tabel `minat_investasi`
--
ALTER TABLE `minat_investasi`
  ADD PRIMARY KEY (`id_minat_investasi`);

--
-- Indeks untuk tabel `penyerapan_tk`
--
ALTER TABLE `penyerapan_tk`
  ADD PRIMARY KEY (`id_penyerapan_tk`);

--
-- Indeks untuk tabel `realisasi_investasi`
--
ALTER TABLE `realisasi_investasi`
  ADD PRIMARY KEY (`id_realisasi_investasi`);

--
-- Indeks untuk tabel `sektor`
--
ALTER TABLE `sektor`
  ADD PRIMARY KEY (`id_sektor`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `subsektor`
--
ALTER TABLE `subsektor`
  ADD PRIMARY KEY (`id_subsektor`);

--
-- Indeks untuk tabel `triwulan`
--
ALTER TABLE `triwulan`
  ADD PRIMARY KEY (`ID_triwulan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `userlevelpermissions`
--
ALTER TABLE `userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indeks untuk tabel `userlevels`
--
ALTER TABLE `userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_perusahaan`
--
ALTER TABLE `jenis_perusahaan`
  MODIFY `id_jp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kecamatan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `minat_investasi`
--
ALTER TABLE `minat_investasi`
  MODIFY `id_minat_investasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `penyerapan_tk`
--
ALTER TABLE `penyerapan_tk`
  MODIFY `id_penyerapan_tk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `realisasi_investasi`
--
ALTER TABLE `realisasi_investasi`
  MODIFY `id_realisasi_investasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sektor`
--
ALTER TABLE `sektor`
  MODIFY `id_sektor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `subsektor`
--
ALTER TABLE `subsektor`
  MODIFY `id_subsektor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `triwulan`
--
ALTER TABLE `triwulan`
  MODIFY `ID_triwulan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

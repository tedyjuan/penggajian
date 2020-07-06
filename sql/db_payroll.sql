-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Okt 2019 pada 03.37
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_payroll`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_agama`
--

CREATE TABLE `m_agama` (
  `id_agama` int(11) NOT NULL,
  `nama_agama` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_agama`
--

INSERT INTO `m_agama` (`id_agama`, `nama_agama`) VALUES
(5, 'Islam'),
(6, 'hindu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_bagian`
--

CREATE TABLE `m_bagian` (
  `id_bagian` int(11) NOT NULL,
  `nama_bagian` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `m_bagian`
--

INSERT INTO `m_bagian` (`id_bagian`, `nama_bagian`) VALUES
(2, 'produksi'),
(3, 'Office'),
(4, 'Marketing');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_bank`
--

CREATE TABLE `m_bank` (
  `id_bank` int(11) NOT NULL,
  `nama_bank` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_bank`
--

INSERT INTO `m_bank` (`id_bank`, `nama_bank`) VALUES
(1, 'Mandiri'),
(2, 'BCA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jabatan`
--

CREATE TABLE `m_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_jabatan`
--

INSERT INTO `m_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Operator Produksi'),
(3, 'Pengawas Produksi'),
(4, 'Staff Office'),
(5, 'Sales Marketing'),
(7, 'Manager ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_karyawan`
--

CREATE TABLE `m_karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `id_pendidikan` int(11) NOT NULL,
  `id_agama` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_status` int(5) NOT NULL,
  `id_bagian` int(5) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `no_ktp` int(16) NOT NULL,
  `no_npwp` varchar(50) NOT NULL DEFAULT '0',
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tempat_lahir` varchar(35) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `kewarganegaraan` varchar(25) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` int(13) NOT NULL,
  `nama_institusipendidikan` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `m_karyawan`
--

INSERT INTO `m_karyawan` (`id_karyawan`, `id_pendidikan`, `id_agama`, `id_jabatan`, `id_status`, `id_bagian`, `nik`, `no_ktp`, `no_npwp`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `kewarganegaraan`, `alamat`, `telepon`, `nama_institusipendidikan`) VALUES
(1, 3, 5, 4, 1, 3, '123', 97878, '123', 'Miftahul Munib', 'L', 'Cilacap', '2018-05-24', '', 'Tangerang', 2147483647, 'SMK Komputama Majenang'),
(2, 3, 6, 1, 1, 2, '12333', 9999999, '456', 'Khalif Alhuda', 'L', 'Bondowoso', '2018-01-10', '', 'Tangerang', 2147483647, 'SMK lampung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_penambah`
--

CREATE TABLE `m_penambah` (
  `id_penambah` int(11) NOT NULL,
  `nama_penambah` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_penambah`
--

INSERT INTO `m_penambah` (`id_penambah`, `nama_penambah`) VALUES
(1, 'Bonus'),
(2, 'Lembur'),
(3, 'Insentiv');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_pendidikan`
--

CREATE TABLE `m_pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `nama_pendidikan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_pendidikan`
--

INSERT INTO `m_pendidikan` (`id_pendidikan`, `nama_pendidikan`) VALUES
(1, 'SD'),
(2, 'SMP'),
(3, 'SMA'),
(5, 'D1'),
(6, 'D2'),
(7, 'D3'),
(8, 'SMK'),
(9, 'MTS'),
(10, 'S1'),
(11, 'S2'),
(12, 'S3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_penggajian`
--

CREATE TABLE `m_penggajian` (
  `id_penggajian` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_ptkp` int(11) DEFAULT NULL,
  `no_rekening` int(13) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `gapok` decimal(18,2) NOT NULL,
  `gaji_harian` decimal(12,2) NOT NULL,
  `parameter_bpjs_ketenagakerjaan` decimal(5,2) NOT NULL,
  `parameter_bpjs_kesehatan` decimal(5,2) NOT NULL,
  `parameterlembur` int(3) NOT NULL,
  `uang_transport` decimal(10,2) NOT NULL,
  `uang_makan` decimal(10,2) NOT NULL,
  `biaya_transfer` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `m_penggajian`
--

INSERT INTO `m_penggajian` (`id_penggajian`, `id_karyawan`, `id_ptkp`, `no_rekening`, `id_bank`, `atas_nama`, `gapok`, `gaji_harian`, `parameter_bpjs_ketenagakerjaan`, `parameter_bpjs_kesehatan`, `parameterlembur`, `uang_transport`, `uang_makan`, `biaya_transfer`) VALUES
(12, 1, 1, 8888, 2, 'kdfdhg', '3555834.00', '118527.80', '2.00', '1.00', 173, '20000.00', '20000.00', '2000.00'),
(6, 2, 1, 177777, 1, 'hfjdshfj', '3555834.00', '118527.80', '2.00', '1.00', 173, '20000.00', '20000.00', '2000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_pengurang`
--

CREATE TABLE `m_pengurang` (
  `id_pengurang` int(11) NOT NULL,
  `nama_pengurang` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_pengurang`
--

INSERT INTO `m_pengurang` (`id_pengurang`, `nama_pengurang`) VALUES
(1, 'BPJS Kesehatan'),
(2, 'BPJS Ketenagakerjaan'),
(3, 'Absensi'),
(4, 'Materai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_postinggaji`
--

CREATE TABLE `m_postinggaji` (
  `id_posting` int(11) NOT NULL,
  `mulai_tgl` date NOT NULL,
  `selesai_tgl` date NOT NULL,
  `periode_gaji` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_prosesgaji`
--

CREATE TABLE `m_prosesgaji` (
  `id_postinggaji` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tgl_posting` date NOT NULL,
  `jml_gajiharian` decimal(18,2) NOT NULL DEFAULT 0.00,
  `jml_potonganabsensi` decimal(18,2) DEFAULT 0.00,
  `jml_potongan` decimal(18,2) NOT NULL DEFAULT 0.00,
  `jml_potongantransfer` decimal(18,2) DEFAULT 0.00,
  `jml_potonganpph23` decimal(18,2) DEFAULT 0.00,
  `jml_tambahan` decimal(18,2) NOT NULL DEFAULT 0.00,
  `asuransi` decimal(18,2) NOT NULL DEFAULT 0.00,
  `jml_uangmakan` decimal(18,2) NOT NULL DEFAULT 0.00,
  `jml_uangtransport` decimal(18,2) NOT NULL DEFAULT 0.00,
  `jml_uanglembur` decimal(18,2) NOT NULL DEFAULT 0.00,
  `gaji_bersih` decimal(18,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_prosesgaji`
--

INSERT INTO `m_prosesgaji` (`id_postinggaji`, `id_karyawan`, `tgl_posting`, `jml_gajiharian`, `jml_potonganabsensi`, `jml_potongan`, `jml_potongantransfer`, `jml_potonganpph23`, `jml_tambahan`, `asuransi`, `jml_uangmakan`, `jml_uangtransport`, `jml_uanglembur`, `gaji_bersih`) VALUES
(1, 1, '2018-05-01', '3318778.40', '237055.60', '250000.00', '2000.00', '0.00', '100000.00', '106675.02', '560000.00', '560000.00', '252813.63', '4432917.01'),
(2, 2, '2018-05-01', '3200250.60', '355583.40', '250000.00', '2000.00', '0.00', '100000.00', '106675.02', '540000.00', '540000.00', '47959.23', '4069534.81');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_ptkp`
--

CREATE TABLE `m_ptkp` (
  `id_ptkp` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `nominal_tahunan` decimal(18,2) NOT NULL DEFAULT 0.00,
  `nominal_bulanan` decimal(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `m_ptkp`
--

INSERT INTO `m_ptkp` (`id_ptkp`, `status`, `keterangan`, `nominal_tahunan`, `nominal_bulanan`) VALUES
(1, 'TK0', 'Wajib Pajak Tidak Kawin', '54000000.00', '4500000.00'),
(2, 'TK1', 'Wajib Pajak Tidak Kawin Tanggungan 1', '58500000.00', '4875000.00'),
(3, 'TK2', 'Wajib Pajak Tidak Kawin Tanggungan 2', '63000000.00', '5250000.00'),
(4, 'TK3', 'Wajib Pajak Tidak Kawin Tanggungan 3', '67500000.00', '5625000.00'),
(5, 'K0', 'Wajib Pajak Kawin', '58500000.00', '4875000.00'),
(6, 'K1', 'Wajib Pajak Kawin Tanggungan 1', '63000000.00', '5250000.00'),
(7, 'K2', 'Wajib Pajak Kawin Tanggungan 2', '67500000.00', '5625000.00'),
(8, 'K3', 'Wajib Pajak Kawin Tanggungan 3', '72000000.00', '6000000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_role`
--

CREATE TABLE `m_role` (
  `role_id` int(3) NOT NULL,
  `role` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_role`
--

INSERT INTO `m_role` (`role_id`, `role`) VALUES
(6, 'Administrator'),
(7, 'HRD'),
(8, 'HOD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_statusnikah`
--

CREATE TABLE `m_statusnikah` (
  `id_status` int(11) NOT NULL,
  `nama_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_statusnikah`
--

INSERT INTO `m_statusnikah` (`id_status`, `nama_status`) VALUES
(1, 'lajang'),
(2, 'menikah'),
(3, 'Cerai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_absensi`
--

CREATE TABLE `t_absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tgl_absensi` date NOT NULL,
  `status_kehadiran` enum('H','TH') NOT NULL DEFAULT 'TH'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_absensi`
--

INSERT INTO `t_absensi` (`id_absensi`, `id_karyawan`, `tgl_absensi`, `status_kehadiran`) VALUES
(1, 1, '2019-08-01', 'H'),
(2, 1, '2019-08-02', 'H'),
(3, 1, '2019-08-03', 'H'),
(4, 1, '2019-08-04', 'H'),
(5, 1, '2019-08-05', 'H'),
(6, 1, '2019-08-06', 'H'),
(7, 1, '2019-08-07', 'H'),
(8, 1, '2019-08-08', 'H'),
(9, 1, '2019-08-09', 'H'),
(10, 1, '2019-08-10', 'H'),
(11, 1, '2019-08-11', 'H'),
(12, 1, '2019-08-12', 'H'),
(13, 1, '2019-08-13', 'H'),
(14, 1, '2019-08-14', 'H'),
(15, 1, '2019-08-15', 'H'),
(16, 1, '2019-08-16', 'H'),
(17, 1, '2019-08-17', 'H'),
(18, 1, '2019-08-18', 'H'),
(19, 1, '2019-08-19', 'H'),
(20, 1, '2019-08-20', 'H'),
(21, 1, '2019-08-21', 'H'),
(22, 1, '2019-08-22', 'H'),
(23, 1, '2019-08-23', 'H'),
(24, 1, '2019-08-24', 'H'),
(25, 1, '2019-08-25', 'H'),
(26, 1, '2019-08-26', 'H'),
(27, 1, '2019-08-27', 'H'),
(28, 1, '2019-08-28', 'H');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_lembur`
--

CREATE TABLE `t_lembur` (
  `id_lembur` int(11) NOT NULL,
  `nomor_spkl` int(8) NOT NULL,
  `id_karyawan` int(5) NOT NULL,
  `tanggal_kehadiran` date NOT NULL,
  `mulai_lembur` datetime NOT NULL,
  `selesai_lembur` datetime NOT NULL,
  `catatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_penambah`
--

CREATE TABLE `t_penambah` (
  `id_t_penambah` int(11) NOT NULL,
  `id_penambah` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `periode_gaji` date NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `nilai` decimal(18,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pengurang`
--

CREATE TABLE `t_pengurang` (
  `id_t_pengurang` int(11) NOT NULL,
  `id_pengurang` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `periode_gaji` date NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `nilai` decimal(18,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `userlogin`
--

CREATE TABLE `userlogin` (
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `role_id` int(5) DEFAULT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `userlogin`
--

INSERT INTO `userlogin` (`username`, `password`, `fullname`, `role_id`, `email`) VALUES
('riadi', '50a004f7dc148a968b117ec85393dedb', 'Ahmad Riadi', 6, 'ahmadriadi.ti@gmail.com'),
('munif', 'f60a8a5f7ad01a87c7c68b40adc836fc', 'Munif', 6, 'munif@gmail.com'),
('test', 'cc03e747a6afbbcbf8be7668acfebee5', 'Tester', 8, 'test@gmail.com'),
('tedy', '1654ddb5b4b306da8bbb0c03c8dfc1d2', 'a', 6, 'aa'),
('dani', '8fc828b696ba1cd92eab8d0a6ffb17d6', 'ahmad dani', 6, 'dani@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `m_agama`
--
ALTER TABLE `m_agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- Indeks untuk tabel `m_bagian`
--
ALTER TABLE `m_bagian`
  ADD PRIMARY KEY (`id_bagian`);

--
-- Indeks untuk tabel `m_bank`
--
ALTER TABLE `m_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `m_jabatan`
--
ALTER TABLE `m_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `m_karyawan`
--
ALTER TABLE `m_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `m_penambah`
--
ALTER TABLE `m_penambah`
  ADD PRIMARY KEY (`id_penambah`);

--
-- Indeks untuk tabel `m_pendidikan`
--
ALTER TABLE `m_pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indeks untuk tabel `m_penggajian`
--
ALTER TABLE `m_penggajian`
  ADD PRIMARY KEY (`id_penggajian`);

--
-- Indeks untuk tabel `m_pengurang`
--
ALTER TABLE `m_pengurang`
  ADD PRIMARY KEY (`id_pengurang`);

--
-- Indeks untuk tabel `m_postinggaji`
--
ALTER TABLE `m_postinggaji`
  ADD PRIMARY KEY (`id_posting`);

--
-- Indeks untuk tabel `m_prosesgaji`
--
ALTER TABLE `m_prosesgaji`
  ADD PRIMARY KEY (`id_postinggaji`);

--
-- Indeks untuk tabel `m_ptkp`
--
ALTER TABLE `m_ptkp`
  ADD PRIMARY KEY (`id_ptkp`);

--
-- Indeks untuk tabel `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `m_statusnikah`
--
ALTER TABLE `m_statusnikah`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `t_absensi`
--
ALTER TABLE `t_absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indeks untuk tabel `t_lembur`
--
ALTER TABLE `t_lembur`
  ADD PRIMARY KEY (`id_lembur`);

--
-- Indeks untuk tabel `t_penambah`
--
ALTER TABLE `t_penambah`
  ADD PRIMARY KEY (`id_t_penambah`);

--
-- Indeks untuk tabel `t_pengurang`
--
ALTER TABLE `t_pengurang`
  ADD PRIMARY KEY (`id_t_pengurang`);

--
-- Indeks untuk tabel `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `m_agama`
--
ALTER TABLE `m_agama`
  MODIFY `id_agama` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `m_bagian`
--
ALTER TABLE `m_bagian`
  MODIFY `id_bagian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `m_bank`
--
ALTER TABLE `m_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `m_jabatan`
--
ALTER TABLE `m_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `m_karyawan`
--
ALTER TABLE `m_karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `m_penambah`
--
ALTER TABLE `m_penambah`
  MODIFY `id_penambah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `m_pendidikan`
--
ALTER TABLE `m_pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `m_penggajian`
--
ALTER TABLE `m_penggajian`
  MODIFY `id_penggajian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `m_pengurang`
--
ALTER TABLE `m_pengurang`
  MODIFY `id_pengurang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `m_postinggaji`
--
ALTER TABLE `m_postinggaji`
  MODIFY `id_posting` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `m_prosesgaji`
--
ALTER TABLE `m_prosesgaji`
  MODIFY `id_postinggaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `m_ptkp`
--
ALTER TABLE `m_ptkp`
  MODIFY `id_ptkp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `m_role`
--
ALTER TABLE `m_role`
  MODIFY `role_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `m_statusnikah`
--
ALTER TABLE `m_statusnikah`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `t_absensi`
--
ALTER TABLE `t_absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `t_lembur`
--
ALTER TABLE `t_lembur`
  MODIFY `id_lembur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_penambah`
--
ALTER TABLE `t_penambah`
  MODIFY `id_t_penambah` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pengurang`
--
ALTER TABLE `t_pengurang`
  MODIFY `id_t_pengurang` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2026 pada 16.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_bkk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dokumen`
--

CREATE TABLE `tb_dokumen` (
  `id_dokumen` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `ijazah` varchar(255) DEFAULT NULL,
  `ktp_file` varchar(255) DEFAULT NULL,
  `transkrip` varchar(255) DEFAULT NULL,
  `dokumen_lain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_dokumen`
--

INSERT INTO `tb_dokumen` (`id_dokumen`, `id_siswa`, `ijazah`, `ktp_file`, `transkrip`, `dokumen_lain`, `created_at`) VALUES
(1, 3, '1776440898_Bukti Asistensi Praktikum 4.pdf', '1776440898_Modul Praktikum PBO 2024.pdf', '1776440898_jurnal bindo jaman sekarang.pdf', '1776440898_lembar pengesahan 1x.pdf', '2026-04-15 01:31:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dokumen_perusahaan`
--

CREATE TABLE `tb_dokumen_perusahaan` (
  `id_dokumenper` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `nib` varchar(50) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `mou` varchar(100) DEFAULT NULL,
  `file_nib` varchar(255) DEFAULT NULL,
  `file_npwp` varchar(255) DEFAULT NULL,
  `file_mou` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_dokumen_perusahaan`
--

INSERT INTO `tb_dokumen_perusahaan` (`id_dokumenper`, `id_perusahaan`, `nib`, `npwp`, `mou`, `file_nib`, `file_npwp`, `file_mou`, `created_at`) VALUES
(1, 1, NULL, NULL, NULL, '1776078168_Mini Task SC Brand Identity Design.pdf', '1776078181_kalender1.pdf', '1776078201_Sertifikat Pendukung.pdf', '2026-04-13 11:01:51'),
(2, 2, NULL, NULL, NULL, '1777213426_kalender bulan 3-12 mama.pdf', '1777213435_kalender2.pdf', '1777213444_Laporan_Pendaftar.pdf', '2026-04-26 14:23:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_lamaran` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `judul_kegiatan` varchar(150) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('dijadwalkan','selesai','dibatalkan') DEFAULT 'dijadwalkan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_jadwal`
--

INSERT INTO `tb_jadwal` (`id_jadwal`, `id_lamaran`, `id_lowongan`, `id_perusahaan`, `judul_kegiatan`, `tanggal`, `waktu`, `lokasi`, `keterangan`, `status`, `created_at`) VALUES
(6, 14, 1, 1, '', '2026-04-21', '11:00:00', 'Pt. Miwon Indonesia (gedung B ruang H031)', 'Menemui HRD Ibu Fatimah', 'dibatalkan', '2026-04-18 02:49:12'),
(7, 14, 1, 1, '', '2026-04-30', '11:00:00', 'Pt. Miwon Indonesia (gedung B ruang H031)', 'Menemui HRD Ibu Ratna Dewi', 'dijadwalkan', '2026-04-18 16:41:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_keluarga`
--

CREATE TABLE `tb_keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_keluarga`
--

INSERT INTO `tb_keluarga` (`id_keluarga`, `id_siswa`, `nama_lengkap`, `pekerjaan`, `status`, `created_at`) VALUES
(1, 3, 'Sapto Hartono', 'Buruh Pabrik', 'Ayah', '2026-04-15 01:15:24'),
(2, 3, 'Neti Indah Purwaningsih', 'Ibu Rumah Tangga', 'Ibu', '2026-04-15 01:15:37'),
(3, 2, 'Sapto Hartono', 'Buruh Pabrik', 'Ayah', '2026-04-26 15:36:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelulusan`
--

CREATE TABLE `tb_kelulusan` (
  `id_kelulusan` int(11) NOT NULL,
  `id_lowongan` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL COMMENT 'NULL = Pengumuman untuk semua pelamar di lowongan tersebut',
  `berkas` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_pengumuman` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kelulusan`
--

INSERT INTO `tb_kelulusan` (`id_kelulusan`, `id_lowongan`, `id_siswa`, `berkas`, `keterangan`, `tanggal_pengumuman`, `created_at`) VALUES
(2, 1, NULL, 'kel_69e4eb955601f_1776610197.pdf', 'Lulus', '2026-04-18', '2026-04-19 14:49:57'),
(6, 2, NULL, 'kelulusan_69e9dd506b7bf8.10813452_1776934224_c7131bba.pdf', 'Tidak Lulus', '2026-04-23', '2026-04-23 08:50:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelulusan_backup`
--

CREATE TABLE `tb_kelulusan_backup` (
  `id_kelulusan` int(11) NOT NULL DEFAULT 0,
  `id_siswa` int(11) NOT NULL,
  `tahun_kelulusan` year(4) NOT NULL,
  `status_kelulusan` enum('lulus','tidak_lulus') DEFAULT 'lulus',
  `nilai_akhir` decimal(5,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_pengumuman` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lamaran`
--

CREATE TABLE `tb_lamaran` (
  `id_lamaran` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `tanggal_lamaran` date DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `surat_lamaran` varchar(255) DEFAULT NULL,
  `status` enum('Diproses','Diterima','Ditolak','Dibatalkan','Panggilan Wawancara') DEFAULT 'Diproses',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_lamaran`
--

INSERT INTO `tb_lamaran` (`id_lamaran`, `id_siswa`, `id_lowongan`, `tanggal_lamaran`, `cv`, `surat_lamaran`, `status`, `catatan`, `created_at`) VALUES
(14, 3, 1, '2026-04-16', '1776348284_0098765432_penyesuaian TA.pdf', NULL, 'Panggilan Wawancara', NULL, '2026-04-16 14:04:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lowongan`
--

CREATE TABLE `tb_lowongan` (
  `id_lowongan` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `judul_lowongan` varchar(150) NOT NULL,
  `jekel` varchar(50) NOT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kualifikasi` text DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `jenis_pekerjaan` varchar(50) DEFAULT NULL,
  `gaji` varchar(50) DEFAULT NULL,
  `tanggal_posting` date DEFAULT NULL,
  `batas_lamaran` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_lowongan`
--

INSERT INTO `tb_lowongan` (`id_lowongan`, `id_perusahaan`, `judul_lowongan`, `jekel`, `posisi`, `deskripsi`, `kualifikasi`, `lokasi`, `jenis_pekerjaan`, `gaji`, `tanggal_posting`, `batas_lamaran`, `status`, `created_at`) VALUES
(1, 1, 'Operasional Gudang', 'Pria', 'asdfg', 'xcvb', 'qwertyuiaa', '-', '-', 'Rp. 2.000.000', '2026-04-14', '2026-04-30', 'aktif', '2026-04-14 03:52:17'),
(2, 1, 'Operator Produksi', 'Pria', 'Bertanggung jawab dalam menjalankan proses produksi sesuai standar operasional perusahaan untuk mema', '• Mengoperasikan mesin produksi sesuai prosedur\r\n• Memastikan proses produksi berjalan lancar\r\n• Melakukan pengecekan kualitas produk\r\n• Menjaga kebersihan dan kerapihan area kerja\r\n• Melaporkan hasil produksi kepada atasan\r\n• Melakukan perawatan sederhana pada mesin', '• Pendidikan minimal SMA/SMK sederajat\r\n• Usia maksimal 30 tahun\r\n• Sehat jasmani dan rohani\r\n• Mampu bekerja dalam tim maupun individu\r\n• Bersedia bekerja shift\r\n• Disiplin, teliti, dan bertanggung jawab', 'Driyorejo, Gresik, Jawa Timur', 'berkerja sama dengan Tim', 'Rp. 2.000.000', '2026-04-16', '2026-05-01', 'aktif', '2026-04-16 15:23:34'),
(10, 1, 'IT Support', 'Wanita', 'asd', 'sdasdfghj', 'asdfghj', 'xcvbnm,.', 'dfghjkl;', 'Rp. 7.000.000', '2026-04-24', '2026-04-30', 'aktif', '2026-04-24 04:51:42'),
(14, 1, 'Sekretaris', 'Pria/Wanita', 'asdfghjk', 'xcvghbjnkm', 'sdrgfthyui', 'qqwertyuiop', 'sdfghjkldfgh', 'xcvbnm', '2026-04-24', '2026-04-29', 'aktif', '2026-04-24 04:59:42'),
(16, 2, 'Satpam', 'Pria', 'xcvbnm,', 'ertyuio', 'sdfghjk', 'wert5yuio', 'Tim', 'Rp. 1.000.000', '2026-04-24', '2026-04-27', 'aktif', '2026-04-24 05:09:00'),
(19, 1, 'HRD', 'Pria/Wanita', 'aswdsfghjkertyu', 'fghjmkxcvbnm', 'wertyuio', 'sxdcv', 'Full-Time', 'Rp. 3.000.000', '2026-04-26', '2026-06-06', 'aktif', '2026-04-26 14:20:22'),
(20, 2, 'Finishing Packing', 'Pria / Wanita', 'qwertyuio', 'sdfghjkvbnm', 'wertyuiop', 'asdfghjk', 'Freelance', 'Rp. 1.000.000', '2026-04-26', '2026-05-08', 'aktif', '2026-04-26 14:28:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_organisasi`
--

CREATE TABLE `tb_organisasi` (
  `id_organisasi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nama_organisasi` varchar(150) NOT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `tahun_mulai` year(4) DEFAULT NULL,
  `tahun_selesai` year(4) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_organisasi`
--

INSERT INTO `tb_organisasi` (`id_organisasi`, `id_siswa`, `nama_organisasi`, `posisi`, `lokasi`, `tahun_mulai`, `tahun_selesai`, `keterangan`, `created_at`) VALUES
(1, 3, 'Himpunan Mahasiswa', 'Anggota divisi kominfo (komunikasi dan informasi)', 'Universitas Wijaya Kusuma Surabaya', '2026', '2026', 'Sebagai Anggota divisi Kominfo', '2026-04-15 01:30:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pendidikan`
--

CREATE TABLE `tb_pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tingkat` enum('SD','MI','SMP','MTS','SMA','SMK','MA','D3','D4','S1') NOT NULL,
  `sekolah` varchar(150) NOT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `ipk` varchar(10) DEFAULT NULL,
  `akreditasi` varchar(100) DEFAULT NULL,
  `tgl_mulai` year(4) DEFAULT NULL,
  `tgl_selesai` year(4) DEFAULT NULL,
  `negara` text DEFAULT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pendidikan_terakhir` enum('Ya','Tidak') DEFAULT 'Tidak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pendidikan`
--

INSERT INTO `tb_pendidikan` (`id_pendidikan`, `id_siswa`, `tingkat`, `sekolah`, `jurusan`, `ipk`, `akreditasi`, `tgl_mulai`, `tgl_selesai`, `negara`, `provinsi`, `kota`, `created_at`, `pendidikan_terakhir`) VALUES
(1, 3, 'SMK', 'SMKN 13 Surabaya', 'DKV', '90,56', 'B', '0000', '0000', 'Indonesia', 'Jawa Timur', 'Kab. Gresik', '2026-04-15 01:18:21', 'Tidak'),
(2, 3, 'SD', 'SDN Bibis 113 Surabaya', '', '', 'B / Baik S', '2026', '2026', 'Indonesia', 'Jawa Timur', 'Surabaya', '2026-04-15 01:26:54', 'Tidak'),
(3, 3, 'S1', 'Universitas Wijaya Kusuma Surabaya', 'Informatika', '3,89', 'Baik Sekali', '0000', '0000', 'Indonesia', 'Jawa Timur', 'Surabaya', '2026-04-15 01:27:39', 'Tidak'),
(4, 3, 'SMP', 'SMPN 14 Surabaya', '', '', 'A / Unggul', '2026', '2026', 'Indonesia', 'Jawa Timur', 'Surabaya', '2026-04-15 01:28:26', 'Tidak'),
(5, 2, 'SD', 'SDN Bibis 113 Surabaya', '', '', 'B / Baik Sekali', '2026', '2026', 'Indonesia', 'Jawa Timur', 'Kab. Gresik', '2026-04-26 15:37:01', 'Tidak'),
(6, 2, 'SMP', 'SMPN 14 Surabaya', '', '', 'B / Baik Sekali', '2026', '2026', 'Indonesia', 'Jawa Timur', 'Kab. Gresik', '2026-04-26 15:37:21', 'Tidak'),
(7, 2, 'S1', 'Universitas Wijaya Kusuma Surabaya', 'Teknik Informatika', '3,89', 'B', '2026', '2026', 'Indonesia', 'Jawa Timur', 'Kab. Gresik', '2026-04-26 15:37:59', 'Ya'),
(8, 2, 'SMK', 'SMKN 13 Surabaya', 'Teknik Instalasi Tenaga Listrik (TI', '', 'B / Baik Sekali', '2026', '2026', 'Indonesia', 'Jawa Timur', 'Kab. Gresik', '2026-04-26 16:00:40', 'Tidak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengalaman`
--

CREATE TABLE `tb_pengalaman` (
  `id_pengalaman` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `level_jabatan` varchar(50) NOT NULL,
  `status_pegawai` varchar(50) NOT NULL,
  `negara` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `industri` varchar(100) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `saat_ini` enum('Ya','Tidak') DEFAULT 'Tidak',
  `mata_uang` varchar(50) NOT NULL,
  `gaji` int(11) NOT NULL,
  `nama_referensi` varchar(100) NOT NULL,
  `kontak_referensi` int(11) NOT NULL,
  `hubungan_referensi` varchar(100) NOT NULL,
  `fasilitas` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `alasan` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pengalaman`
--

INSERT INTO `tb_pengalaman` (`id_pengalaman`, `id_siswa`, `nama_perusahaan`, `posisi`, `level_jabatan`, `status_pegawai`, `negara`, `provinsi`, `kota`, `kecamatan`, `industri`, `tanggal_mulai`, `tanggal_selesai`, `saat_ini`, `mata_uang`, `gaji`, `nama_referensi`, `kontak_referensi`, `hubungan_referensi`, `fasilitas`, `deskripsi`, `alasan`, `created_at`) VALUES
(2, 3, 'CV. Barokah Printing', 'Operator Desain', 'Senior', 'PWT/Pekerja Waktu Tertentu (Contract)', 'Indonesia', 'Jawa Timur', 'Kab. Gresik', 'Wringinanom', 'Desain & Kreatif', '0000-00-00', '0000-00-00', 'Ya', 'IDR', 2999999, 'raditya', 2147483647, 'Atasan Langsung (Direct Report)', 'xcvbnm', 'asdfghj', 'sdfgvbnm', '2026-05-04 06:11:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_perusahaan`
--

CREATE TABLE `tb_perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `bidang_usaha` varchar(100) DEFAULT NULL,
  `jumlah_karyawan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `manfaat` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('Belum Diverifikasi','Terverifikasi','Ditolak') DEFAULT 'Belum Diverifikasi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_perusahaan`
--

INSERT INTO `tb_perusahaan` (`id_perusahaan`, `id_user`, `nama_perusahaan`, `bidang_usaha`, `jumlah_karyawan`, `alamat`, `kota`, `no_hp`, `email`, `website`, `deskripsi`, `manfaat`, `logo`, `status_verifikasi`, `created_at`) VALUES
(1, 14, 'Pt. Miwon Indonesia', 'Bumbu Masak', '200-500 employes', 'Jl. Raya Driyorejo No.265, Dusun Karanglo, Driyorejo, Kec. Driyorejo, Kabupaten Gresik, Jawa Timur 61177', NULL, NULL, 'miwonindonesia@gmail.com', NULL, 'PT Miwon Indonesia (sekarang PT Daesang Ingredients Indonesia) adalah pabrik yang memproduksi bumbu masak dan bahan makanan, terutama Monosodium Glutamat (MSG) atau penyedap rasa merek Miwon. Selain MSG, pabrik yang berbasis di Gresik ini memproduksi pati jagung (corn starch), pemanis (sweeteners), serta bahan pakan ternak. ', 'BPJS, Bonus, Uang Makan, Uang Transport', 'logo_1776919003.png', 'Terverifikasi', '2026-04-13 05:29:33'),
(2, 15, 'PT Dayasa Aria Prima', 'Paper Manufacturer', '5,001-10,000 employees', 'Jl. Raya Driyorejo No.KM. 25, Dusun Karanglo, Driyorejo, Kec. Driyorejo, Kabupaten Gresik, Jawa Timur 61177', NULL, NULL, 'dayasaprm@gmail.com', NULL, 'wertyuiop', 'zxfghuiop', 'logo_1776621305.jpg', 'Terverifikasi', '2026-04-19 17:50:12'),
(13, 37, 'PT. Wings Surya', 'Pusat produksi sabun dan deterjen', '5,001-10,000 employees', 'Jl. Raya Tenaru, Kecamatan Driyorejo, Kabupaten Gresik, Jawa Timur.', NULL, NULL, 'ptwings@gmail.com', NULL, '', '', 'logo_1777442989.jpg', 'Belum Diverifikasi', '2026-04-29 06:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sekolah`
--

CREATE TABLE `tb_sekolah` (
  `id_sekolah` int(11) NOT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `npsn` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `kepala_sekolah` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `jumlah_siswa` int(11) DEFAULT 0,
  `jumlah_jurusan` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sertifikasi`
--

CREATE TABLE `tb_sertifikasi` (
  `id_sertifikasi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nama_sertifikat` varchar(150) NOT NULL,
  `lembaga` varchar(150) DEFAULT NULL,
  `tahun_sertifikat` year(4) DEFAULT NULL,
  `tahun_berlaku` year(4) DEFAULT NULL,
  `skor` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sertifikasi`
--

INSERT INTO `tb_sertifikasi` (`id_sertifikasi`, `id_siswa`, `nama_sertifikat`, `lembaga`, `tahun_sertifikat`, `tahun_berlaku`, `skor`, `created_at`) VALUES
(1, 3, 'Sertifikasi Magang', 'SMKN 7 Surabaya', '2026', '2026', 'Baik Sekali', '2026-04-15 01:29:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `jekel` enum('Pria','Wanita') NOT NULL,
  `status_perkawinan` enum('Belum Menikah','Menikah') NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `kewarganegaraan` varchar(50) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `prestasi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `id_user`, `nama`, `nisn`, `jekel`, `status_perkawinan`, `tempat_lahir`, `tanggal_lahir`, `nik`, `agama`, `kewarganegaraan`, `alamat`, `no_hp`, `email`, `jurusan`, `tahun_lulus`, `tinggi_badan`, `berat_badan`, `deskripsi`, `prestasi`, `foto`, `created_at`) VALUES
(2, 4, 'Neti Indah Purwaningsih', '0043758091', 'Pria', 'Belum Menikah', 'Nganjuk', '2000-02-16', '3518025406040001', NULL, 'Indonesia', 'Perumahan Taman Sumengko Indah Blok J nomor 6, RT 020 RW 008, Kel. Sumengko, Kec. Wringinanom, Kab. Gresik', '085733423198', 'neti21@gmail.com', '', '2024', 0, 0, '', '', 'profil_0043758091_1776941206.jpg', '2026-04-11 02:17:43'),
(3, 7, 'Sapna Estevania Putri', '0098765432', 'Wanita', 'Belum Menikah', 'Nganjuk, Jawa Timur', '2004-06-14', '0081234567890', '', 'Indonesia', 'Perumahan Taman Sumengko Indah Blok J nomor 6, RT 020 RW 008, Kel. Sumengko, Kec. Wringinanom, Kab. Gresik', '085733423198', 'sapnaputri1406@gmail.com', 'Teknik Komputer Jaringan', '2021', 159, 56, 'saya adalah orang', 'memiliki banyak prestai terpendam', 'profil_0098765432_1777445339.png', '2026-04-12 05:22:59'),
(8, 22, 'Amara Aurelia', '00123456', 'Pria', 'Belum Menikah', '', '0000-00-00', '', NULL, '', '', '', 'amara@gmail.com', 'Teknik Elektro', '2025', 0, 0, '', '', 'profil_00123456_1777132457.png', '2026-04-24 08:30:00'),
(11, 34, 'Fadil Bagas Prastya', '005672345', 'Pria', 'Belum Menikah', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', NULL, '2026-04-25 19:37:30'),
(13, 36, 'Ardy Diva Febriansyah', '00789456', 'Pria', 'Belum Menikah', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', NULL, '2026-04-25 19:41:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sosial_media`
--

CREATE TABLE `tb_sosial_media` (
  `id_sosial_media` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_platform` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sosial_media`
--

INSERT INTO `tb_sosial_media` (`id_sosial_media`, `id_user`, `nama_platform`, `username`, `link`, `created_at`) VALUES
(10, 14, 'instagram', NULL, 'https://instagram.com/sapnastevani', '2026-04-13 08:29:17'),
(14, 14, 'facebook', NULL, 'https://facebook.com/sapnastevani', '2026-04-13 11:04:08'),
(20, 14, 'whatsapp', NULL, 'https://wa.me/qr/3HNHQPBLWDVIF1', '2026-04-22 16:05:59'),
(21, 14, 'linkedin', NULL, 'https://www.linkedin.com/in/sapnastevania', '2026-04-22 16:06:31'),
(22, 15, 'instagram', NULL, 'https://instagram.com/sapnastevani', '2026-04-24 05:33:18'),
(25, 7, 'website', NULL, 'https://jam.bmkg.go.id/JamServerFS.html', '2026-04-25 06:26:39'),
(32, 7, 'instagram', NULL, 'www.instagram.com/sapnastevani', '2026-04-25 06:42:16'),
(33, 7, 'linkedin', NULL, 'https://www.linkedin.com/in/sapnastevania/', '2026-04-25 06:42:50'),
(34, 4, 'instagram', NULL, 'www.instagram.com/sapnastevani', '2026-04-26 15:36:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tracer`
--

CREATE TABLE `tb_tracer` (
  `id_tracer` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `status_setelah_lulus` enum('Bekerja','Studi','Belum Bekerja') NOT NULL,
  `nama_instansi` varchar(150) DEFAULT NULL,
  `jenis_instansi` varchar(100) DEFAULT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `alamat_instansi` text DEFAULT NULL,
  `tahun_mulai` varchar(255) DEFAULT NULL,
  `gaji` varchar(50) DEFAULT NULL,
  `kesesuaian_jurusan` enum('sesuai','tidak_sesuai') DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu` varchar(50) DEFAULT NULL,
  `nama_kampus` varchar(150) DEFAULT NULL,
  `jurusan_kuliah` varchar(150) DEFAULT NULL,
  `jenjang_pendidikan` varchar(50) DEFAULT NULL,
  `status_kampus` varchar(50) DEFAULT NULL,
  `sumber_biaya` varchar(50) DEFAULT NULL,
  `aktivitas` varchar(150) DEFAULT NULL,
  `cara_cari_kerja` varchar(150) DEFAULT NULL,
  `kendala` text DEFAULT NULL,
  `luar_kota` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_tracer`
--

INSERT INTO `tb_tracer` (`id_tracer`, `id_siswa`, `status_setelah_lulus`, `nama_instansi`, `jenis_instansi`, `posisi`, `alamat_instansi`, `tahun_mulai`, `gaji`, `kesesuaian_jurusan`, `keterangan`, `created_at`, `waktu`, `nama_kampus`, `jurusan_kuliah`, `jenjang_pendidikan`, `status_kampus`, `sumber_biaya`, `aktivitas`, `cara_cari_kerja`, `kendala`, `luar_kota`) VALUES
(4, 2, 'Studi', 'PT. Ajinomoto', 'Swasta', 'Markering', NULL, NULL, '2.000.000-4.000.000', NULL, NULL, '2026-04-25 15:44:39', '2 Bulan', 'Universitas Wijaya Kusuma Surabaya', 'Teknik Informatika', 'S1', 'Perguruan Tinggi Swasta', 'Mandiri', 'Mencari Kerja', 'Internet', '', 'Ya'),
(5, 3, 'Bekerja', 'PT. Ajinomoto', 'BUMN', 'Buruh Pabrikk', NULL, NULL, '<2.000.000', NULL, NULL, '2026-04-25 15:49:55', '2 Bulan', 'Universitas Wijaya Kusuma Surabaya', 'Teknik Informatika', 'S1', 'Perguruan Tinggi Swasta', 'Mandiri', 'Mencari Kerja', 'Internet', '', 'Ya'),
(6, 8, 'Belum Bekerja', '', '', '', NULL, NULL, '', NULL, NULL, '2026-04-25 15:54:59', '', '', '', 'D3', 'Perguruan Tinggi Negeri', 'Mandiri', 'Wirausaha', 'BKK Sekolah', 'Belum memiliki pengalaman', 'Ya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','siswa','perusahaan') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `nama`, `email`, `password`, `role`, `foto`, `status`, `last_login`, `created_at`, `reset_token`, `reset_expired`) VALUES
(1, 'admin', 'Admin BKK', 'admin@gmail.com', '$2y$10$BNRXbSfXxY.8oX6YeO3VEerrmX1j.igKLuomQDLbaKXt58TE7nFZO', 'admin', NULL, 'aktif', NULL, '2026-04-09 10:12:15', NULL, NULL),
(4, '0043758091', 'Neti Indahdjs', 'neti21@gmail.com', '$2y$10$qHY95VnzaHqaUbzyHtRVJ.IoV8E8zpXBjTQgwUnQdSB5Sdt6MvOAq', 'siswa', NULL, 'aktif', NULL, '2026-04-11 01:55:33', NULL, NULL),
(7, '0098765432', 'Sapna Estevania Putri', 'sapnaputri1406@gmail.com', '$2y$10$piGgblGkFCibkXr.a4uhZefD6PuPCkQW4HVBO74LjwuFV8iZInSDO', 'siswa', NULL, 'aktif', NULL, '2026-04-12 05:22:59', NULL, NULL),
(14, 'ptmiwon', '', '', '$2y$10$eAViRD/5eOc6Bcw.TfQu1Oc7WabF12SHYtQCuzblGpyyn.rJdpk96', 'perusahaan', NULL, 'aktif', '2026-05-13 15:01:40', '2026-04-13 05:29:33', NULL, NULL),
(15, 'ptdayasa', '', '', '$2y$10$A4/0XjH6.6j7c59k4zpL1.T8nJ8IZjB6kxqlHMc/ciPP3C4nuIxfS', 'perusahaan', NULL, 'aktif', NULL, '2026-04-19 17:50:12', NULL, NULL),
(22, '00123456', 'Amara Aurelia', 'amara@gmail.com', '$2y$10$FRx4zMECNrQeByQqF4rzee1yF.Ze2yX0JmDWAXbmnJ9jjmp7Oipim', 'siswa', NULL, 'aktif', NULL, '2026-04-24 08:30:00', NULL, NULL),
(34, '005672345', 'Fadil Bagas Prastya', 'fdl@gmail.com', '$2y$10$4RmOHaSnpxkNq/cB/MZCVOHg36MeSTYMTJEljiUiHm7NSSOBE4o4a', 'siswa', NULL, 'aktif', NULL, '2026-04-25 19:37:30', NULL, NULL),
(36, '00789456', 'Ardy Diva Febriansyah', 'ardy@gmail.com', '$2y$10$q0t2./wFtv.USyw1yejmkuWbBXq.BaTP0/7M6clZpO2OJyd1VGObS', 'siswa', NULL, 'aktif', NULL, '2026-04-25 19:41:34', NULL, NULL),
(37, 'ptwings', '', '', '$2y$10$hKSQqQ6eR7Q8QVjPIwBPDe2MMoHwOeNHM2FC42eXiP1bbYnhqVo/G', 'perusahaan', NULL, 'aktif', NULL, '2026-04-29 06:04:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  ADD PRIMARY KEY (`id_dokumen`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_dokumen_perusahaan`
--
ALTER TABLE `tb_dokumen_perusahaan`
  ADD PRIMARY KEY (`id_dokumenper`),
  ADD KEY `id_perusahaan` (`id_perusahaan`);

--
-- Indeks untuk tabel `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `fk_jadwal_lamaran` (`id_lamaran`),
  ADD KEY `fk_jadwal_lowongan` (`id_lowongan`),
  ADD KEY `fk_jadwal_perusahaan` (`id_perusahaan`);

--
-- Indeks untuk tabel `tb_keluarga`
--
ALTER TABLE `tb_keluarga`
  ADD PRIMARY KEY (`id_keluarga`),
  ADD KEY `fk_keluarga_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_kelulusan`
--
ALTER TABLE `tb_kelulusan`
  ADD PRIMARY KEY (`id_kelulusan`),
  ADD KEY `fk_kelulusan_siswa` (`id_siswa`),
  ADD KEY `fk_kelulusan_lowongan` (`id_lowongan`);

--
-- Indeks untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  ADD PRIMARY KEY (`id_lamaran`),
  ADD KEY `fk_lamaran_siswa` (`id_siswa`),
  ADD KEY `fk_lamaran_lowongan` (`id_lowongan`);

--
-- Indeks untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  ADD PRIMARY KEY (`id_lowongan`),
  ADD KEY `fk_lowongan_perusahaan` (`id_perusahaan`);

--
-- Indeks untuk tabel `tb_organisasi`
--
ALTER TABLE `tb_organisasi`
  ADD PRIMARY KEY (`id_organisasi`),
  ADD KEY `fk_organisasi_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_pendidikan`
--
ALTER TABLE `tb_pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`),
  ADD KEY `fk_pendidikan_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_pengalaman`
--
ALTER TABLE `tb_pengalaman`
  ADD PRIMARY KEY (`id_pengalaman`),
  ADD KEY `fk_pengalaman_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`),
  ADD KEY `fk_perusahaan_user` (`id_user`);

--
-- Indeks untuk tabel `tb_sekolah`
--
ALTER TABLE `tb_sekolah`
  ADD PRIMARY KEY (`id_sekolah`);

--
-- Indeks untuk tabel `tb_sertifikasi`
--
ALTER TABLE `tb_sertifikasi`
  ADD PRIMARY KEY (`id_sertifikasi`),
  ADD KEY `fk_sertifikasi_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `fk_siswa_user` (`id_user`);

--
-- Indeks untuk tabel `tb_sosial_media`
--
ALTER TABLE `tb_sosial_media`
  ADD PRIMARY KEY (`id_sosial_media`),
  ADD KEY `fk_sosmed_user` (`id_user`);

--
-- Indeks untuk tabel `tb_tracer`
--
ALTER TABLE `tb_tracer`
  ADD PRIMARY KEY (`id_tracer`),
  ADD KEY `fk_tracer_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_dokumen_perusahaan`
--
ALTER TABLE `tb_dokumen_perusahaan`
  MODIFY `id_dokumenper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_keluarga`
--
ALTER TABLE `tb_keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_kelulusan`
--
ALTER TABLE `tb_kelulusan`
  MODIFY `id_kelulusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  MODIFY `id_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  MODIFY `id_lowongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tb_organisasi`
--
ALTER TABLE `tb_organisasi`
  MODIFY `id_organisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_pendidikan`
--
ALTER TABLE `tb_pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_pengalaman`
--
ALTER TABLE `tb_pengalaman`
  MODIFY `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_sekolah`
--
ALTER TABLE `tb_sekolah`
  MODIFY `id_sekolah` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_sertifikasi`
--
ALTER TABLE `tb_sertifikasi`
  MODIFY `id_sertifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_sosial_media`
--
ALTER TABLE `tb_sosial_media`
  MODIFY `id_sosial_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tb_tracer`
--
ALTER TABLE `tb_tracer`
  MODIFY `id_tracer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  ADD CONSTRAINT `tb_dokumen_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokumen_perusahaan`
--
ALTER TABLE `tb_dokumen_perusahaan`
  ADD CONSTRAINT `tb_dokumen_perusahaan_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id_perusahaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `fk_jadwal_lamaran` FOREIGN KEY (`id_lamaran`) REFERENCES `tb_lamaran` (`id_lamaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jadwal_lowongan` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id_lowongan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jadwal_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id_perusahaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_keluarga`
--
ALTER TABLE `tb_keluarga`
  ADD CONSTRAINT `fk_keluarga_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kelulusan`
--
ALTER TABLE `tb_kelulusan`
  ADD CONSTRAINT `fk_kelulusan_lowongan` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id_lowongan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  ADD CONSTRAINT `fk_lamaran_lowongan` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id_lowongan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lamaran_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  ADD CONSTRAINT `fk_lowongan_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id_perusahaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_organisasi`
--
ALTER TABLE `tb_organisasi`
  ADD CONSTRAINT `fk_organisasi_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendidikan`
--
ALTER TABLE `tb_pendidikan`
  ADD CONSTRAINT `fk_pendidikan_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengalaman`
--
ALTER TABLE `tb_pengalaman`
  ADD CONSTRAINT `fk_pengalaman_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  ADD CONSTRAINT `fk_perusahaan_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_sertifikasi`
--
ALTER TABLE `tb_sertifikasi`
  ADD CONSTRAINT `fk_sertifikasi_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `fk_siswa_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_sosial_media`
--
ALTER TABLE `tb_sosial_media`
  ADD CONSTRAINT `fk_sosmed_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_tracer`
--
ALTER TABLE `tb_tracer`
  ADD CONSTRAINT `fk_tracer_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

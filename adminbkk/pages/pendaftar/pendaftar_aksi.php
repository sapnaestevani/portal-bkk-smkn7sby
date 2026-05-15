<?php
include "../../koneksi.php";

// ✅ Cek session untuk keamanan
session_start();
if (!isset($_SESSION['ses_level']) || ($_SESSION['ses_level'] != 'admin' && $_SESSION['ses_level'] != 'Ka. BKK' && $_SESSION['ses_level'] != 'perusahaan')) {
    echo "<script>alert('Akses ditolak!'); window.location='../../login_perusahaan.php';</script>";
    exit;
}

if (!isset($_GET['aksi'])) {
    echo "<script>alert('Aksi tidak ditemukan!'); window.history.back();</script>";
    exit;
}

$aksi = $_GET['aksi'];
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

if ($kode == '') {
    echo "<script>alert('Kode pendaftaran tidak ditemukan!'); window.history.back();</script>";
    exit;
}

if ($aksi == 'hapus') {

    // ✅ PERBAIKAN: Gunakan tabel tb_lamaran dengan kolom id_lamaran
    // ✅ Tambahan: Hapus hanya jika milik perusahaan yang login (untuk keamanan)
    
    if ($_SESSION['ses_level'] == 'perusahaan') {
        // Perusahaan hanya bisa hapus lamaran untuk lowongan miliknya
        $hapus = mysqli_query($con, "
            DELETE l FROM tb_lamaran l
            INNER JOIN tb_lowongan lw ON l.id_lowongan = lw.id_lowongan
            WHERE l.id_lamaran='$kode' AND lw.id_perusahaan='".$_SESSION['id_perusahaan']."'
        ");
    } else {
        // Admin/Ka. BKK bisa hapus semua
        $hapus = mysqli_query($con, "DELETE FROM tb_lamaran WHERE id_lamaran='$kode'");
    }

    if ($hapus) {
        echo "<script>alert('Data lamaran berhasil dihapus!'); window.location='../../index.php?halaman=pendaftar_tampil';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($con) . "'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Aksi tidak valid!'); window.history.back();</script>";
    exit;
}
?>
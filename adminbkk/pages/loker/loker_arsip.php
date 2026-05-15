<?php
// 1. Koneksi Database
include_once("koneksi.php");

// 2. Cek apakah parameter 'kode' (id_lowongan) ada
if (isset($_GET['kode'])) {
    
    // Sanitasi input untuk keamanan
    $id_lowongan = mysqli_real_escape_string($con, $_GET['kode']);

    // ✅ PERBAIKAN UTAMA:
    // - Ganti tabel 'tb_loker' menjadi 'tb_lowongan'
    // - Ganti kolom 'id_loker' menjadi 'id_lowongan'
    // - Ganti status 'Arsip' menjadi 'nonaktif' (sesuai struktur ENUM database)
    $sql_arsip = "UPDATE tb_lowongan SET status = 'nonaktif' WHERE id_lowongan = '$id_lowongan'";
    
    $query_arsip = mysqli_query($con, $sql_arsip);

    if ($query_arsip) {
        echo "<script>alert('✅ Lowongan Berhasil Diarsipkan (Status: Nonaktif)!'); window.location.href='?halaman=loker_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal Mengarsipkan Lowongan: " . mysqli_error($con) . "'); window.location.href='?halaman=loker_tampil';</script>";
    }
    exit;
} else {
    // Jika tidak ada kode ID, redirect kembali ke halaman tampil
    echo "<script>window.location.href='?halaman=loker_tampil';</script>";
    exit;
}
?>
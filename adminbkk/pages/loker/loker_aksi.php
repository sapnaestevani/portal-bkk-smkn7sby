<?php
// 1. Koneksi Database
// Pastikan path ini sesuai dengan lokasi file ini terhadap koneksi.php
// Jika file ini ada di adminbkk/pages/loker/loker_aksi.php, maka:
include_once __DIR__ . '/../../koneksi.php';

// Cek apakah user login (Opsional tapi disarankan untuk keamanan)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('Session habis!'); window.location.href='../../login.php';</script>";
    exit;
}

// ================== PROSES UPDATE LOWONGAN ==================
if (isset($_POST['btnUBAH'])) {

    // Sanitasi Input
    $id_loker = mysqli_real_escape_string($con, $_POST['txtkode_loker'] ?? '');
    $judul_lowongan = mysqli_real_escape_string($con, $_POST['txtjudul_lowongan'] ?? '');
    $jekel = mysqli_real_escape_string($con, $_POST['txtjekel'] ?? '');
    $posisi = mysqli_real_escape_string($con, $_POST['txtposisi'] ?? '');
    $deskripsi = mysqli_real_escape_string($con, $_POST['txtdeskripsi'] ?? '');
    $kualifikasi = mysqli_real_escape_string($con, $_POST['txtkualifikasi'] ?? '');
    $lokasi = mysqli_real_escape_string($con, $_POST['txtlokasi'] ?? '');
    $jenis_pekerjaan = mysqli_real_escape_string($con, $_POST['txtjenis_pekerjaan'] ?? '');
    $gaji = mysqli_real_escape_string($con, $_POST['txtgaji'] ?? '');
    $tanggal_posting = mysqli_real_escape_string($con, $_POST['txttanggal_posting'] ?? '');
    $batas_lamaran = mysqli_real_escape_string($con, $_POST['txtbatas_lamaran'] ?? '');
    // Status biasanya tetap 'aktif' saat edit, atau bisa ambil dari POST jika ada dropdown status
    $status = 'aktif';

    // Validasi ID
    if (empty($id_loker)) {
        echo "<script>alert('❌ ID Lowongan tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Query Update (HANYA kolom yang ada di tb_lowongan)
    $sql_ubah = "UPDATE tb_lowongan SET
        judul_lowongan  = '$judul_lowongan',
        jekel           = '$jekel',
        posisi          = '$posisi',
        deskripsi       = '$deskripsi',
        kualifikasi     = '$kualifikasi',
        lokasi          = '$lokasi',
        jenis_pekerjaan = '$jenis_pekerjaan',
        gaji            = '$gaji',
        tanggal_posting = '$tanggal_posting',
        batas_lamaran   = '$batas_lamaran',
        status          = '$status'
        WHERE id_lowongan = '$id_loker'";

    $query_ubah = mysqli_query($con, $sql_ubah);

    if ($query_ubah) {
        // Ambil ID lowongan dari input POST untuk digunakan di URL redirect
        $id_redirect = mysqli_real_escape_string($con, $_POST['txtkode_loker'] ?? '');

        echo "<script>
alert('✅ Data Lowongan Berhasil Diubah!');
window.location='index.php?halaman=loker_tampil&detail=$id_redirect';
</script>";
    } else {
        echo "<script>alert('❌ Gagal Mengubah Data: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
    exit;
}

// ================== PROSES ARSIP (NONAKTIFKAN) ==================
elseif (isset($_POST['btnArsip'])) {

    $id_loker = mysqli_real_escape_string($con, $_POST['txtkode_loker'] ?? '');

    if (empty($id_loker)) {
        echo "<script>alert('❌ ID Lowongan tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Update status menjadi 'nonaktif'
    $sql_ubah = "UPDATE tb_lowongan SET
        status = 'nonaktif'
        WHERE id_lowongan = '$id_loker'";

    $query_ubah = mysqli_query($con, $sql_ubah);

    if ($query_ubah) {
        echo "<script>alert('✅ Lowongan Berhasil Diarsipkan (Nonaktif)!'); window.location.href='../../index.php?halaman=loker_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal Mengarsipkan: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
    exit;
}

// ================== PROSES HAPUS LOWONGAN ==================
elseif (isset($_GET['kode'])) {

    $id_loker = mysqli_real_escape_string($con, $_GET['kode']);

    if (empty($id_loker)) {
        echo "<script>alert('❌ ID Lowongan tidak valid!'); window.location.href='../../index.php?halaman=loker_tampil';</script>";
        exit;
    }

    try {
        // Langkah 1: Hapus data lamaran yang terkait dengan lowongan ini
        // Ini penting karena tb_lamaran memiliki foreign key ke tb_lowongan
        $sql_hapus_lamaran = "DELETE FROM tb_lamaran WHERE id_lowongan = '$id_loker'";
        mysqli_query($con, $sql_hapus_lamaran);

        // Langkah 2: Hapus data lowongan itu sendiri
        $sql_hapus = "DELETE FROM tb_lowongan WHERE id_lowongan = '$id_loker'";
        $query_hapus = mysqli_query($con, $sql_hapus);

        if ($query_hapus) {
    $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/bkk/SistemBKK_smkn7/adminbkk/index.php?halaman=loker_tampil";

    echo "<script>
        alert('✅ Lowongan dan Data Lamaran Terkait Berhasil Dihapus!');
        window.location.href='$base_url';
    </script>";
} else {
    throw new Exception(mysqli_error($con));
}

    } catch (Exception $e) {
        echo "<script>alert('❌ Terjadi Kesalahan Sistem: " . addslashes($e->getMessage()) . "'); window.location.href='../../index.php?halaman=loker_tampil';</script>";
    }
    exit;
}

// Jika diakses tanpa metode yang benar, redirect kembali
echo "<script>window.location.href='../../index.php?halaman=loker_tampil';</script>";
exit;
?>
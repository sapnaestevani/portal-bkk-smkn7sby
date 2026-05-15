<?php
include_once("koneksi.php");

// =======================
// PROSES UPDATE
// =======================
if (isset($_POST['btnUBAH'])) {

    $id_jadwal   = intval($_POST['id_jadwal'] ?? 0);
    $id_lowongan = mysqli_real_escape_string($con, $_POST['id_lowongan'] ?? '');
    $tanggal     = mysqli_real_escape_string($con, $_POST['tanggal'] ?? '');
    $waktu       = mysqli_real_escape_string($con, $_POST['waktu'] ?? '');
    $lokasi      = mysqli_real_escape_string($con, $_POST['lokasi'] ?? '');
    $keterangan  = mysqli_real_escape_string($con, $_POST['keterangan'] ?? '');

    // Validasi
    if (empty($id_jadwal) || empty($tanggal) || empty($waktu) || empty($lokasi)) {
        echo "<script>alert('❌ Data tidak lengkap!');window.history.back();</script>";
        exit;
    }

    // Query update (SUDAH BENAR)
    $sql = "UPDATE tb_jadwal SET
        id_lowongan = '$id_lowongan',
        tanggal     = '$tanggal',
        waktu       = '$waktu',
        lokasi      = '$lokasi',
        keterangan  = '$keterangan'
        WHERE id_jadwal = '$id_jadwal'
    ";

    $query = mysqli_query($con, $sql);

    if ($query) {
        echo "<script>alert('✅ Ubah berhasil');window.location='index.php?halaman=jadwal_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal: ".addslashes(mysqli_error($con))."');window.history.back();</script>";
    }

    exit;
}


// =======================
// PROSES HAPUS (SOFT DELETE)
// =======================
if (isset($_GET['kode'])) {

    $id_jadwal = intval($_GET['kode']);

    // GANTI DELETE → UPDATE status
    $sql = "UPDATE tb_jadwal SET status='dibatalkan' WHERE id_jadwal='$id_jadwal'";

    $query = mysqli_query($con, $sql);

    if ($query) {
        echo "<script>alert('✅ Hapus berhasil');window.location='index.php?halaman=jadwal_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal hapus');window.history.back();</script>";
    }

    exit;
}
?>
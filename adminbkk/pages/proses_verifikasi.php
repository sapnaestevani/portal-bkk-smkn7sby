<?php
include_once("koneksi.php");

if (isset($_GET['username']) && isset($_GET['aksi'])) {

    $username = mysqli_real_escape_string($con, $_GET['username']);
    $aksi = $_GET['aksi'];

    // tentukan status
    if ($aksi == "verifikasi") {
        $status = "Terverifikasi";
    } elseif ($aksi == "tolak") {
        $status = "Ditolak";
    } else {
        $status = "Belum Diverifikasi";
    }

    // UPDATE KE TB_PERUSAHAAN (INI YANG BENAR)
    $update = mysqli_query($con, "
        UPDATE tb_perusahaan p
        JOIN tb_user u ON p.id_user = u.id_user
        SET p.status_verifikasi = '$status'
        WHERE u.username = '$username'
    ");

    if ($update) {
        echo "<script>
        alert('Status verifikasi berhasil diperbarui');
        window.location='?halaman=verifikasi_perusahaan';
        </script>";
    } else {
        echo "<script>
        alert('Gagal update: " . mysqli_error($con) . "');
        window.location='?halaman=verifikasi_perusahaan';
        </script>";
    }

} else {

    echo "<script>
    alert('Data tidak ditemukan');
    window.location='?halaman=verifikasi_perusahaan';
    </script>";
}
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "koneksi.php";

/* =========================
CEK SESSION
========================= */
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}

$username = $_SESSION['ses_username'];

/* =========================
AMBIL USER
========================= */
$q_user = mysqli_query($con, "SELECT id_user FROM tb_user WHERE username='$username'");

if (!$q_user) {
    die("Query user error: " . mysqli_error($con));
}

$data_user = mysqli_fetch_assoc($q_user);

if (!$data_user) {
    echo "<script>alert('User tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$id_user = $data_user['id_user'];

/* =========================
AMBIL PERUSAHAAN
========================= */
$q_perusahaan = mysqli_query($con, "SELECT id_perusahaan FROM tb_perusahaan WHERE id_user='$id_user'");

if (!$q_perusahaan) {
    die("Query perusahaan error: " . mysqli_error($con));
}

$data_perusahaan = mysqli_fetch_assoc($q_perusahaan);

if (!$data_perusahaan) {
    echo "<script>alert('Profil perusahaan belum dibuat'); window.location='index.php?halaman=profile';</script>";
    exit;
}

$id_perusahaan = $data_perusahaan['id_perusahaan'];

/* =========================
UPDATE STATUS
========================= */
$update = mysqli_query($con, "
UPDATE tb_perusahaan 
SET status_verifikasi='Menunggu Verifikasi'
WHERE id_perusahaan='$id_perusahaan'
");

if (!$update) {
    die("Update error: " . mysqli_error($con));
}

/* =========================
SUCCESS
========================= */
echo "<script>
alert('Pengajuan verifikasi berhasil dikirim');
window.location='index.php?halaman=profile#verifikasi';
</script>";
?>
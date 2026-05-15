<?php
session_start();
include "koneksi.php"; // sesuaikan nama file koneksi kamu

// cek login admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != "Admin") {
    header("Location: login.php");
    exit;
}

$id_admin = $_SESSION['id_admin']; // pastikan session ini ada

if (isset($_POST['ubah'])) {

    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // ambil password lama dari database
    $query = mysqli_query($koneksi, "SELECT password FROM admin WHERE id_admin='$id_admin'");
    $data = mysqli_fetch_assoc($query);

    // cek password lama
    if ($password_lama != $data['password']) {
        echo "<script>alert('Password lama salah!'); window.location='admin_ganti_password.php';</script>";
        exit;
    }

    // cek konfirmasi password baru
    if ($password_baru != $konfirmasi_password) {
        echo "<script>alert('Konfirmasi password baru tidak cocok!'); window.location='admin_ganti_password.php';</script>";
        exit;
    }

    // update password baru
    $update = mysqli_query($koneksi, "UPDATE admin SET password='$password_baru' WHERE id_admin='$id_admin'");

    if ($update) {
        echo "<script>alert('Password berhasil diubah!'); window.location='beranda_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah password!'); window.location='admin_ganti_password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ganti Password Admin</title>
</head>
<body>

<h2>Ganti Password Admin</h2>

<form method="POST">
    <label>Password Lama</label><br>
    <input type="password" name="password_lama" required><br><br>

    <label>Password Baru</label><br>
    <input type="password" name="password_baru" required><br><br>

    <label>Konfirmasi Password Baru</label><br>
    <input type="password" name="konfirmasi_password" required><br><br>

    <button type="submit" name="ubah">Ubah Password</button>
</form>

</body>
</html>

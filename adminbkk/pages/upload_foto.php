<?php
include_once("koneksi.php");

if (isset($_POST['btnUpload'])) {

    $username = $_SESSION["ses_username"];

    $nama_file = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if ($nama_file != "") {

        $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_baru = "user_" . $username . "_" . time() . "." . $ext;

        $folder = "dist/img/foto_user/";

        move_uploaded_file($tmp, $folder . $nama_baru);

        mysqli_query($con, "UPDATE user SET foto='$nama_baru' WHERE username='$username'");

        echo "<script>alert('Foto berhasil diubah!'); window.location='?halaman=profile';</script>";
    } else {
        echo "<script>alert('Pilih foto dulu!');</script>";
    }
}
?>

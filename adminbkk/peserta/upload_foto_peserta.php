<?php
session_start();
include_once("../koneksi.php");

if (!isset($_SESSION["ses_nisn"])) {
    echo "<script>alert('Anda belum login!'); window.location='../peserta.php';</script>";
    exit;
}

$nisn = $_SESSION["ses_nisn"];

if (isset($_POST['btnUpload'])) {

    $nama_file = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if ($nama_file != "") {

        $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if ($ext != "jpg" && $ext != "jpeg" && $ext != "png") {
            echo "<script>alert('Format foto harus JPG / JPEG / PNG'); window.location='index_pst.php?halaman=profile';</script>";
            exit;
        }

        $nama_baru = "peserta_" . $nisn . "_" . time() . "." . $ext;

        $folder = "foto/";

        if (move_uploaded_file($tmp, $folder . $nama_baru)) {

            mysqli_query($con, "UPDATE tb_peserta SET foto='$nama_baru' WHERE nisn='$nisn'");

            echo "<script>alert('Foto berhasil diubah!'); window.location='index_pst.php?halaman=profile';</script>";
        } else {
            echo "<script>alert('Upload gagal! Folder foto tidak ada / tidak bisa ditulis'); window.location='index_pst.php?halaman=profile';</script>";
        }
    } else {
        echo "<script>alert('Silakan pilih foto dulu'); window.location='index_pst.php?halaman=profile';</script>";
    }
}
?>

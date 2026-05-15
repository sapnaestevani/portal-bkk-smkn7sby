<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

include_once "koneksi.php";

$data_username = $_SESSION['ses_username'];

$tipe = $_GET['tipe'];

$query = mysqli_query($con,"SELECT * FROM user WHERE username='$data_username'");
$data = mysqli_fetch_assoc($query);

$file = $data[$tipe];

/* hapus file dari folder */
if($file!="" && file_exists("dokumen/".$file)){
unlink("dokumen/".$file);
}

/* kosongkan database */
mysqli_query($con,"UPDATE user SET `$tipe`='' WHERE username='$data_username'");

echo "<script>
alert('Dokumen berhasil dihapus');
window.location='?halaman=profile&tab=dokumen#dokumen';
</script>";
?>
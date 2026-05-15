<?php
session_start();
include "koneksi.php";

$data_username = $_SESSION['ses_username'];

$tipe   = $_POST['tipe'];
$tautan = mysqli_real_escape_string($con,$_POST['tautan']);

$allowed = ['facebook','instagram','linkedin','website','whatsapp'];

if(in_array($tipe,$allowed)){

mysqli_query($con,"UPDATE user SET `$tipe`='$tautan' WHERE username='$data_username'");

echo "<script>
alert('Data berhasil diperbarui');
window.location='?halaman=profile&tab=sosial#sosial';
</script>";

}else{

echo "<script>
alert('Data tidak valid');
window.location='?halaman=profile&tab=sosial#sosial';
</script>";

}
?>
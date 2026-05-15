<?php 
  
 //Mendapatkan Nilai ID
 $id = $_GET['id'];
 
 //Import File Koneksi Database
 require_once('koneksi.php');
 
 //Membuat SQL Query
 $sql = "DELETE FROM tb_pendaftaran WHERE id_pendaftaran=$id;";
 
 
 //Menghapus Nilai pada Database 
 if(mysqli_query($con,$sql)){
 echo 'Berhasil Menghapus Pendaftaran';
 }else{
 echo 'Gagal Menghapus Pendaftaran';
 }
 
 mysqli_close($con);
 ?>
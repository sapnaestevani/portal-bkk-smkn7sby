<?php
     include_once("koneksi.php");
    if(isset($_GET['kode'])){
    $sql_arsip = "UPDATE tb_pendaftaran SET status = 'Lolos' where id_loker = '".$_GET['kode']."'";
        $query_arsip = mysqli_query($con, $sql_arsip);

            if ($query_arsip) {
                echo "<script>alert('Konfirmasi Berhasil')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?halaman=pendaftar_tampil'>";
            }else{
                echo "<script>alert('konfirmasi Gagal')</script>";
                echo "<meta http-equiv='refresh' content='0; url=halaman=pendaftar_tampil'>";
            }
        }
?>
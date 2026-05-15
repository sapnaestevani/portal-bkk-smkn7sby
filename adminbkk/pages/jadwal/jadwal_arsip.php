<?php
     include_once("koneksi.php");
    if(isset($_GET['kode'])){
    $sql_arsip = "UPDATE tb_jadwal SET keterangan = 'Arsip' where kode_jadwal = '".$_GET['kode']."'";
        $query_arsip = mysqli_query($con, $sql_arsip);

            if ($query_arsip) {
                echo "<script>alert('Arsip Berhasil')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?halaman=jadwal_tampil'>";
            }else{
                echo "<script>alert('Arsip Gagal')</script>";
                echo "<meta http-equiv='refresh' content='0; url=halaman=jadwal_tampil'>";
            }
        }
?>
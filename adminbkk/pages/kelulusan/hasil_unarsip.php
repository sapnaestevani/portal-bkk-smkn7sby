<?php
  include_once("koneksi.php");
    if(isset($_GET['kode'])){
    $sql_unarsip = "UPDATE tb_kelulusan SET keterangan = 'Tampil' where kode_hasil = '".$_GET['kode']."'";
        $query_unarsip = mysqli_query($con, $sql_unarsip);

            if ($query_unarsip) {
                echo "<script>alert('Tampil Berhasil')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?halaman=hasil_tampil'>";
            }else{
                echo "<script>alert('tampil Gagal')</script>";
                echo "<meta http-equiv='refresh' content='0; url=halaman=hasil_tampil'>";
            }
        }
?>
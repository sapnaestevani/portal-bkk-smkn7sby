<?php
	 include_once("koneksi.php");

    $sql_hapus = "DELETE FROM tb_loker WHERE id_loker='".$_GET['kode']."'";
        $query_hapus = mysqli_query($con, $sql_hapus);

            if ($query_hapus) {
                echo "<script>alert('Hapus Berhasil')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?halaman=loker_tampil'>";
            }else{
                echo "<script>alert('Hapus Gagal')</script>";
                echo "<meta http-equiv='refresh' content='0; url=halaman=loker_tampil'>";
            }
?>
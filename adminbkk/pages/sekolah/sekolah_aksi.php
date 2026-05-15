  <?php
   include_once("koneksi.php");
  if (isset ($_POST['btnUBAH'])){
        //mulai proses ubah
        $sql_ubah = "UPDATE tb_sekolah SET
            nama_sekolah='".addslashes($_POST['txtnama_sekolah'])."',
            email='".$_POST['txtemail']."',
            keterangan='".$_POST['txtketerangan']."',
            tahun='".$_POST['txttahun']."'        
            WHERE id_sekolah='".$_POST['txtidsekolah']."'";
        $query_ubah = mysqli_query($con, $sql_ubah);

        if ($query_ubah) {
            echo "<script>alert('Ubah Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=sekolah_tampil'>";
        }else{
            echo "<script>alert('Ubah Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=sekolah_tampil'>";
        }
        //selesai proses ubah

    }else{
        //mulai proses hapus
        if(isset($_GET['kode'])){
            $sql_hapus = "DELETE FROM tb_sekolah WHERE id_sekolah='".$_GET['kode']."'";
            $query_hapus = mysqli_query($con, $sql_hapus);

            if ($query_hapus) {
                echo "<script>alert('Hapus Berhasil')</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=sekolah_tampil'>";
            }else{
                echo "<script>alert('Hapus Gagal')</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=sekolah_tampil'>";
            }
        }
        //selesai proses hapus
    }

?>
<?php
    if (isset ($_POST['btnSIMPAN'])){
        //mulai proses simpan
        $sql_simpan = "INSERT INTO tb_user (nisn,password,level) VALUES (
            '".$_POST['txtnisn']."',
            '".$_POST['txtpassword']."',
            '".'Peserta'."')";
        $query_simpan = mysqli_query($con, $sql_simpan);

        if ($query_simpan) {
            echo "<script>alert('Simpan Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=user_tampil'>";
        }else{
            echo "<script>alert('Simpan Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=user_tampil'>";
        }
        //selesai proses simpan

    }else if (isset ($_POST['btnUBAH'])){
        //mulai proses ubah
        $sql_ubah = "UPDATE tb_user SET
           password='".$_POST['txtpassword']."',
           level='".'Peserta'."')
           WHERE nisn='".$_POST['txtnisn']."'";
        $query_ubah = mysqli_query($con, $sql_ubah);

        if ($query_ubah) {
            echo "<script>alert('Ubah Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=user_tampil'>";
        }else{
            echo "<script>alert('Ubah Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=user_tampil'>";
        }
        //selesai proses ubah

    }else{
        //mulai proses hapus
        if(isset($_GET['kode'])){
            $sql_hapus = "DELETE FROM tb_user WHERE nisn='".$_GET['kode']."'";
            $query_hapus = mysqli_query($con, $sql_hapus);

            if ($query_hapus) {
                echo "<script>alert('Hapus Berhasil')</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=user_tampil'>";
            }else{
                echo "<script>alert('Hapus Gagal')</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=user_tampil'>";
            }
        }
        //selesai proses hapus
    }

?>
<?php
 include_once("koneksi.php");

	if (isset($_POST['btnSimpan'])) {
		$sql_insert = "INSERT INTO tb_sekolah (id_sekolah,nama_sekolah,email,keterangan,tahun) VALUES (
					'".$_POST['txtidsekolah']."',
					'".addslashes($_POST['txtnama_sekolah'])."',
					'".$_POST['txtemail']."',
					'".$_POST['txtketerangan']."',
					'".$_POST['txttahun']."')";
		$query_insert = mysqli_query($con,$sql_insert) or die (mysqli_error());
		
		if($query_insert) {
            echo "<script>alert('Simpan Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=sekolah_tampil'>";
			
		}else{
			echo "<script>alert('Simpan Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=sekolah_tampil'>";
		}
	}
?>

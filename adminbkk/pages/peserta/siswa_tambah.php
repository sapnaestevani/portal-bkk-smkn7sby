<?php
 include_once("koneksi.php");

	if (isset($_POST['btnSimpan'])) {
		$sql_insert = "INSERT INTO tb_peserta (nisn,nama,jekel,tempat_lhr,tgl_lhr,nama_ortu,alamat,telp,jurusan,id_sekolah,tahun_lulus) VALUES (
                    '".$_POST['txtnisn']."',
                    '".$_POST['txtnama_siswa']."',
					'".$_POST['rbjekel']."',
                    '".$_POST['txttempat']."',
                    '".$_POST['txttanggal']."',
                    '".$_POST['txtnama_ortu']."',
                    '".$_POST['txtalamat']."',
                    '".$_POST['txtno_telp']."',
                    '".$_POST['txtjurusan']."',
                    '".$_POST['txtasal_sek']."',
					'".$_POST['txttahun']."')";
		$query_insert = mysqli_query($con,$sql_insert) or die (mysqli_error());
		
		if($query_insert) {
            echo "<script>alert('Simpan Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=siswa_tampil'>";
			
		}else{
			echo "<script>alert('Simpan Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=siswa_tampil'>";
		}
	}
?>

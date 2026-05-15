<?php
	
	if($_SERVER['REQUEST_METHOD']=='GET'){
	
		//Mendapatkan Nilai Variable
		$nisnreg = $_GET['nisnreg'];
		$nama = $_GET['nama'];
        $jekel = $_GET['jekel'];
        $tempat_lhr = $_GET['tempat_lhr'];
        $tgl_lhr = $_GET['tgl_lhr'];
        $ortu = $_GET['ortu'];
        $alamat = $_GET['alamat'];
        $telp = $_GET['telp'];
        $jurusan = $_GET['jurusan'];
        $id_sekolah = $_GET['sekolah'];
        $tahun = $_GET['tahun'];
        
        $tgl_lhr = date("Y-m-d", strtotime($tgl_lhr));
	
		//Pembuatan Syntax SQL
		$sql = "INSERT INTO tb_peserta (nisn,nama,jekel,tempat_lhr,tgl_lhr,nama_ortu,alamat,telp,jurusan,id_sekolah,tahun_lulus) VALUES 
        ('$nisnreg','$nama','$jekel','$tempat_lhr','$tgl_lhr','$ortu','$alamat','$telp','$jurusan','$id_sekolah','$tahun')";
			require_once('koneksi.php');
// 		echo $sql;
		//Eksekusi Query database
		if(mysqli_query($con,$sql)){
			echo 'Berhasil Melakukan Registrasi';
		}else{
			echo 'Gagal Registrasi';
		}
		
		mysqli_close($con);
	}
?>
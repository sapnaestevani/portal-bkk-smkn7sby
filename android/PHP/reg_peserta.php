<?php
//Import File Koneksi database
require_once('koneksi.php');
		
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		//Mendapatkan Nilai Variable
		$nisn = $_POST['nisn'];
		$nama = $_POST['nama'];
        $jekel = $_POST['jekel'];
        $tempat_lhr = $_POST['tempat_lhr'];
        $tgl_lhr = $_POST['tgl_lhr'];
        $ortu = $_POST['ortu'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $jurusan = $_POST['jurusan'];
        $id_sekolah = $_POST['sekolah'];
        $tahun = $_POST['tahun'];
		
		//Pembuatan Syntax SQL
		$sql = "INSERT INTO tb_peserta (nisn,nama,jekel,tempat_lhr,tgl_lhr,nama_ortu,alamat,telp,jurusan,id_sekolah,tahun_lulus) VALUES 
        ('$nisn','$nama','$jekel','$tempat_lhr','$tgl_lhr','$ortu','$alamat','$telp','$jur','$id_sekolah','$tahun')";
		
		
		//Eksekusi Query database
		if(mysqli_query($con,$sql)){
			echo 'Berhasil Melakukan Registrasi';
		}else{
			echo 'Gagal Registrasi';
		}
		
		mysqli_close($con);
	}
?>
<?php 
	$id = $_GET['id'];
// 	$id = $_GET['id_pendaftaran'];
	
	//Importing database
	require_once('koneksi.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
// 	$sql = "SELECT id, contoh.id_loker, contoh.nisn, tb_loker.nm_loker, tb_loker.nm_perusahaan, tb_peserta.nama, berkas FROM contoh, tb_loker, tb_peserta WHERE contoh.id_loker=tb_loker.id_loker AND contoh.nisn=tb_peserta.nisn AND contoh.id=$id";
	$sql = "SELECT id_pendaftaran, tb_pendaftaran.id_loker, tb_pendaftaran.nisn, tb_loker.nm_loker, tb_loker.nm_perusahaan, tb_peserta.nama, tb_sekolah.nama_sekolah, berkas FROM tb_pendaftaran, tb_loker, tb_peserta, tb_sekolah WHERE tb_pendaftaran.id_loker=tb_loker.id_loker AND tb_pendaftaran.nisn=tb_peserta.nisn AND tb_sekolah.id_sekolah=tb_peserta.id_sekolah AND tb_pendaftaran.id_pendaftaran=$id";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql);
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
// 			"id"=>$row['id'],
// // 			"id_loker"=>$row['id_loker'],
// // 			"nisn"=>$row['nisn'],
// 			"berkas"=>$row['berkas']
			
			"id"=>$row['id_pendaftaran'],
			"id_loker"=>$row['id_loker'],
			"loker"=>$row['nm_loker'],
			"perusahaan"=>$row['nm_perusahaan'],
			"nisn"=>$row['nisn'],
			"nama"=>$row['nama'],
			"sekolah"=>$row['nama_sekolah'],
			"berkas"=>$row['berkas']
		));
 
	//Menampilkan dalam format JSON
	echo json_encode(array('result'=>$result));
	
	
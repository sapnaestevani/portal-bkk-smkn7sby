<?php 
 
 /*
 
 penulis: Muhammad yusuf
 website: https://www.kodingindonesia.com/
 
 */
	
	//Mendapatkan Nilai Dari Variable ID Pegawai yang ingin ditampilkan
	$id = $_GET['id_loker'];
	
	//Importing database
	require_once('koneksi.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	$sql = "SELECT * FROM tb_loker WHERE status ='Tampil' AND id_loker='$id'";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql);
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
		"id_loker"=>$row['id_loker'],
		"nama_per"=>$row['nm_perusahaan'],
		"nama_lok"=>$row['nm_loker'],
		"keterangan"=>$row['keterangan'],
		"sumber"=>$row['sumber'],
		"status"=>$row['status']
	));
 
	//Menampilkan dalam format JSON
	echo json_encode(array('result'=>$result));
	
	
<?php 
    // $konek = mysqli_connect("localhost","root","","bkk");
	//Import File Koneksi Database
	require_once('koneksi.php');
	
	//Membuat SQL Query
	$nisn = $_GET['id'];
// 	$sql = "SELECT tb_jadwal.kode_jadwal,tb_jadwal.id_loker, tb_loker.nm_perusahaan, tb_loker.nm_loker, tgl_tes,tempat,waktu FROM tb_jadwal,tb_loker WHERE tb_jadwal.id_loker=tb_loker.id_loker AND tb_jadwal.keterangan = 'Tampil' ";
		$sql = "SELECT tb_jadwal.kode_jadwal,tb_jadwal.id_loker, tb_loker.nm_perusahaan, tb_loker.nm_loker, tgl_tes,tempat,waktu, tb_pendaftaran.nisn FROM tb_jadwal,tb_loker,tb_pendaftaran WHERE tb_jadwal.id_loker=tb_loker.id_loker AND tb_pendaftaran.id_loker=tb_loker.id_loker AND tb_jadwal.keterangan = 'Tampil' AND tb_pendaftaran.nisn='$nisn'";
	mysqli_set_charset($con, 'utf8');
	//Mendapatkan Hasil
	//$r = mysqli_query($konek,$sql);
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
            "id_loker"=>$row['id_loker'],
            "nm_perusahaan"=>$row['nm_perusahaan'],
            "tgl_tes"=>$row['tgl_tes'],
            "tempat"=>$row['tempat'],
            "waktu"=>$row['waktu']
		));
    }
   
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
    mysqli_close($con);
    ?>
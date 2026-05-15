<?php 
    require_once('koneksi.php');
	//Import File Koneksi Database
	//require_once('koneksi.php');
	
	
	
// 	Membuat SQL Query
// 	$sql = "SELECT * FROM dummy ";
// 	$sql = "SELECT * FROM contoh ";
    
  	$nisn = $_GET['id'];
// 	$sql = "SELECT id, contoh.id_loker, contoh.nisn, tb_loker.nm_loker, tb_loker.nm_perusahaan, tb_peserta.nama, berkas FROM contoh, tb_loker, tb_peserta WHERE contoh.id_loker=tb_loker.id_loker AND contoh.nisn=tb_peserta.nisn AND contoh.nisn='$nisn' ORDER BY id DESC";

	$sql = "SELECT id_pendaftaran, tb_pendaftaran.id_loker, tb_pendaftaran.nisn, tb_loker.nm_loker, tb_loker.nm_perusahaan, tb_peserta.nama, berkas FROM tb_pendaftaran, tb_loker, tb_peserta WHERE tb_pendaftaran.id_loker=tb_loker.id_loker AND tb_pendaftaran.nisn=tb_peserta.nisn AND tb_pendaftaran.nisn='$nisn' ORDER BY id_pendaftaran DESC";
// 	mysqli_set_charset($con, 'utf8');
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
            // "id"=>$row['id'],
            // "id_loker"=>$row['id_loker'],
            
            // "id"=>$row['id'],
            // "berkas"=>$row['berkas']
            
            "id"=>$row['id_pendaftaran'],
			"id_loker"=>$row['id_loker'],
			"loker"=>$row['nm_loker'],
			"perusahaan"=>$row['nm_perusahaan'],
			"nisn"=>$row['nisn'],
			"nama"=>$row['nama'],
			"berkas"=>$row['berkas']
		));
	}
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
    mysqli_close($con);

    ?>
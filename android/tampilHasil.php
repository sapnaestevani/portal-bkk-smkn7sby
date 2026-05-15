<?php 
    // $konek = mysqli_connect("localhost","root","","bkk");
	//Import File Koneksi Database
	require_once('koneksi.php');
	
	//Membuat SQL Query
	$nisn = $_GET['id'];
// 	$sql = "SELECT tb_kelulusan.kode_hasil, tb_loker.nm_perusahaan, tb_loker.nm_loker, berkas,url, tb_kelulusan.keterangan FROM tb_kelulusan, tb_loker WHERE tb_kelulusan.id_loker=tb_loker.id_loker AND tb_kelulusan.keterangan = 'Tampil' ORDER BY kode_hasil DESC";
	$sql = "SELECT tb_kelulusan.kode_hasil, tb_loker.nm_perusahaan, tb_loker.nm_loker, tb_kelulusan.berkas,url, tb_kelulusan.keterangan, tb_pendaftaran.nisn FROM tb_kelulusan, tb_loker, tb_pendaftaran WHERE tb_kelulusan.id_loker=tb_loker.id_loker AND tb_pendaftaran.id_loker=tb_loker.id_loker AND tb_kelulusan.keterangan = 'Tampil' AND tb_pendaftaran.nisn='$nisn' ORDER BY kode_hasil DESC";
	mysqli_set_charset($con, 'utf8');
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
            "kode_hasil"=>$row['kode_hasil'],
            "nama_per"=>$row['nm_perusahaan'],
            "nama_lok"=>$row['nm_loker'],
            "berkas"=>$row['berkas'],
            "url"=>$row['url']
		));
    }
   
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
    mysqli_close($con);
    ?>
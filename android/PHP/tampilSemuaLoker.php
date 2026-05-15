<?php 
    $konek = mysqli_connect("localhost","root","","bkk");
	//Import File Koneksi Database
	//require_once('koneksi.php');
	
	//Membuat SQL Query
	$sql = "SELECT * FROM tb_loker WHERE status ='Tampil'";
	mysqli_set_charset($konek, 'utf8');
	//Mendapatkan Hasil
	$r = mysqli_query($konek,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
            "id_loker"=>$row['id_loker'],
            "nama_per"=>$row['nm_perusahaan']
		));
	}
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
    mysqli_close($konek);
    ?>
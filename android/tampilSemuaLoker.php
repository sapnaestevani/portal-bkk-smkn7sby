<?php 
    require_once('koneksi.php');
    // $konek = mysqli_connect("localhost","id14911511_root","PepsiCola@723","id14911511_bkk");
	//Import File Koneksi Database
	//require_once('koneksi.php');
	
	//Membuat SQL Query
	$sql = "SELECT * FROM tb_loker WHERE status ='Tampil'";
	mysqli_set_charset($con, 'utf8');
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
            "id_loker"=>$row['id_loker'],
            "nama_per"=>$row['nm_perusahaan'],
            "nama_lok"=>$row['nm_loker'],
            "jekel"=>$row['jekel'],
            "keterangan"=>$row['keterangan'],
            "batas"=>$row['batas']
		));
	}
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
    mysqli_close($con);
    ?>
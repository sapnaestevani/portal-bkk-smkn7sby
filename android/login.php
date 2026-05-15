<?php

	include_once "koneksi.php";

	class usr{}
	
	$nisn = $_GET["username"];
	$pass = $_GET["password"];
	
	if ((empty($nisn)) || (empty($pass))) { 
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom tidak boleh kosong"; 
		die(json_encode($response));
	}
	
	$query = mysqli_query($con, "SELECT tb_user.nisn, tb_peserta.nama, password FROM tb_user, tb_peserta WHERE tb_user.nisn=tb_peserta.nisn AND tb_user.nisn='$nisn' AND password='$pass'");
	
			$result = array();
	$row = mysqli_fetch_array($query);
	if (!empty($row)){
	   // 	$query2 = mysqli_query($con, "SELECT tb_user.nisn, tb_peserta.nama , tb_sekolah.nama_sekolah, tb_peserta.tahun_lulus FROM tb_user, tb_peserta, tb_sekolah WHERE tb_user.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_user.nisn='$nisn' AND password='$pass'");
// 		$response = new usr();
// 		$response->success = 1;
// 		$response->message = "Selamat datang ".$row['nama'];
// 		//$response->id = $row['id'];
// 		$response->username = $row['nisn'];
		array_push($result,array(
			"success"=>1,
            "nisn"=>$row['nisn'],
            "nama"=>$row['nama']
            // "sekolah"=>$row['nama_sekolah'],
            // "tahun"=>$row['tahun_lulus']
		));
		
		die(json_encode(array('result'=>$result)));
		
		
	} else { 
// 		$response = new usr();
// 		$response->success = 0;
// 		$response->message = "Username atau password salah";
// 		die(json_encode($response));
		array_push($result,array(
			"success"=>0,
            "nisn"=>$nisn,
            "nama"=>'Tidakada'
		));
		
		die(json_encode(array('result'=>$result)));
	}
	
	mysqli_close($con);

?>
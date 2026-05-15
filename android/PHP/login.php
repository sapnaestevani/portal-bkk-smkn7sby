<?php
	include_once "koneksi.php";

	class usr{}
	
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	if ((empty($nisn)) || (empty($password))) { 
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom tidak boleh kosong"; 
		die(json_encode($response));
	}
	
	$query = mysqli_query($con, "SELECT tb_user.nisn, tb_peserta.nama, password FROM tb_user, tb_peserta WHERE tb_user.nisn=tb_peserta.nisn AND tb_user.nisn='$nisn' AND password='$password'");
	
	$row = mysqli_fetch_array($query);
	
	if (!empty($row)){
		$response = new usr();
		$response->success = 1;
		$response->message = "Selamat datang ".$row['nama'];
		$response->id = $row['nisn'];
		$response->nisn = $row['nisn'];
		die(json_encode($response));
		
	} else { 
		$response = new usr();
		$response->success = 0;
		$response->message = "Username atau password salah";
		die(json_encode($response));
	}
	
	mysqli_close($con);

?>
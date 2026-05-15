<?php

	if($_SERVER['REQUEST_METHOD']=='GET'){
		
		//Mendapatkan Nilai Variable
		$nisn = $_GET['nisn'];
		$pass = $_GET['pass'];
		
		
		//Pembuatan Syntax SQL
		$sql = "INSERT INTO tb_user (nisn,password,level) VALUES ('$nisn','$pass','Peserta')";
		
		//Import File Koneksi database
		require_once('koneksi.php');
		
		//Eksekusi Query database
		if(mysqli_query($con,$sql)){
			echo 'Berhasil Melakukan Registrasi';
		}else{
			echo 'Gagal Melakukan Registrasi';
		}
		
		mysqli_close($con);
	}
?>
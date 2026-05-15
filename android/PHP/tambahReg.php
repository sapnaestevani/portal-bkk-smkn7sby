<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		//Mendapatkan Nilai Variable
		$nisn = $_POST['nisn'];
		$pass = $_POST['password'];
		
		
		//Pembuatan Syntax SQL
		$sql = "INSERT INTO tb_user (nisn,password,level) VALUES ('$nisn','$pass','Tampil')";
		
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
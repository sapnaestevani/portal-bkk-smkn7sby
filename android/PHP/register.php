<?php
	include_once "koneksi.php";

	class usr{}

	$nisn = $_POST["username"];
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];

	if ((empty($nisn))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom NISN tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($password))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom password tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($confirm_password)) || $password != $confirm_password) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Konfirmasi password tidak sama";
		die(json_encode($response));
	} else {
		if (!empty($nisn) && $password == $confirm_password){
			$num_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_user WHERE nisn='".$nisn."'"));

			if ($num_rows == 0){
				$query = mysqli_query($con, "INSERT INTO tb_user (nisn, password, level) VALUES(0,'".$nisn."','".$password."','".'Peserta'."')");

				if ($query){
					$response = new usr();
					$response->success = 1;
					$response->message = "Register berhasil, silahkan login.";
					die(json_encode($response));

				} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Username sudah ada";
					die(json_encode($response));
				}
			} else {
				$response = new usr();
				$response->success = 0;
				$response->message = "Username sudah ada";
				die(json_encode($response));
			}
		}
	}

	mysqli_close($con);

?>	
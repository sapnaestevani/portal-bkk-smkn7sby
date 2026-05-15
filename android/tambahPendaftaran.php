<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
  	// echo $_SERVER["DOCUMENT_ROOT"];  // /home1/demonuts/public_html
	//including the database connection file
  	include_once("koneksi.php");
  		$carikode = mysqli_query($con,"SELECT MAX(id_pendaftaran) FROM tb_pendaftaran") or die (mysqli_error());
	// menjadikannya array
	$datakode = mysqli_fetch_array($carikode);
	// jika $datakode
	if ($datakode) {
	// membuat variabel baru untuk mengambil kode mulai dari 3
	$nilaikode = substr($datakode[0], 4);
	// menjadikan $nilaikode ( int )
	$kode = (int) $nilaikode;
	// setiap $kode di tambah 1
	$kode = $kode + 1;
	// hasil untuk menambahkan kode 
	// angka 3 untuk menambahkan tiga angka setelah B dan angka 0 angka yang berada di tengah
	// atau angka sebelum $kode
	$hasilkode = "PLK".str_pad($kode, 4, "0", STR_PAD_LEFT);
	}else{
		$hasilkode = "PLK0001";
	}
  	  	
  	//$_FILES['image']['name']   give original name from parameter where 'image' == parametername eg. city.jpg
  	//$_FILES['image']['tmp_name']  temporary system generated name
		$id_pendaftaran = $hasilkode;
// 		$id_loker = $_POST['id_loker'];
//         $nisn = $_POST['nisn'];
        $originalImgName= $_FILES['filename']['name'];
        $tempName= $_FILES['filename']['tmp_name'];
        $folder="upload/";
        $url = "https://febrian001.000webhostapp.com/android/upload/".$originalImgName; //update path as per your directory structure 
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){
                // $query = "INSERT INTO dummy (berkas) VALUES ('$url')";
                // $query = "INSERT INTO tb_pendaftaran (id_pendaftaran,id_loker,nisn,berkas) VALUES ('$id_pendaftaran','$id_loker','$nisn','$url')";
                $query = "INSERT INTO tb_pendaftaran (id_pendaftaran,berkas) VALUES ('$id_pendaftaran','$url')";

                if(mysqli_query($con,$query)){
                
                	 $query= "SELECT * FROM tb_pendaftaran WHERE berkas='$url'";
	                 $result= mysqli_query($con, $query);
	                 $emparray = array();
	                     if(mysqli_num_rows($result) > 0){  
	                     while ($row = mysqli_fetch_assoc($result)) {
                                     $emparray[] = $row;
                                   }
                                   echo json_encode(array( "status" => "true","message" => "Successfully file added!" , "data" => $emparray) );
                                   
	                     }else{
	                     		echo json_encode(array( "status" => "false1","message" => "Failed!") );
	                     }
			   
                }else{
                	echo json_encode(array( "status" => "false2","message" => "Failed!") );
                }
        	//echo "moved to ".$url;
        }else{
        	echo json_encode(array( "status" => "false3","message" => "Failed!") );
        }
  }
?>
?>
<?php 
    include_once("koneksi.php");
    $tahun = date ('Y');
    // KODE OTOMATIS
	// membuat query max untuk kode
	$carikode = mysqli_query($con,"SELECT MAX(id_pendaftaran) FROM tb_pendaftaran") or die (mysqli_error());
	// menjadikannya array
	$datakode = mysqli_fetch_array($carikode);
	// jika $datakode
	if ($datakode) {
	// membuat variabel baru untuk mengambil kode mulai dari 3
	$nilaikode = substr($datakode[0], 8);
	// menjadikan $nilaikode ( int )
	$kode = (int) $nilaikode;
	// setiap $kode di tambah 1
	$kode = $kode + 1;
	// hasil untuk menambahkan kode 
	// angka 3 untuk menambahkan tiga angka setelah B dan angka 0 angka yang berada di tengah
	// atau angka sebelum $kode
	$hasilkode = $tahun."/PD/".str_pad($kode,4, "0", STR_PAD_LEFT);
	}else{
		$hasilkode = "2020/PD/0001";
	}
    // KODE OTOMATIS
    ?>
<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
    $hasilkode;
  	$loker = $_POST['id_loker'];
  	$nisn = $_POST['nisnpen'];
    $originalImgName= $_FILES['filename']['name'];
    $tempName= $_FILES['filename']['tmp_name'];
    $folder="upload/";
    $url = "https://febrian001.000webhostapp.com/android/upload/".$originalImgName; //update path as per your directory structure 
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){
                $query = "INSERT INTO `tb_pendaftaran`(`id_pendaftaran`, `id_loker`, `nisn`, `berkas`) VALUES ('$hasilkode','$loker','$nisn','$url')";

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
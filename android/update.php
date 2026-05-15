<?php
 if($_SERVER['REQUEST_METHOD']=='POST'){
  	// echo $_SERVER["DOCUMENT_ROOT"];  // /home1/demonuts/public_html
	//including the database connection file
  	include_once("koneksi.php");
  	  	
  	//$_FILES['image']['name']   give original name from parameter where 'image' == parametername eg. city.jpg
  	//$_FILES['image']['tmp_name']  temporary system generated name
        print_r($_FILES);
        print_r($_POST);
        $id = $_POST['id'];
        $originalImgName= $_FILES['filename']['name'];
        $tempName= $_FILES['filename']['tmp_name'];
        $folder="upload/";
        $url = "https://febrian001.000webhostapp.com/android/upload/".$originalImgName; //update path as per your directory structure 
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){
                // $query = "UPDATE dummy SET berkas ='$url' WHERE dummy.id = $id";
                $query = "UPDATE tb_pendaftaran SET berkas ='$url' WHERE id_pendaftaran='$id'";
                // $query = "UPDATE dummy SET berkas ='$url'";
                if(mysqli_query($con,$query)){
                
                // 	 $query= "SELECT * FROM dummy WHERE berkas='$url' WHERE id = $id;";
	                 $query= "SELECT * FROM tb_pendaftaran WHERE berkas='$url'";
	                 $result= mysqli_query($con, $query);
	                 $emparray = array();
	                     if(mysqli_num_rows($result) > 0){  
	                     while ($row = mysqli_fetch_assoc($result)) {
                                     $emparray[] = $row;
                                  }
                                  echo json_encode(array( "status" => "true","message" => "Update Sukses" , "data" => $emparray) );
                                   
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
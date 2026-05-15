<?php 
// step 1: connect to database
// mysqli_connect function has 4 params (host,user name, password,database_name)
require_once('koneksi.php');
$con = mysqli_connect("localhost","root","","bkk");
 
$response = array();
header('Content-Type: application/json');
 
if(mysqli_connect_errno())
{
    $response["error"] = TRUE;
    $response["message"] ="Faild to connect to database";
    echo json_encode($response);
    exit;
}
 
 
if(isset($_POST["type"]) &amp;&amp; ($_POST["type"]=="signup") &amp;&amp; isset($_POST["nama"]) &amp;&amp; isset($_POST["nisn"]) &amp;&amp; isset($_POST["password"])){
    // signup user
    $name = $_POST["nama"];
    $nisn = $_POST["nisn"];
    $password = md5($_POST["password"]);
 
    //check user email whether its already regsitered
    $checkEmailQuery = "SELECT tb_user.nisn, tb_peserta.nama, password FROM tb_user, tb_peserta WHERE tb_user.nisn=tb_peserta.nisn AND password='$password'";
    $result = mysqli_query($con,$checkEmailQuery);
    // print_r($result); exit;
    if($result->num_rows>0){
        $response["error"] = TRUE;
        $response["message"] ="Sorry email already found.";
        echo json_encode($response);
        exit;
    }else{
        $signupQuery = "INSERT INTO tb_user(nisn,password,level) values('$name','$email','.Peserta.')";
        $signupResult = mysqli_query($con,$signupQuery);
        if($signupResult){
            // Get Last Inserted ID
            $id = mysqli_insert_id($con);
            // Get User By ID
            $userQuery = "SELECT nisn,password,level FROM tb_user WHERE nisn = ".$id;
            $userResult = mysqli_query($con,$userQuery);
             
            $user = mysqli_fetch_assoc($userResult);
             
            $response["error"] = FALSE;
            $response["message"] = "Successfully signed up.";
            $response["user"] = $user;
            echo json_encode($response);
            exit;
        }else{
            $response["error"] = TRUE;
            $response["message"] ="Unable to signup try again later.";
            echo json_encode($response);
            exit;
        }
         
    }
 
}else if(isset($_POST["type"]) &amp;&amp; ($_POST["type"]=="login") &amp;&amp; isset($_POST["nisn"]) &amp;&amp; isset($_POST["password"])){
    //login user
 
    $nisn = $_POST["nisn"];
    $password = md5($_POST["password"]);
 
    $userQuery = "SELECT tb_user.nisn, tb_peserta.nama, password FROM tb_user, tb_peserta WHERE tb_user.nisn=tb_peserta.nisn AND tb_user.nisn = '$nisn' &amp;&amp; password = '$password'";
    $result = mysqli_query($db_con,$userQuery);
    // print_r($result); exit;
    if($result->num_rows==0){
        $response["error"] = TRUE;
        $response["message"] ="user not found or Invalid login details.";
        echo json_encode($response);
        exit;
    }else{
        $user = mysqli_fetch_assoc($result);
        $response["error"] = FALSE;
        $response["message"] = "Successfully logged in.";
        $response["user"] = $user;
        echo json_encode($response);
        exit;
    }
 
}else {
    // Invalid parameters
    $response["error"] = TRUE;
    $response["message"] ="Invalid parameters";
    echo json_encode($response);
    exit;
}
?>
<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | BKK SMK NU MA'ARIF 3 KUDUS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <h2><a href="../index.php"><b>SI BKK - TRACER ALUMNI <BR>
                SMK NU MA'ARIF KUDUS</b></a></h2>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login untuk memulai</p>

    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username"  name="txtnis" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="txtpassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="btnLogin" >Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br> -->
    <a href="./user_add.php" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
<?php
    $konek = mysqli_connect("localhost","root","","bkk"); 

    if (isset($_POST['btnLogin'])) {
        $sql_login = "SELECT * FROM user WHERE username='".$_POST['txtnis']."' AND password='".$_POST['txtpassword']."'";
        $query_login = mysqli_query($konek, $sql_login);
        $data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
        $jumlah_login = mysqli_num_rows($query_login);
        
        if ($jumlah_login >=1 ){
            session_start();
            $_SESSION["ses_username"]=$data_login["username"];
            $_SESSION["ses_nama"]=$data_login["nama"];
            $_SESSION["ses_level"]=$data_login["level"];
            
            echo "<script>alert('Login Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
        }else{
            echo "<script>alert('Login Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=login.php'>";
        }
    }
?>

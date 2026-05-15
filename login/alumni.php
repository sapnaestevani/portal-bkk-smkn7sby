<?php
session_start();
session_destroy();
?>

<body OnLoad="document.login.username.focus();" colorbackground="blue">
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <h2><a href="index.php"><b>SI BKK - TRACER ALUMNI <BR>
                SMK NU MA'ARIF KUDUS</b></a></h2>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login untuk memulai</p>

    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username"  name="txtnis" required autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="txtpassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-5">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-3">
        <button class="btn btn-warning btn-sm">
           <a href="index.php" class="warning">Kembali 
           </button>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat btn-sm" name="btnLogin" >Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br> -->
    <a href="reg_perusahaan.php" class="text-center">Register a new membership (Perusahaan / CV)</a>

  </div>
  <!-- /.login-box-body -->
</div>
  <!-- jQuery 3 -->
<script src="adminbkk/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="adminbkk/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="adminbkk/plugins/iCheck/icheck.min.js"></script>
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
            echo "<meta http-equiv='refresh' content='0; url=../adminbkk/index.php'>";
        }else{
            echo "<script>alert('Login Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=login.php'>";
        }
    }
?>

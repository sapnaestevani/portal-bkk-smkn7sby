<?php
session_start();
session_destroy();

?>
<br><br><br><br>
<section>
</section>
<section>
<div class="container">
  <div class="row">
    <div>
      <body class="hold-transition login-page">
      <div class="center">
          <h4><a href="index.php"><b>SI BKK - TRACER ALUMNI <BR>
                      SMK NU MA'ARIF KUDUS</b></a></h4>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="center">Login untuk memulai</p>
      <div class = "center">
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
          <button type="submit" class="btn btn-primary btn-sm" name="btnLogin" >Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="reg_perusahaan.php" class="text-center">Register a new membership (Perusahaan / CV)</a>
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br> -->
    

      <!-- /.login-box -->
      </body>
    </div>
  </div>
</div>
</section>
<?php
    include_once("koneksi.php");

    if (isset($_POST['btnLogin'])) {
        $sql_login = "SELECT * FROM user WHERE username='".$_POST['txtnis']."' AND password='".$_POST['txtpassword']."'";
        $query_login = mysqli_query($con, $sql_login);
        $data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
        $jumlah_login = mysqli_num_rows($query_login);
        
        if ($jumlah_login >=1 ){
            session_start();
            $_SESSION["ses_username"]=$data_login["username"];
            $_SESSION["ses_nama"]=$data_login["nama"];
            $_SESSION["ses_level"]=$data_login["level"];
            
            echo "<script>alert('Login Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=adminbkk/index.php'>";
        }else{
            echo "<script>alert('Login Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=login.php'>";
        }
    }
?>

<!-- Footer
================================================== -->

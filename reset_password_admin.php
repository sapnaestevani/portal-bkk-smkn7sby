<?php
include_once("koneksi.php");

if (!isset($_GET['token'])) {
  echo "<script>alert('Token tidak valid!'); window.location='login_admin.php';</script>";
  exit;
}

$token = mysqli_real_escape_string($con, $_GET['token']);

$query = mysqli_query($con, "SELECT * FROM tb_user WHERE reset_token='$token' AND role='admin'");
$data = mysqli_fetch_array($query, MYSQLI_BOTH);

if (!$data) {
  echo "<script>alert('Token tidak ditemukan atau sudah digunakan!'); window.location='login_admin.php';</script>";
  exit;
}

// cek expired
if (date("Y-m-d H:i:s") > $data['reset_expired']) {
  echo "<script>alert('Token sudah kadaluarsa! Silakan lakukan reset ulang.'); window.location='lupa_password_admin.php';</script>";
  exit;
}

// proses reset password
if (isset($_POST['btnReset'])) {

  $password_baru = mysqli_real_escape_string($con, $_POST['password_baru']);
  $konfirmasi_password = mysqli_real_escape_string($con, $_POST['konfirmasi_password']);

  if ($password_baru != $konfirmasi_password) {
    echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
  } else {

    $password_baru = md5($password_baru);
    $update = mysqli_query($con, "UPDATE tb_user SET password='$password_baru', reset_token=NULL, reset_expired=NULL 
      WHERE username='".$data['username']."' AND role='admin'");

    if ($update) {
      echo "<script>alert('Password berhasil direset! Silakan login kembali.'); window.location='login_admin.php';</script>";
    } else {
      echo "<script>alert('Gagal reset password!');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reset Password | Admin</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="adminbkk/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="adminbkk/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="adminbkk/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="adminbkk/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="adminbkk/plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">

    <div class="login-logo">
      <h1><a href="index.php"><b>SI BKK - ADMIN<BR></b></a></h1>
      <h4><b>SMK Negeri 7 Surabaya</b></h4>
    </div>

    <div class="login-box-body">
      <p class="login-box-msg">Reset Password Admin/Operator</p>

      <form action="" method="POST">

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password Baru" name="password_baru" required autofocus>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Konfirmasi Password Baru" name="konfirmasi_password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <a href="login_admin.php" class="btn btn-warning btn-block btn-flat btn-sm">Kembali</a>
          </div>

          <div class="col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat btn-sm" name="btnReset">
              Reset Password
            </button>
          </div>
        </div>

      </form>

      <br>
      <center>
        <p>Repost by <a title="SMKN 7 Surabaya" target="_blank">SMKN 7 Surabaya</a></p>
      </center>

    </div>
  </div>

  <!-- jQuery 3 -->
  <script src="adminbkk/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="adminbkk/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="adminbkk/plugins/iCheck/icheck.min.js"></script>

  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      });
    });
  </script>

</body>

</html>

<?php
include_once("../koneksi.php");

if (!isset($_GET['token'])) {
  echo "<script>alert('Token tidak valid!'); window.location='peserta.php';</script>";
  exit;
}

$token = mysqli_real_escape_string($con, $_GET['token']);

$query = mysqli_query($con, "SELECT * FROM tb_user WHERE reset_token='$token' AND role='siswa'");
$data = mysqli_fetch_array($query, MYSQLI_BOTH);

if (!$data) {
  echo "<script>alert('Token tidak valid!'); window.location='peserta.php';</script>";
  exit;
}

if (date("Y-m-d H:i:s") > $data['reset_expired']) {
  echo "<script>alert('Token sudah kadaluarsa! Silakan reset ulang.'); window.location='lupa_password_peserta.php';</script>";
  exit;
}

if (isset($_POST['btnReset'])) {

  $password_baru = $_POST['password_baru'];
  $konfirmasi = $_POST['konfirmasi_password'];

  if ($password_baru != $konfirmasi) {
    echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
  } else {

   $id_user = $data['id_user'];

    // validasi password minimal
    if (strlen($password_baru) < 6) {
      echo "<script>
alert('Password minimal 6 karakter!');
window.location.href = window.location.href;
</script>";
      exit;
    }

    // cek user
     $cek_user = mysqli_query($con, "SELECT * FROM tb_user WHERE id_user='$id_user'");
    if (mysqli_num_rows($cek_user) == 0) {
      echo "<script>alert('Akun user tidak ditemukan!');</script>";
      exit;
    }

    // hash password dulu
    $hash = password_hash($password_baru, PASSWORD_DEFAULT);

    // update + simpan ke variabel
    $update = mysqli_query($con, "UPDATE tb_user 
    SET password='$hash', reset_token=NULL, reset_expired=NULL 
    WHERE id_user='$id_user'");

    if ($update) {
      echo "<script>alert('Password berhasil direset! Silakan login kembali.'); window.location='peserta.php';</script>";
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
  <title>Reset Password | Peserta</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">

    <div class="login-logo">
      <h1><a href="#"><b>SI BKK - ALUMNI</b></a></h1>
      <h4><b>SMK Negeri 7 Surabaya</b></h4>
    </div>

    <div class="login-box-body">
      <p class="login-box-msg">Reset Password Siswa/Alumni</p>

      <form method="POST">

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password Baru" name="password_baru" required
            autofocus>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Konfirmasi Password Baru" name="konfirmasi_password"
            required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <a href="peserta.php" class="btn btn-warning btn-block btn-flat btn-sm">Kembali</a>
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
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>

  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      });
    });
  </script>

</body>

</html>
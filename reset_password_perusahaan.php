<?php
include_once("koneksi.php");

if (!isset($_GET['token'])) {
  echo "<script>alert('Token tidak valid!'); window.location='login_perusahaan.php';</script>";
  exit;
}

$token = mysqli_real_escape_string($con, $_GET['token']);

$query = mysqli_query($con, "
SELECT * FROM tb_user 
WHERE reset_token='$token' AND role='perusahaan'
");

$data = mysqli_fetch_array($query, MYSQLI_BOTH);

if (!$data) {
  echo "<script>alert('Token tidak valid!'); window.location='login_perusahaan.php';</script>";
  exit;
}

if (date("Y-m-d H:i:s") > $data['reset_expired']) {
  echo "<script>alert('Token sudah kadaluarsa!'); window.location='lupa_password_perusahaan.php';</script>";
  exit;
}

if (isset($_POST['btnReset'])) {

  $password_baru = $_POST['password_baru'];
  $konfirmasi = $_POST['konfirmasi_password'];

  if ($password_baru != $konfirmasi) {
    echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
  } else {

    if (strlen($password_baru) < 6) {
      echo "<script>alert('Password minimal 6 karakter!');</script>";
      exit;
    }

    $hash = password_hash($password_baru, PASSWORD_DEFAULT);

    $update = mysqli_query($con, "
    UPDATE tb_user 
    SET password='$hash', reset_token=NULL, reset_expired=NULL 
    WHERE username='".$data['username']."'
    ");

    if ($update) {
      echo "<script>alert('Password berhasil direset!'); window.location='login_perusahaan.php';</script>";
    } else {
      echo "<script>alert('Gagal reset password!');</script>";
    }
  }
}
?>


<form method="POST">

  <div class="form-group">
    <input type="password" name="password_baru" class="form-control" placeholder="Password Baru" required>
  </div>

  <div class="form-group">
    <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password" required>
  </div>

  <button type="submit" name="btnReset" class="btn btn-primary">Reset Password</button>

</form>
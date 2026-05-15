<?php
ob_start();
session_start();

$login_berhasil = false;

if (isset($_SESSION['ses_username'])) {
  $_SESSION = [];
  session_destroy();
  session_start();
}

// kalau ada login berhasil:
if ($login_berhasil) {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | Admin SI BKK</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="adminbkk/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="adminbkk/bower_components/font-awesome/css/font-awesome.min.css">

  <style>
    * {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      /* Background Image - Gunakan gambar yang sama atau berbeda untuk admin */
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.28) 0%, rgba(118, 75, 162, 0.1) 100%),
        url('adminbkk/dist/img/bg-admin.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 20px;
    }


    .login-box {
      background: rgba(255, 255, 255, 0.98);
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      padding: 50px 40px;
      max-width: 700px;
      width: 100%;
      animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-logo {
      text-align: center;
      margin-bottom: 35px;
    }

    .login-logo h1 {
      margin: 0 0 10px 0;
      font-size: 32px;
      font-weight: 800;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1.2;
    }

    .login-logo h4 {
      margin: 0;
      font-size: 16px;
      color: #64748b;
      font-weight: 600;
    }

    .login-box-msg {
      text-align: center;
      color: #475569;
      font-size: 15px;
      margin-bottom: 30px;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 16px 14px 45px;
      font-size: 14px;
      transition: all 0.3s ease;
      height: 50px;
      background: #f8fafc;
    }

    .form-control:focus {
      border-color: #667eea;
      background: white;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
      outline: none;
    }

    .form-control::placeholder {
      color: #94a3b8;
    }

    .form-control-feedback {
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 18px;
    }

    .form-control:focus+.form-control-feedback {
      color: #667eea;
    }

    .checkbox {
      margin: 20px 0;
    }

    .checkbox label {
      color: #64748b;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .checkbox input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: #667eea;
    }

    .btn {
      border-radius: 12px;
      padding: 14px 24px;
      font-size: 15px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      height: 50px;
    }

    .btn-warning {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    }

    .btn-warning:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
      color: white;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      color: white;
    }

    .text-center {
      text-align: center;
    }

    .text-center a {
      color: #667eea;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .text-center a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    .footer-text {
      text-align: center;
      margin-top: 30px;
      color: #94a3b8;
      font-size: 13px;
    }

    .footer-text a {
      color: #667eea;
      font-weight: 600;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .login-box {
        padding: 40px 25px;
      }

      .login-logo h1 {
        font-size: 26px;
      }

      .login-logo h4 {
        font-size: 14px;
      }

      .btn {
        padding: 12px 20px;
        font-size: 14px;
      }
    }

    /* Input animation */
    .form-group {
      animation: fadeIn 0.5s ease backwards;
    }

    .form-group:nth-child(1) {
      animation-delay: 0.1s;
    }

    .form-group:nth-child(2) {
      animation-delay: 0.2s;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(-10px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
  </style>
</head>

<body>
  <div class="login-box">
    <div class="login-logo">
      <h1>🔐 SI BKK - ADMIN</h1>
      <h4>SMK Negeri 7 Surabaya</h4>
    </div>

    <div class="login-box-body">
      <p class="login-box-msg">Login Admin untuk memulai</p>

      <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Username Admin" name="txtnis" required autofocus autocomplete="off">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" name="txtpassword" required autocomplete="new-password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="checkbox">
          <label>
            <input type="checkbox"> Remember Me
          </label>
        </div>

        <div class="row">
          <div class="col-xs-4">
            <button type="button" onclick="window.location='index.php'" class="btn btn-warning btn-block">
              <i class="fa fa-arrow-left"></i> Kembali
            </button>
          </div>
          <div class="col-xs-8">
            <button type="submit" class="btn btn-primary btn-block" name="btnLogin">
              <i class="fa fa-sign-in"></i> Sign In
            </button>
          </div>
        </div>
      </form>

      <div class="text-center" style="margin-top: 20px;">
        <a href="lupa_password_admin.php">Lupa Password?</a>
      </div>

      <div class="footer-text">
        <p>Repost by <a href="#" target="_blank">SMKN 7 Surabaya</a></p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="adminbkk/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="adminbkk/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <script>
    // Input focus effects
    $(document).ready(function() {
      $('.form-control').focus(function() {
        $(this).parent().addClass('focused');
      }).blur(function() {
        $(this).parent().removeClass('focused');
      });
    });
  </script>
</body>

</html>

<?php
include_once("koneksi.php");

if (isset($_POST['btnLogin'])) {

  $username = mysqli_real_escape_string($con, $_POST['txtnis']);
  $password = $_POST['txtpassword'];

  // ambil user berdasarkan username + role admin
  $sql_login = mysqli_query($con, "
  SELECT * FROM tb_user 
  WHERE username='$username' AND role='admin'
  ");

  $data_login = mysqli_fetch_array($sql_login);

  if ($data_login) {

    // verifikasi password hash
    if (password_verify($password, $data_login['password'])) {

      $_SESSION["ses_username"] = $data_login["username"];
      $_SESSION["ses_nama"] = $data_login["nama"];
      $_SESSION["ses_level"] = $data_login["role"];
      setcookie("last_role", "admin", time() + 3600, "/");

      echo "<script>alert('Login Berhasil')</script>";
      echo "<meta http-equiv='refresh' content='0; url=adminbkk/index.php'>";
    } else {

      echo "<script>alert('Password salah!')</script>";
      echo "<meta http-equiv='refresh' content='0; url=login_admin.php'>";
    }
  } else {

    echo "<script>alert('Username tidak ditemukan!')</script>";
    echo "<meta http-equiv='refresh' content='0; url=login_admin.php'>";
  }
}
?>
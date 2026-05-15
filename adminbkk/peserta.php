<?php
session_start();

if (isset($_SESSION['ses_username'])) {

    $_SESSION = array();
    session_destroy();

    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | Alumni SMK Negeri 7 Surabaya</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  
  <style>
    * {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    body {
      /* Background Image */
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.28) 0%, rgba(118, 75, 162, 0.1) 100%),
                  url('dist/img/bg-admin.png');
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
    
    .form-control:focus + .form-control-feedback {
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
    
    /* =========================================
   PERFECT RESPONSIVE LOGIN MOBILE
========================================= */
@media (max-width: 768px){

    body{
        padding: 15px;
        align-items: center;
        justify-content: center;
        background-position: center;
        overflow-x: hidden;
    }

    .login-box{
        width: 100%;
        max-width: 100%;
        padding: 35px 22px;
        border-radius: 28px;
        margin: 0;
    }

    .login-logo{
        margin-bottom: 28px;
    }

    .login-logo h1{
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .login-logo h4{
        font-size: 15px;
        line-height: 1.5;
    }

    .login-box-msg{
        font-size: 15px;
        margin-bottom: 25px;
    }

    .form-group{
        margin-bottom: 20px;
    }

    .form-control{
        height: 56px;
        border-radius: 16px;
        font-size: 15px;
        padding-left: 48px;
    }

    .form-control-feedback{
        font-size: 18px;
        left: 16px;
    }

    .checkbox{
        margin: 18px 0;
    }

    .checkbox label{
        font-size: 15px;
    }

    .row{
        display: flex;
        gap: 12px;
        margin: 0;
    }

    .col-xs-4,
    .col-xs-8{
        padding: 0 !important;
    }

    .col-xs-4{
        width: 30%;
    }

    .col-xs-8{
        width: 70%;
    }

    .btn{
        width: 100%;
        height: 56px;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 700;
        padding: 0 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn i{
        margin-right: 6px;
    }

    .text-center{
        margin-top: 22px !important;
    }

    .text-center a{
        font-size: 14px;
    }

    .footer-text{
        margin-top: 28px;
        font-size: 13px;
        line-height: 1.6;
    }

}

/* EXTRA SMALL DEVICE */
@media (max-width: 400px){

    .login-box{
        padding: 30px 18px;
    }

    .login-logo h1{
        font-size: 1.7rem;
    }

    .btn{
        font-size: 14px;
    }

    .form-control{
        font-size: 14px;
    }

}
    
    /* Input animation */
    .form-group {
      animation: fadeIn 0.5s ease backwards;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    
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
      <h1>🎓 SI BKK - ALUMNI</h1>
      <h4>SMK Negeri 7 Surabaya</h4>
    </div>
    
    <div class="login-box-body">
      <p class="login-box-msg">Login untuk memulai</p>

      <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Username / NISN" name="txtnisn" required autofocus autocomplete="off">
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
            <button type="button" onclick="window.location='../index.php'" class="btn btn-warning btn-block">
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
        <a href="lupa_password_peserta.php">Lupa Password?</a>
      </div>
      
      <div class="footer-text">
        <p>Repost by <a href="#" target="_blank">SMKN 7 Surabaya</a></p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  
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

// ================= PROSES LOGIN =================
if (isset($_POST['btnLogin'])) {

  $nisn = mysqli_real_escape_string($con, $_POST['txtnisn']);
  $password = mysqli_real_escape_string($con, $_POST['txtpassword']);

  // Ambil siswa berdasarkan nisn
  $sql_siswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE nisn='$nisn'");
  $data_siswa = mysqli_fetch_assoc($sql_siswa);

  if ($data_siswa) {

      // Ambil user berdasarkan id_user
      $id_user = $data_siswa['id_user'];

      $sql_login = mysqli_query($con, "SELECT * FROM tb_user WHERE id_user='$id_user' AND role='siswa'");
      $data_login = mysqli_fetch_assoc($sql_login);

      if ($data_login) {

          // Verifikasi password
          if (password_verify($password, $data_login['password'])) {

              // ✅ SIMPAN SEMUA SESSION YANG DIPERLUKAN
              $_SESSION["ses_username"] = $data_login['username']; // Atau bisa pakai $data_siswa['nisn']
              $_SESSION["ses_nisn"]     = $data_siswa["nisn"];
              $_SESSION["ses_nama"]     = $data_siswa["nama"];
              $_SESSION["ses_level"]    = $data_login["role"];
              
              // ✅ BARIS PENTING INI: Simpan ID Siswa ke Session
              $_SESSION["ses_id_siswa"] = $data_siswa["id_siswa"]; 

              // Cek apakah data siswa ada
              $cek = mysqli_query($con,"SELECT id_siswa FROM tb_siswa WHERE nisn='$nisn'");

              if (mysqli_num_rows($cek) == 0) {

                  echo "<script>
                  alert('Silakan lengkapi data profil terlebih dahulu');
                  window.location='peserta/isi_data_awal.php';
                  </script>";

              } else {

                  echo "<script>
                  alert('Login berhasil');
                  window.location='peserta/index_pst.php';
                  </script>";

              }

          } else {

              echo "<script>
              alert('Password salah!');
              window.location='peserta.php';
              </script>";

          }

      } else {

          echo "<script>
          alert('Akun user tidak ditemukan!');
          window.location='peserta.php';
          </script>";

      }

  } else {

      echo "<script>
      alert('NISN tidak ditemukan!');
      window.location='peserta.php';
      </script>";

  }
}
?>
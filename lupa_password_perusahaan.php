<?php
include_once("koneksi.php");

if (isset($_POST['reset'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi'];

    // cek akun perusahaan
    $cek = mysqli_query($con, "SELECT * FROM tb_user 
  WHERE username='$username' AND role='perusahaan'");

    $data = mysqli_fetch_array($cek);

    if (!$data) {

        echo "<script>alert('Username tidak ditemukan!');</script>";

    } else {

        // cek konfirmasi password
        if ($password_baru != $konfirmasi) {

            echo "<script>alert('Konfirmasi password tidak cocok!');</script>";

        } else {

            // validasi panjang password
            if (strlen($password_baru) < 6) {

                echo "<script>alert('Password minimal 6 karakter!');</script>";

            } else {

                // hash password
                $hash = password_hash($password_baru, PASSWORD_DEFAULT);

                // update password
                $update = mysqli_query($con, "UPDATE tb_user 
        SET password='$hash' 
        WHERE username='$username' AND role='perusahaan'");

                if ($update) {

                    echo "<script>
          alert('Password berhasil diubah!');
          window.location='login_perusahaan.php';
          </script>";

                } else {

                    echo "<script>alert('Gagal mengubah password!');</script>";

                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lupa Password | Perusahaan - SI BKK</title>
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
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.28) 0%, rgba(118, 75, 162, 0.1) 100%),
                        url('adminbkk/dist/img/bg_login-perusahaan.jpg');
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
            max-width: 550px;
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
            
            .row .col-xs-6 {
                margin-bottom: 10px;
            }
        }
        
        /* Input animation */
        .form-group {
            animation: fadeIn 0.5s ease backwards;
        }
        
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        
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
            <h1>🏢 SI BKK - PERUSAHAAN</h1>
            <h4>SMK Negeri 7 Surabaya</h4>
        </div>
        
        <div class="login-box-body">
            <p class="login-box-msg">Lupa Password Perusahaan</p>

            <form method="POST" autocomplete="off">

                <!-- anti autofill -->
                <input type="text" style="display:none">
                <input type="password" style="display:none">

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Masukkan Username" name="username"
                        autocomplete="off" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password Baru" name="password_baru"
                        autocomplete="new-password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Konfirmasi Password" name="konfirmasi"
                        autocomplete="new-password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" onclick="window.location='login_perusahaan.php'" class="btn btn-warning btn-block">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </button>
                    </div>

                    <div class="col-xs-6">
                        <button type="submit" name="reset" class="btn btn-primary btn-block">
                            <i class="fa fa-refresh"></i> Reset Password
                        </button>
                    </div>
                </div>

            </form>

            <div class="footer-text">
                <p>Repost by <a>SMKN 7 Surabaya</a></p>
            </div>

        </div>
    </div>

    <!-- jQuery -->
    <script src="adminbkk/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
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
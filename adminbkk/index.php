<?php
// ============================================================================
// FILE: index.php - 
// ============================================================================

// 1. Start session first
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include_once("koneksi.php");

// 3. Validasi session login
if (!isset($_SESSION['ses_username']) || empty($_SESSION['ses_username'])) {

  $referer = $_SERVER['HTTP_REFERER'] ?? '';

  // jika sebelumnya dari login perusahaan
  if (strpos($referer, 'login_perusahaan.php') !== false) {

    header("Location: ../login_perusahaan.php");

  }
  // jika sebelumnya dari login admin
  elseif (strpos($referer, 'login_admin.php') !== false) {

    header("Location: ../login_admin.php");

  }
  // jika sebelumnya dari login peserta
  elseif (strpos($referer, 'peserta.php') !== false) {

    header("Location: peserta.php");

  }
  // default
  else {

    header("Location: ../beranda.php");
  }

  exit;
}

// 4. Ambil data session dengan sanitasi
$data_username = mysqli_real_escape_string($con, $_SESSION['ses_username']);
$data_nama = isset($_SESSION['ses_nama']) ? htmlspecialchars($_SESSION['ses_nama']) : htmlspecialchars($_SESSION['ses_username']);
$data_status = $_SESSION['ses_level'] ?? '';
$data_id = '';

// 5. Ambil id_perusahaan untuk user perusahaan (dengan sanitasi)
if ($data_status === "perusahaan") {
  $data_id = $_SESSION['ses_id_perusahaan'] ?? '';

  if (empty($data_id) && isset($_SESSION['id_user'])) {
    $id_user_safe = mysqli_real_escape_string($con, $_SESSION['id_user']);
    $q = mysqli_query($con, "SELECT id_perusahaan FROM tb_perusahaan WHERE id_user='$id_user_safe' LIMIT 1");

    if ($q && mysqli_num_rows($q) > 0) {
      $r = mysqli_fetch_assoc($q);
      $data_id = $r['id_perusahaan'];
      $_SESSION['ses_id_perusahaan'] = $data_id; // Cache ke session
    }
  }
}

// 6. Ambil foto/logo user dari database
$foto_user = "dist/img/pegawai.png"; // Default

$query_foto = mysqli_query($con, "
    SELECT p.logo 
    FROM tb_perusahaan p
    INNER JOIN tb_user u ON p.id_user = u.id_user
    WHERE u.username='$data_username'
    LIMIT 1
");

if ($query_foto && mysqli_num_rows($query_foto) > 0) {
  $data_foto = mysqli_fetch_assoc($query_foto);

  if (!empty($data_foto['logo'])) {
    $logo_safe = htmlspecialchars($data_foto['logo']);
    if ($data_status === "perusahaan") {
      $foto_user = "dist/img/foto_perusahaan/" . $logo_safe;
    } else {
      $foto_user = "dist/img/foto_user/default.png";
    }
  }
}

// 7. Hitung notifikasi untuk admin (opsional, untuk badge)
$notif_count = 0;
if ($data_status === "admin") {
  $q_notif = mysqli_query($con, "SELECT COUNT(*) as total FROM tb_lowongan WHERE status='Tangguhkan'");
  if ($q_notif) {
    $notif_count = (int) mysqli_fetch_assoc($q_notif)['total'];
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Portal BKK | SMKN 7 SURABAYA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
    .main-sidebar {
      position: fixed !important;
      height: 100vh;
      overflow-y: auto;
    }

    .content-wrapper {
      margin-left: 230px;
    }

    /* NAVBAR HIJAU STAY */
    .main-header {
      position: fixed !important;
      top: 0;
      width: 100%;
      z-index: 1000;
    }
  </style>
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="bower_components/chart.js/Chart.js">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>BKK</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>🎓Portal </b>BKK</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>




                <span class="label label-warning"><?php
                if ($data_status == "admin") {
                  $sql_hitung = "SELECT COUNT(id_lowongan) from tb_lowongan where status ='Tangguhkan'";
                  $q_hit = mysqli_query($con, $sql_hitung);
                  while ($row = mysqli_fetch_array($q_hit)) {
                    echo $row[0] . "";
                  }
                }
                ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <?php if ($data_status == "admin") {
                      $periksa = mysqli_query($con, "SELECT id_lowongan FROM tb_lowongan WHERE status='Tangguhkan' ORDER BY id_lowongan DESC LIMIT 1 ");
                      while ($q = mysqli_fetch_array($periksa)) {
                        if ($q['id_lowongan'] <= 5) {
                          echo "<div style='padding:5px' class='alert alert-info'><span class='glyphicon glyphicon-info-sign'></span> Lowongan  <a style='color:blue'>" . $q['id_lowongan'] . "</a> Masuk . Silahkan Cek Untuk Detail Loker !!</div>";
                        }
                      }
                    }
                    ?>
                    <li>
                      <?php if ($data_status == "admin") {
                        $periksa = mysqli_query($con, "SELECT id_lowongan FROM tb_lowongan WHERE status='Tangguhkan' ORDER BY id_lowongan DESC LIMIT 1 ");
                        while ($q = mysqli_fetch_array($periksa)) {
                          if ($q['id_lowongan'] <= 5) {
                            echo "<div style='padding:5px' class='alert alert-info'><span class='glyphicon glyphicon-info-sign'></span> Lowongan  <a style='color:blue'>" . $q['id_lowongan'] . "</a> Masuk . Silahkan Cek Untuk Detail Loker !!</div>";
                          }
                        }
                      }
                      ?>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> Silahkan Cek Untuk Detail Loker
                      </a>
                    </li>
                    <!-- <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li> -->
                  </ul>
                </li>
                <li class="footer"><a href="?halaman=loker_tampil">View all</a></li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs" style="font-weight: 600;">
                  <?php
                  if ($_SESSION['ses_level'] == "admin") {
                    echo "Admin BKK";
                  } else if ($_SESSION['ses_level'] == "perusahaan") {
                    echo htmlspecialchars($_SESSION['ses_nama_perusahaan']);
                  } else {
                    echo "User";
                  }
                  ?>
                </span>
              </a>
            </li>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li>
                <div class="text-center">
                  <a href="#"> <?php echo $data_nama ?> - <?php echo $data_status ?></a>
                </div>

              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?halaman=profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <!-- <a class="nav-link" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li> -->
                  <?php if ($data_status == "admin" || $data_status == "Ka. BKK" || $data_status == "Waka Humas"): ?>
                    <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#exampleModalAdmin">Sign
                      out</a>
                  <?php elseif ($data_status == "perusahaan"): ?>
                    <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#exampleModalPerusahaan">Sign
                      out</a>
                  <?php else: ?>
                    <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#exampleModalAdmin">Sign
                      out</a>
                  <?php endif; ?>

                </div>
              </li>
            </ul>
            <!-- Control Sidebar Toggle Button -->
            <!-- <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li> -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo $foto_user; ?>" class="img-circle" alt="User Image"
              style="width:45px; height:45px; object-fit:cover;">
          </div>
          <div class="pull-left info">
            <p><?php echo $data_nama ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Menu System</li>
          <li class="active treeview">
          <li>
            <a href="?halaman=beranda">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>


          <?php
          if ($data_status == "Ka. BKK") {
            ?>
            <li>
              <a href="?halaman=sekolah_tampil">
                <i class="fa fa-building"></i> <span>Kelola Data Sekolah</span>
              </a>
            </li>
            <li>
              <a href="?halaman=siswa_tampil">
                <i class="fa fa-users"></i> <span>Kelola Data Peserta</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Kelola Lowongan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="?halaman=loker_tampil"><i class="fa fa-briefcase"></i> Lowongan Kerja</a></li>
                <li><a href="?halaman=pendaftar_tampil"><i class="fa fa-user"></i> Pendaftar</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-info-circle"></i>
                <span>Kelola Informasi</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">

                <li><a href="?halaman=hasil_tampil"><i class="fa fa-bullhorn"></i> Pengumuman Hasil</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Kelola User</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="?halaman=super_tampil"><i class="fa fa-user-secret"></i> Super User</a></li>
                <li><a href="?halaman=user_tampil"><i class="fa fa-user-secret"></i> User Peserta</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>laporan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="?halaman=laporan_per"><i class="fa fa-circle-o"></i> Data Perusahaan</a></li>
                <li><a href="?halaman=laporan_loker"><i class="fa fa-circle-o"></i> Data Loker</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Data Alumni
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="?halaman=laporan_alumnib"><i class="fa fa-circle-o"></i> Alumni Bekerja</a></li>
                    <li><a href="?halaman=laporan_alumnis"><i class="fa fa-circle-o"></i> Alumni Studi</a></li>
                  </ul>
                <li><a href="?halaman=laporan_pendaftar"><i class="fa fa-circle-o"></i> Data Pendaftar</a></li>
            </li>
          </ul>
          </li>
          <li class="header">Menu Lain</li>
          <li>
            <a class="nav-link" data-toggle="modal" data-target="#exampleModalAdmin"><i class="fa fa-sign-out"></i>
              <span>Logout</span></a>
          </li>
          <!-- <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->



          <?php
          } elseif ($data_status == "perusahaan") {
            ?>

          <!-- Modern CSS Styles (Sama seperti versi siswa) -->
          <style>
            /* ========================================
                   1. GLOBAL & RESET
                   ======================================== */
            * {
              font-family: 'Plus Jakarta Sans', sans-serif;
              box-sizing: border-box;
            }

            body {
              background: #f8fafc;
              overflow-x: hidden;
            }

            /* ========================================
                   2. HEADER & NAVBAR
                   ======================================== */
            .main-header {
              background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
              box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
              height: 70px !important;
              position: fixed !important;
              width: 100%;
              z-index: 1001;
              border: none !important;
            }

            .logo {
              background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
              color: #fff !important;
              font-weight: 800 !important;
              font-size: 22px !important;
              border: none !important;
              width: 280px !important;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
              display: flex;
              align-items: center;
              justify-content: center;
            }

            .logo:hover {
              background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
              transform: translateY(-2px);
              box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            }

            .logo-lg {
              letter-spacing: 0.5px;
            }

            .logo-mini {
              font-size: 18px !important;
            }

            .navbar {
              margin-left: 280px !important;
              background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
              backdrop-filter: blur(10px);
              box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
              border: none !important;
              height: 70px !important;
              transition: all 0.3s ease;
            }

            .navbar-custom-menu .nav>li>a {
              color: #f8fafc !important;
              font-weight: 600;
              padding: 25px 20px !important;
              transition: all 0.3s ease;
              display: flex;
              align-items: center;
            }

            .navbar-custom-menu .nav>li>a:hover {
              background: rgba(59, 130, 246, 0.1) !important;
              color: #fff !important;
              transform: translateY(-2px);
            }

            /* Dropdown Menus */
            .navbar-nav>.notifications-menu>.dropdown-menu,
            .navbar-nav>.tasks-menu>.dropdown-menu,
            .navbar-nav>.user-menu>.dropdown-menu {
              top: 70px !important;
              right: 0 !important;
              left: auto !important;
              border-radius: 16px !important;
              border: none !important;
              box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
              padding: 0 !important;
              overflow: hidden;
              min-width: 280px !important;
              animation: slideDown 0.3s ease;
            }

            @keyframes slideDown {
              from {
                opacity: 0;
                transform: translateY(-10px);
              }

              to {
                opacity: 1;
                transform: translateY(0);
              }
            }

            .navbar-nav>.user-menu>.dropdown-menu>li>a {
              padding: 14px 20px !important;
              color: #475569 !important;
              font-weight: 500 !important;
              transition: all 0.3s ease !important;
              border-bottom: 1px solid #f1f5f9;
              display: flex;
              align-items: center;
              gap: 10px;
            }

            .navbar-nav>.user-menu>.dropdown-menu>li>a:hover {
              background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
              color: #fff !important;
              padding-left: 25px !important;
            }

            .navbar-nav>.user-menu>.dropdown-menu>li:last-child>a {
              border-bottom: none !important;
              color: #ef4444 !important;
              font-weight: 600 !important;
            }

            .navbar-nav>.user-menu>.dropdown-menu>li:last-child>a:hover {
              background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
              color: #fff !important;
            }

            /* ========================================
                   3. SIDEBAR & USER PANEL
                   ======================================== */
            .main-sidebar {
              background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
              box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
              width: 280px !important;
              position: fixed !important;
              height: 100vh !important;
              overflow-y: auto;
              overflow-x: hidden;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
              z-index: 1000;
            }

            /* Custom Scrollbar Sidebar */
            .main-sidebar::-webkit-scrollbar {
              width: 6px;
            }

            .main-sidebar::-webkit-scrollbar-track {
              background: rgba(255, 255, 255, 0.05);
            }

            .main-sidebar::-webkit-scrollbar-thumb {
              background: rgba(255, 255, 255, 0.2);
              border-radius: 10px;
            }

            /* User Panel Container */
            .main-sidebar .user-panel {
              padding: 20px 8px !important;
              margin: 20px 0 !important;
              background: rgba(255, 255, 255, 0.03);
              border-radius: 22px;
              border: 1px solid rgba(255, 255, 255, 0.05);
              display: flex;
              align-items: center;
              gap: 20px;
              /* Jarak otomatis antara foto & teks */
            }

            .main-sidebar .user-panel>.pull-left.image {
              flex-shrink: 0;
              margin-right: 0 !important;
            }

            /* ✅ FOTO PROFIL - ANTI REVERT & ANTI JS OVERRIDE */
            .main-sidebar .user-panel .img-circle {
              width: 60px !important;
              height: 60px !important;
              min-width: 60px !important;
              max-width: 60px !important;
              border: 3px solid rgba(59, 130, 246, 0.5) !important;
              box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
              object-fit: cover !important;
              border-radius: 50% !important;
              display: block !important;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .main-sidebar .user-panel .img-circle:hover {
              transform: scale(1.05);
              border-color: #3b82f6 !important;
              box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
            }

            /* Info Text */
            .main-sidebar .user-panel .info {
              padding: 0 !important;
              flex: 1;
              display: flex;
              flex-direction: column;
              justify-content: center;
              gap: 6px;
            }

            .main-sidebar .user-panel .info p {
              font-weight: 700 !important;
              color: #f1f5f9 !important;
              font-size: 15px !important;
              margin: 0 !important;
              letter-spacing: 0.3px;
              line-height: 1.3;
              white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
              padding-left: 45px;
              /* jarak nama perusahaan ke foto */
            }

            .main-sidebar .user-panel .info a {
              color: #94a3b8 !important;
              font-weight: 500 !important;
              font-size: 12px !important;
              display: flex;
              align-items: center;
              gap: 6px;
              text-decoration: none;
              margin-top: 0 !important;
              padding-left: 45px
                /* jarak online ke foto */
            }

            .main-sidebar .user-panel .info a .fa-circle {
              font-size: 8px !important;
              color: #10b981 !important;
              animation: pulse 2s infinite;
            }

            @keyframes pulse {

              0%,
              100% {
                opacity: 1;
              }

              50% {
                opacity: 0.5;
              }
            }

            /* ========================================
                   4. SIDEBAR MENU & TREEVIEW
                   ======================================== */
            .sidebar-menu>li.header {
              color: #c7d4e7 !important;
              font-size: 11px !important;
              font-weight: 700 !important;
              text-transform: uppercase !important;
              letter-spacing: 1.5px !important;
              padding: 20px 25px 12px !important;
              margin-top: 2px;
              position: relative;
            }

            .sidebar-menu>li.header::before {
              content: '';
              position: absolute;
              left: 25px;
              bottom: 8px;
              width: 30px;
              height: 2px;
              background: linear-gradient(90deg, #75aaff, transparent);
              border-radius: 2px;
            }

            .sidebar-menu>li>a {
              color: #e2e8f0 !important;
              font-weight: 500 !important;
              font-size: 14px !important;
              padding: 14px 25px !important;
              border-radius: 12px !important;
              margin: 4px 15px !important;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
              border: none !important;
              display: flex;
              align-items: center;
              gap: 12px;
            }

            .sidebar-menu>li>a:hover {
              background: rgba(59, 130, 246, 0.15) !important;
              color: #fff !important;
              transform: translateX(5px);
              box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            }

            .sidebar-menu>li.active>a {
              background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
              color: #fff !important;
              box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
              font-weight: 600 !important;
            }

            .sidebar-menu li>a>.fa,
            .sidebar-menu li>a>.ion,
            .sidebar-menu li>a>.glyphicon {
              width: 24px !important;
              height: 24px !important;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 16px !important;
              transition: transform 0.3s ease;
            }

            .sidebar-menu>li.active>a>.fa,
            .sidebar-menu>li.active>a>.ion {
              transform: scale(1.1);
            }

            /* Treeview */
            .treeview-menu {
              background: rgba(0, 0, 0, 0.1) !important;
              border-radius: 8px;
              margin: 2px 25px !important;
              padding: 8px 0 !important;
            }

            .treeview-menu>li>a {
              color: #94a3b8 !important;
              font-weight: 500 !important;
              font-size: 13px !important;
              padding: 10px 20px 10px 55px !important;
              transition: all 0.3s ease !important;
              border-radius: 8px !important;
              margin: 2px 10px !important;
            }

            .treeview-menu>li>a:hover {
              background: rgba(59, 130, 246, 0.1) !important;
              color: #fff !important;
              padding-left: 60px !important;
            }

            .treeview-menu>li.active>a {
              color: #3b82f6 !important;
              background: rgba(59, 130, 246, 0.15) !important;
              font-weight: 600 !important;
            }

            .pull-right-container>.fa-angle-left {
              transition: transform 0.3s ease !important;
              opacity: 0.7;
            }

            .treeview-menu-open>.pull-right-container>.fa-angle-left {
              transform: rotate(90deg) !important;
            }

            /* ========================================
                   5. CONTENT WRAPPER
                   ======================================== */
            .content-header {
              background: linear-gradient(135deg, #f9f8fc 0%, #e2e8f0 100%) !important;
              padding: 10px !important;
              margin: 0 !important;
              border-bottom: none !important;
            }

            .content-wrapper {
              margin-left: 280px !important;
              margin-top: 70px !important;
              min-height: calc(100vh - 70px);
              background: linear-gradient(135deg, #f9f8fc 0%, #e2e8f0 100%);
              padding: 30px;
              transition: all 0.3s ease;
            }

            /* ========================================
                   6. RESPONSIVE DESIGN
                   ======================================== */
            @media (max-width: 767px) {

  html,
  body {
    overflow-x: hidden !important;
    width: 100% !important;
  }

  .wrapper {
    overflow-x: hidden !important;
  }

  /* HEADER */
  .main-header {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100px !important;
    z-index: 99999 !important;
  }

  /* LOGO */
  .main-header .logo {
    width: 100% !important;
    height: 50px !important;
    position: absolute !important;
    top: 0;
    left: 0;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
  }

  .logo-lg {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 18px !important;
    color: #fff !important;
  }

  .logo-mini {
    display: none !important;
  }

  /* NAVBAR */
  .main-header .navbar {
    position: absolute !important;
    top: 50px !important;
    left: 0 !important;
    width: 100% !important;
    height: 50px !important;
    margin-left: 0 !important;
  }

  /* TOGGLE */
  .sidebar-toggle {
    position: absolute !important;
    left: 10px !important;
    top: -6px !important;
    color: #fff !important;
    font-size: 24px !important;
    z-index: 99999 !important;
  }

  /* MENU KANAN */
  .navbar-custom-menu {
    position: absolute !important;
    right: 10px !important;
    top: 0 !important;
  }

  .navbar-custom-menu .nav {
    display: flex !important;
    align-items: center !important;
  }

  .navbar-custom-menu .nav>li>a {
    padding: 12px 10px !important;
  }

  .hidden-xs {
    display: none !important;
  }

  /* SIDEBAR */
  .main-sidebar {
    transform: translateX(-100%);
    width: 280px !important;
  }

  .sidebar-open .main-sidebar {
    transform: translateX(0) !important;
  }

  /* USER PANEL */
  .main-sidebar .user-panel {
    display: flex !important;
    align-items: center !important;
    padding: 15px !important;
    gap: 15px !important;
  }

  .main-sidebar .user-panel .img-circle {
    width: 55px !important;
    height: 55px !important;
  }

  .main-sidebar .user-panel .info {
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    height: 55px !important;
    padding-left: 50px !important;
  }

  .main-sidebar .user-panel .info p {
    font-size: 14px !important;
    margin: 0 !important;
    padding-left: 0 !important;
    line-height: 1.3 !important;
  }

  .main-sidebar .user-panel .info a {
    font-size: 12px !important;
    margin-top: 4px !important;
    padding-left: 0 !important;
  }

  /* CONTENT */
  .content-wrapper {
    margin-left: 0 !important;
    margin-top: 100px !important;
    padding: 15px !important;
    min-height: calc(100vh - 100px) !important;
  }

  /* CARD */
  .row {
    display: flex !important;
    flex-direction: column !important;
  }

  .col-lg-3,
  .col-md-3,
  .col-sm-6,
  .col-xs-12 {
    width: 100% !important;
    margin-bottom: 15px !important;
    padding: 0 !important;
  }

  .box,
  .small-box,
  .info-box {
    width: 100% !important;
    border-radius: 18px !important;
  }

  /* TABLE */
  .table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
  }

  table {
    width: 100% !important;
  }

  /* BUTTON */
  .btn {
    min-height: 44px !important;
    font-size: 14px !important;
  }

  /* FORM */
  .form-control {
    min-height: 44px !important;
    font-size: 16px !important;
  }

  /* DROPDOWN */
  .dropdown-menu {
    right: 0 !important;
    left: auto !important;
    min-width: 250px !important;
  }
}

            /* ========================================
                   7. UTILITIES & SCROLLBAR
                   ======================================== */
            ::-webkit-scrollbar {
              width: 8px;
            }

            ::-webkit-scrollbar-track {
              background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
              background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
              border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
              background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
            }
          </style>

          <!-- Font Modern -->
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">

          <!-- Struktur HTML dengan Tampilan Modern -->
          <header class="main-header">
            <a href="index_perusahaan.php" class="logo">
              <span class="logo-mini"><b>BKK</b></span>
              <span class="logo-lg">🎓 Portal BKK SMKN 7</span>
            </a>

            <nav class="navbar navbar-static-top">
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"
                style="color: #ffffff; font-size: 20px;">
                <span class="sr-only">Toggle navigation</span>
              </a>

              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Notifikasi -->
                  <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o" style="font-size: 20px;"></i>
                      <span class="label label-warning">0</span>
                    </a>
                  </li>

                  <!-- User Menu Perusahaan -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="../dist/img/pegawai.png" class="user-image"
                        style="width:40px;height:40px;margin:-10px 0 -10px 0;border-radius:50%;object-fit:cover;margin-right:15px;"
                        alt="User Image">
                      <span class="hidden-xs"
                        style="font-weight: 600;"><?php echo isset($_SESSION['ses_nama_perusahaan']) ? $_SESSION['ses_nama_perusahaan'] : 'Perusahaan'; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li
                        style="text-align:center;padding:25px 20px;background:linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <img src="../dist/img/pegawai.png"
                          style="width:70px;height:70px;border-radius:50%;margin-bottom:12px;object-fit:cover;border:3px solid rgba(255,255,255,0.3);">
                        <h4 style="color:white;margin:10px 0 5px 0;font-weight:700;">
                          <?php
                          $nama_perusahaan_header = !empty($_SESSION['ses_nama_perusahaan']) ? $_SESSION['ses_nama_perusahaan'] : 'Perusahaan';
                          echo htmlspecialchars($nama_perusahaan_header);
                          ?>
                        </h4>
                        <p style="color:rgba(255,255,255,0.9);margin:0;font-size:13px;">Akun Perusahaan</p>
                      </li>
                      <li><a href="?halaman=profile#perusahaan"><i class="fa fa-user" style="margin-right:10px;"></i>
                          Profil Perusahaan</a></li>
                      <li><a href="?halaman=loker_tampil"><i class="fa fa-briefcase" style="margin-right:10px;"></i>
                          Lowongan Aktif</a></li>
                      <li><a href="?halaman=pendaftar_tampil"><i class="fa fa-users" style="margin-right:10px;"></i> Data
                          Pendaftar</a></li>
                      <li style="border-top:2px solid #f1f5f9;">
                        <a data-toggle="modal" data-target="#exampleModal"><i class="fa fa-sign-out"
                            style="margin-right:10px;"></i> Keluar</a>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears" style="font-size: 20px;"></i></a>
                  </li>
                </ul>
              </div>
            </nav>
          </header>

          <aside class="main-sidebar">
            <section class="sidebar">

              <!-- User Panel Perusahaan -->
              <div class="user-panel">
                <div class="image">
                  <img src="<?php
                  // ✅ Ambil logo dari session atau database
                  $logo_perusahaan = 'dist/img/pegawai.png'; // Default
                
                  if (!empty($_SESSION['ses_logo'])) {
                    $logo_perusahaan = 'dist/img/foto_perusahaan/' . $_SESSION['ses_logo'];
                  } else {
                    // Fallback: query database jika session kosong
                    $q_logo = mysqli_query($con, "SELECT p.logo FROM tb_perusahaan p JOIN tb_user u ON p.id_user = u.id_user WHERE u.username='" . mysqli_real_escape_string($con, $data_username) . "'");
                    if ($q_logo && mysqli_num_rows($q_logo) > 0) {
                      $d_logo = mysqli_fetch_assoc($q_logo);
                      if (!empty($d_logo['logo'])) {
                        $logo_perusahaan = 'dist/img/foto_perusahaan/' . $d_logo['logo'];
                        // Update session untuk next load
                        $_SESSION['ses_logo'] = $d_logo['logo'];
                      }
                    }
                  }
                  echo $logo_perusahaan;
                  ?>" class="img-circle" alt="Logo Perusahaan"
                    style="width: 60px !important; height: 60px !important; object-fit: cover !important; border: 3px solid rgba(59, 130, 246, 0.5);">
                </div>
                <div class="info">
                  <p>
                    <?php
                    // ✅ FIX: Ambil nama perusahaan dari database jika session kosong
                    $nama_perusahaan_tampil = 'Perusahaan'; // Default
                  
                    if (!empty($_SESSION['ses_nama_perusahaan'])) {
                      $nama_perusahaan_tampil = $_SESSION['ses_nama_perusahaan'];
                    } else {
                      // Query database untuk ambil nama perusahaan
                      $q_nama = mysqli_query($con, "SELECT p.nama_perusahaan FROM tb_perusahaan p 
                                      JOIN tb_user u ON p.id_user = u.id_user 
                                      WHERE u.username='" . mysqli_real_escape_string($con, $data_username) . "'");
                      if ($q_nama && mysqli_num_rows($q_nama) > 0) {
                        $d_nama = mysqli_fetch_assoc($q_nama);
                        $nama_perusahaan_tampil = $d_nama['nama_perusahaan'];
                        // Update session untuk next load
                        $_SESSION['ses_nama_perusahaan'] = $d_nama['nama_perusahaan'];
                      }
                    }

                    echo htmlspecialchars($nama_perusahaan_tampil);
                    ?>
                  </p>
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
              </div>

              <!-- ✅ STRUKTUR MENU PERUSAHAAN (TETAP SAMA) -->
              <ul class="sidebar-menu" data-widget="treeview">
                <li class="header">Menu System</li>

                <li>
                  <a href="?halaman=beranda">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                  </a>
                </li>

                <li>
                  <a href="?halaman=profile#perusahaan">
                    <i class="fa fa-user"></i> <span>Profil</span>
                  </a>
                </li>

                <!-- <li>
                  <a href="?halaman=loker_tampil">
                    <i class="fa fa-files-o"></i> <span>Kelola Lowongan</span>
                  </a>
                </li> -->

                 <li class="treeview">
                  <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Kelola Lowongan</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="?halaman=loker_tampil"><i class="fa fa-briefcase"></i> Lowongan Kerja</a></li>
                    <li><a href="?halaman=pendaftar_tampil"><i class="fa fa-user"></i> Pendaftar</a></li>
                  </ul>
                </li>

                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-info-circle"></i>
                    <span>Kelola Informasi</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="?halaman=jadwal_tampil"><i class="fa fa-calendar"></i> Penjadwalan Informasi</a></li>
                    <li><a href="?halaman=hasil_tampil"><i class="fa fa-bullhorn"></i> Pengumuman Hasil</a></li>
                  </ul>
                </li>
 

                <li class="header">Menu Lain</li>

                <li>
                  <a class="nav-link" data-toggle="modal" data-target="#exampleModalPerusahaan">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                  </a>
                </li>
              </ul>

            </section>
          </aside>

          <!-- JavaScript untuk Interaksi -->
          <script>
            $(document).ready(function () {
              // Smooth hover effects
              $('.sidebar-menu a').hover(
                function () {
                  $(this).find('i').css('transform', 'scale(1.1)');
                },
                function () {
                  $(this).find('i').css('transform', 'scale(1)');
                }
              );

              // Active menu highlight
              $('.sidebar-menu a').on('click', function () {
                $('.sidebar-menu li').removeClass('active');
                $(this).parent('li').addClass('active');
              });
            });
          </script>



          <?php
          } elseif ($data_status == "Waka Humas") {
            ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-share"></i> <span>laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="?halaman=laporan_per"><i class="fa fa-circle-o"></i> Data Perusahaan</a></li>
              <li><a href="?halaman=laporan_loker"><i class="fa fa-circle-o"></i> Data Loker</a></li>
              <li class="treeview">
                <a href="#"><i class="fa fa-circle-o"></i> Data Alumni
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="?halaman=laporan_alumnib"><i class="fa fa-circle-o"></i> Alumni Bekerja</a></li>
                  <li><a href="?halaman=laporan_alumnis"><i class="fa fa-circle-o"></i> Alumni Studi</a></li>
                </ul>
              <li><a href="?halaman=laporan_pendaftar"><i class="fa fa-circle-o"></i> Data Pendaftar</a></li>
          </li>
          </ul>
          </li>
          <li class="header">Menu Lain</li>
          <li>
            <a class="nav-link" data-toggle="modal" data-target="#exampleModalAdmin"><i class="fa fa-sign-out"></i>
              <span>Logout</span></a>
          </li>
          </ul>




          <?php
          } elseif ($data_status == "admin") {
            ?>

          <!-- ✅ MODERN CSS UNTUK ADMIN - TAMBAHKAN DI SINI -->
          <style>
            /* ========================================
               1. GLOBAL & RESET
               ======================================== */
            * {
              font-family: 'Plus Jakarta Sans', sans-serif;
              box-sizing: border-box;
            }

            body {
              background: #f8fafc;
              overflow-x: auto;
            }

            /* ========================================
               2. HEADER & NAVBAR - GRADIENT UNGU
               ======================================== */
            .main-header {
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
              box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
              height: 70px !important;
              position: fixed !important;
              width: 100%;
              z-index: 1001;
              border: none !important;
            }

            .logo {
              background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
              color: #fff !important;
              font-weight: 800 !important;
              font-size: 22px !important;
              border: none !important;
              width: 280px !important;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
              display: flex;
              align-items: center;
              justify-content: center;
            }

            .logo:hover {
              background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
              transform: translateY(-2px);
              box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            }

            .logo-lg {
              letter-spacing: 0.5px;
            }

            .logo-mini {
              font-size: 18px !important;
            }

            .navbar {
              margin-left: 280px !important;
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
              backdrop-filter: blur(10px);
              box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
              border: none !important;
              height: 70px !important;
              transition: all 0.3s ease;
            }

            .navbar-custom-menu .nav>li>a {
              color: #f8fafc !important;
              font-weight: 600;
              padding: 25px 20px !important;
              transition: all 0.3s ease;
              display: flex;
              align-items: center;
            }

            .navbar-custom-menu .nav>li>a:hover {
              background: rgba(102, 126, 234, 0.1) !important;
              color: #fff !important;
              transform: translateY(-2px);
            }

            /* Dropdown Menus */
            .navbar-nav>.notifications-menu>.dropdown-menu,
            .navbar-nav>.user-menu>.dropdown-menu {
              top: 70px !important;
              right: 0 !important;
              left: auto !important;
              border-radius: 16px !important;
              border: none !important;
              box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
              padding: 0 !important;
              overflow: hidden;
              min-width: 280px !important;
              animation: slideDown 0.3s ease;
            }

            @keyframes slideDown {
              from {
                opacity: 0;
                transform: translateY(-10px);
              }

              to {
                opacity: 1;
                transform: translateY(0);
              }
            }

            .navbar-nav>.user-menu>.dropdown-menu>li>a {
              padding: 14px 20px !important;
              color: #475569 !important;
              font-weight: 500 !important;
              transition: all 0.3s ease !important;
              border-bottom: 1px solid #f1f5f9;
              display: flex;
              align-items: center;
              gap: 10px;
            }

            .navbar-nav>.user-menu>.dropdown-menu>li>a:hover {
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
              color: #fff !important;
              padding-left: 25px !important;
            }

            .navbar-nav>.user-menu>.dropdown-menu>li:last-child>a {
              border-bottom: none !important;
              color: #ef4444 !important;
              font-weight: 600 !important;
            }

            .navbar-nav>.user-menu>.dropdown-menu>li:last-child>a:hover {
              background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
              color: #fff !important;
            }

            /* ========================================
               3. SIDEBAR & USER PANEL - DARK GRADIENT
               ======================================== */
            .main-sidebar {
              background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
              box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
              width: 280px !important;
              position: fixed !important;
              height: 100vh !important;
              overflow-y: auto;
              overflow-x: hidden;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
              z-index: 1000;
            }

            /* Custom Scrollbar */
            .main-sidebar::-webkit-scrollbar {
              width: 6px;
            }

            .main-sidebar::-webkit-scrollbar-track {
              background: rgba(255, 255, 255, 0.05);
            }

            .main-sidebar::-webkit-scrollbar-thumb {
              background: rgba(255, 255, 255, 0.2);
              border-radius: 10px;
            }

            /* User Panel */
            .main-sidebar .user-panel {
              padding: 20px 30px !important;
              margin: 20px 0 !important;
              background: rgba(255, 255, 255, 0.03);
              border-radius: 22px;
              border: 1px solid rgba(255, 255, 255, 0.05);
              display: flex;
              align-items: center;
              gap: 20px;
            }

            .main-sidebar .user-panel>.pull-left.image {
              flex-shrink: 0;
              margin-right: 0 !important;
            }

            .main-sidebar .user-panel .img-circle {
              width: 60px !important;
              height: 60px !important;
              border: 3px solid rgba(102, 126, 234, 0.5) !important;
              box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
              object-fit: cover !important;
              border-radius: 50% !important;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .main-sidebar .user-panel .img-circle:hover {
              transform: scale(1.05);
              border-color: #667eea !important;
              box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            }

            .main-sidebar .user-panel .info {
              padding: 0 !important;
              flex: 1;
              display: flex;
              flex-direction: column;
              justify-content: center;
              gap: 6px;
            }

            .main-sidebar .user-panel .info p {
              font-weight: 700 !important;
              color: #f1f5f9 !important;
              font-size: 15px !important;
              margin: 0 !important;
              letter-spacing: 0.3px;
              line-height: 1.3;
              white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
              padding-left: 65px;
              /* jarak nama perusahaan ke foto */
            }

            .main-sidebar .user-panel .info a {
              color: #94a3b8 !important;
              font-weight: 500 !important;
              font-size: 12px !important;
              display: flex;
              align-items: center;
              gap: 6px;
              text-decoration: none;
              margin-top: 0 !important;
              padding-left: 65px;
              /* jarak nama perusahaan ke foto */
            }

            .main-sidebar .user-panel .info a .fa-circle {
              font-size: 8px !important;
              color: #10b981 !important;
              animation: pulse 2s infinite;
            }

            @keyframes pulse {

              0%,
              100% {
                opacity: 1;
              }

              50% {
                opacity: 0.5;
              }
            }

            /* ========================================
               4. SIDEBAR MENU & TREEVIEW
               ======================================== */
            .sidebar-menu>li.header {
              color: #c7d4e7 !important;
              font-size: 11px !important;
              font-weight: 700 !important;
              text-transform: uppercase !important;
              letter-spacing: 1.5px !important;
              padding: 20px 25px 12px !important;
              margin-top: 2px;
              position: relative;
            }

            .sidebar-menu>li.header::before {
              content: '';
              position: absolute;
              left: 25px;
              bottom: 8px;
              width: 30px;
              height: 2px;
              background: linear-gradient(90deg, #a8b5ff, transparent);
              border-radius: 2px;
            }

            .sidebar-menu>li>a {
              color: #e2e8f0 !important;
              font-weight: 500 !important;
              font-size: 14px !important;
              padding: 14px 25px !important;
              border-radius: 12px !important;
              margin: 4px 15px !important;
              transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
              border: none !important;
              display: flex;
              align-items: center;
              gap: 12px;
            }

            .sidebar-menu>li>a:hover {
              background: rgba(102, 126, 234, 0.15) !important;
              color: #fff !important;
              transform: translateX(5px);
              box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            }

            .sidebar-menu>li.active>a {
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
              color: #fff !important;
              box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
              font-weight: 600 !important;
            }

            .sidebar-menu li>a>.fa {
              width: 24px !important;
              height: 24px !important;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 16px !important;
              transition: transform 0.3s ease;
            }

            .sidebar-menu>li.active>a>.fa {
              transform: scale(1.1);
            }

            /* Treeview */
            .treeview-menu {
              background: rgba(0, 0, 0, 0.1) !important;
              border-radius: 8px;
              margin: 2px 25px !important;
              padding: 8px 0 !important;
            }

            .treeview-menu>li>a {
              color: #94a3b8 !important;
              font-weight: 500 !important;
              font-size: 13px !important;
              padding: 10px 20px 10px 55px !important;
              transition: all 0.3s ease !important;
              border-radius: 8px !important;
              margin: 2px 10px !important;
            }

            .treeview-menu>li>a:hover {
              background: rgba(102, 126, 234, 0.1) !important;
              color: #fff !important;
              padding-left: 60px !important;
            }

            .treeview-menu>li.active>a {
              color: #667eea !important;
              background: rgba(102, 126, 234, 0.15) !important;
              font-weight: 600 !important;
            }

            .pull-right-container>.fa-angle-left {
              transition: transform 0.3s ease !important;
              opacity: 0.7;
            }

            .treeview-menu-open>.pull-right-container>.fa-angle-left {
              transform: rotate(90deg) !important;
            }

            /* Badge */
            .sidebar-menu .label {
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
              color: white;
              padding: 4px 10px;
              border-radius: 12px;
              font-weight: 600;
              font-size: 11px;
              box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
            }

            /* ========================================
               5. CONTENT WRAPPER
               ======================================== */
            .content-header {
              background: linear-gradient(135deg, #f9f8fc 0%, #e2e8f0 100%) !important;
              padding: 10px !important;
              margin: 0 !important;
              border-bottom: none !important;
            }

            .content-wrapper {
              margin-left: 280px !important;
              margin-top: 70px !important;
              min-height: calc(100vh - 70px);
              background: linear-gradient(135deg, #f9f8fc 0%, #e2e8f0 100%);
              padding: 30px;
              transition: all 0.3s ease;
            }

            /* ========================================
               6. RESPONSIVE
               ======================================== */
            /* Mobile Base Settings */
            @media (max-width: 767px) {

              /* Prevent horizontal scroll */
              html,
              body {
                overflow-x: auto !important;
                width: 100% !important;
                position: relative;
              }

              .wrapper {
                overflow-x: auto !important;
              }

              /* HEADER - 2 Baris di Mobile */
              .main-header {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100px !important;
                z-index: 99999 !important;
                box-shadow: 0 2px 15px rgba(102, 126, 234, 0.3) !important;
              }

              /* Baris Atas - Logo */
              .main-header .logo {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 50px !important;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0 !important;
                border: none !important;
              }

              .logo-lg {
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
                font-size: 18px !important;
                font-weight: 700 !important;
                color: #fff !important;
              }

              .logo-mini {
                display: none !important;
              }

              /* Baris Bawah - Navbar */
              .main-header .navbar {
                position: absolute !important;
                top: 50px !important;
                left: 0 !important;
                width: 100% !important;
                height: 50px !important;
                margin: 0 !important;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                border: none !important;
              }

              /* Hamburger Menu */
              .sidebar-toggle {
                position: absolute !important;
                left: 15px !important;
                top: -1px !important;
                color: #fff !important;
                font-size: 24px !important;
                padding: 8px !important;
                z-index: 999999 !important;
              }

              /* Menu Kanan - Notif & Profile */
              .navbar-custom-menu {
                position: absolute !important;
                right: 10px !important;
                top: 0 !important;
              }

              .navbar-custom-menu .nav {
                display: flex !important;
                align-items: center !important;
              }

              .navbar-custom-menu .nav>li>a {
                padding: 12px 10px !important;
                color: #fff !important;
              }

              /* User Image */
              .user-image {
                width: 32px !important;
                height: 32px !important;
                border-radius: 50% !important;
                object-fit: cover !important;
                border: 2px solid rgba(255, 255, 255, 0.3) !important;
              }

              .hidden-xs {
                display: none !important;
              }

              /* Notification Badge */
              .label-warning {
                position: absolute !important;
                top: 5px !important;
                right: 5px !important;
                padding: 2px 5px !important;
                font-size: 9px !important;
              }

              /* SIDEBAR */
              .main-sidebar {
                transform: translateX(-100%);
              }

              .sidebar-open .main-sidebar {
                transform: translateX(0) !important;
              }

              /* User Panel Sidebar */
              .user-panel {
                padding: 15px !important;
                margin: 10px 0 !important;
              }

              .user-panel .img-circle {
                width: 50px !important;
                height: 50px !important;
              }

              .user-panel .info p {
                font-size: 14px !important;
              }

              .main-sidebar .user-panel .info p {
                font-weight: 700 !important;
                color: #f1f5f9 !important;
                font-size: 15px !important;
                margin-top: 15px !important;
                /* hapus jarak berlebih */
                line-height: 1.2 !important;
                letter-spacing: 0.3px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
              }

              .main-sidebar .user-panel .info a {
                color: #94a3b8 !important;
                font-weight: 500 !important;
                font-size: 12px !important;
                display: flex;
                align-items: center;
                gap: 6px;
                text-decoration: none;
                margin-top: -13px !important;
                /* jarak pas antara Admin dan Online */
              }

              /* Menu Items */
              .sidebar-menu>li>a {
                padding: 12px 15px !important;
                font-size: 14px !important;
              }

              .sidebar-menu li>a>.fa {
                width: 20px !important;
                font-size: 14px !important;
              }

              /* CONTENT WRAPPER */
              .content-wrapper {
                margin-left: 0 !important;
                margin-top: 85px !important;
                min-height: calc(100vh - 100px) !important;
                padding: 15px !important;
              }

              /* Content Header */
              .content-header {
                padding: 15px !important;
                text-align: center !important;
              }

              .content-header h1 {
                font-size: 20px !important;
                margin: 0 0 5px 0 !important;
                display: block !important;
              }

              .content-header h1::before {
                display: none !important;
              }

              .content-header p {
                font-size: 13px !important;
              }

              .content-header .breadcrumb {
                display: none !important;
              }

              /* CARDS - Dashboard */
              .row {
                display: flex !important;
                flex-direction: column !important;
              }

              .col-lg-3,
              .col-md-3,
              .col-sm-6,
              .col-xs-12 {
                width: 100% !important;
                padding: 0 !important;
                margin-bottom: 15px !important;
              }

              .small-box,
              .info-box,
              .box {
                width: 100% !important;
                border-radius: 20px !important;
                margin-bottom: 15px !important;
              }

              /* Small Box Content */
              .small-box .icon {
                width: 60px !important;
                height: 60px !important;
                font-size: 28px !important;
                margin: 15px !important;
              }

              .small-box .inner {
                padding: 15px 20px !important;
              }

              .small-box h3 {
                font-size: 28px !important;
              }

              .small-box p {
                font-size: 12px !important;
              }

              .small-box .small-box-footer {
                padding: 8px 20px !important;
                font-size: 13px !important;
              }

              /* Tables */
              .table-responsive {
                border: none !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
              }

              table.dataTable {
                font-size: 13px !important;
              }

              .dataTables_wrapper .row {
                margin: 10px 0 !important;
              }

              .dataTables_length,
              .dataTables_filter,
              .dataTables_info,
              .dataTables_paginate {
                float: none !important;
                text-align: center !important;
                margin: 5px 0 !important;
              }

              .dataTables_filter input {
                width: 100% !important;
                max-width: 250px !important;
                margin: 5px 0 !important;
              }

              /* Buttons */
              .btn {
                padding: 8px 16px !important;
                font-size: 14px !important;
                margin: 3px 0 !important;
                min-height: 44px !important;
              }

              .btn-group .btn {
                margin: 2px !important;
              }

              /* Forms */
              .form-control {
                font-size: 16px !important;
                padding: 10px 12px !important;
                min-height: 44px !important;
              }

              .form-group {
                margin-bottom: 15px !important;
              }

              /* Modal */
              .modal-dialog {
                margin: 10px !important;
                width: auto !important;
                max-width: 95vw !important;
              }

              .modal-content {
                border-radius: 16px !important;
              }

              .modal-header {
                padding: 15px 20px !important;
              }

              .modal-body {
                padding: 20px !important;
                max-height: 60vh !important;
                overflow-y: auto !important;
              }

              .modal-footer {
                padding: 15px 20px !important;
              }

              /* Dropdown Menus */
              .dropdown-menu {
                left: auto !important;
                right: 0 !important;
                min-width: 250px !important;
                border-radius: 12px !important;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
              }

              /* Touch Optimizations */
              a,
              button,
              input,
              select,
              textarea {
                -webkit-tap-highlight-color: transparent;
              }

              /* Sidebar Menu Touch */
              .sidebar-menu a {
                min-height: 44px !important;
              }

              /* Treeview Menu */
              .treeview-menu {
                margin: 2px 5px !important;
              }

              .treeview-menu>li>a {
                padding: 10px 15px 10px 45px !important;
                font-size: 13px !important;
              }
            }



            /* Global Scrollbar */
            ::-webkit-scrollbar {
              width: 8px;
            }

            ::-webkit-scrollbar-track {
              background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
              background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
              border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
              background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
            }
          </style>

          <!-- Modern Font -->
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">
          <!-- ✅ HEADER MODERN ADMIN - GANTI DARI <header> SAMPAI </nav> -->
          <header class="main-header">
            <a href="index.php" class="logo">
              <span class="logo-mini"><b>BKK</b></span>
              <span class="logo-lg">🎓 Portal BKK</span>
            </a>

            <nav class="navbar navbar-static-top">
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="color:#fff;font-size:20px;">
                <span class="sr-only">Toggle navigation</span>
              </a>

              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Notifikasi -->
                  <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o" style="font-size:20px;"></i>
                      <span class="label label-warning"><?php
                      if ($data_status == "admin") {
                        $sql_hitung = "SELECT COUNT(id_lowongan) from tb_lowongan where status ='Tangguhkan'";
                        $q_hit = mysqli_query($con, $sql_hitung);
                        while ($row = mysqli_fetch_array($q_hit)) {
                          echo $row[0];
                        }
                      }
                      ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">Notifikasi Lowongan</li>
                      <li>
                        <ul class="menu">
                          <?php if ($data_status == "admin") {
                            $periksa = mysqli_query($con, "SELECT id_lowongan FROM tb_lowongan WHERE status='Tangguhkan' ORDER BY id_lowongan DESC LIMIT 1");
                            while ($q = mysqli_fetch_array($periksa)) {
                              if ($q['id_lowongan'] <= 5) {
                                echo "<div style='padding:5px' class='alert alert-info'><i class='glyphicon glyphicon-info-sign'></i> Lowongan <a style='color:blue'>" . $q['id_lowongan'] . "</a> Masuk. Silahkan Cek !!</div>";
                              }
                            }
                          } ?>
                          <li><a href="#"><i class="fa fa-users text-aqua"></i> Silahkan Cek Untuk Detail Loker</a></li>
                        </ul>
                      </li>
                      <li class="footer"><a href="?halaman=loker_tampil">View all</a></li>
                    </ul>
                  </li>

                  <!-- User Menu Admin -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php echo $foto_user; ?>" class="user-image"
                        style="width:40px;height:40px;margin:-10px 0 -10px 0;border-radius:50%;object-fit:cover;margin-right:15px;"
                        alt="User Image">
                      <span class="hidden-xs" style="font-weight:600;"><?php echo htmlspecialchars($data_nama); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li
                        style="text-align:center;padding:25px 20px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <img src="<?php echo $foto_user; ?>"
                          style="width:70px;height:70px;border-radius:50%;margin-bottom:12px;object-fit:cover;border:3px solid rgba(255,255,255,0.3);">
                        <h4 style="color:white;margin:10px 0 5px 0;font-weight:700;">
                          <?php echo htmlspecialchars($data_nama); ?>
                        </h4>
                        <p style="color:rgba(255,255,255,0.9);margin:0;font-size:13px;">Administrator BKK</p>
                      </li>
                      <li><a href="?halaman=profile"><i class="fa fa-user" style="margin-right:10px;"></i> Profil
                          Admin</a></li>
                      <li><a href="?halaman=super_tampil"><i class="fa fa-users" style="margin-right:10px;"></i> Manajemen
                          User</a></li>
                      <li style="border-top:2px solid #f1f5f9;">
                        <a data-toggle="modal" data-target="#exampleModal"><i class="fa fa-sign-out"
                            style="margin-right:10px;"></i> Keluar</a>
                      </li>
                    </ul>
                  </li>

                  <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears" style="font-size:20px;"></i></a>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
          <!-- ✅ SIDEBAR MODERN ADMIN - GANTI DARI <aside> SAMPAI </section> -->
          <aside class="main-sidebar">
            <section class="sidebar">
              <!-- User Panel Admin -->
              <div class="user-panel">
                <div class="image">
                  <img src="<?php echo $foto_user; ?>" class="img-circle" alt="Admin Image"
                    style="width:60px!important;height:60px!important;object-fit:cover!important;border:3px solid rgba(102,126,234,0.5);">
                </div>
                <div class="info">
                  <p><?php echo htmlspecialchars($data_nama); ?></p>
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
              </div>

              <!-- MENU ADMIN (STRUKTUR TETAP SAMA) -->
              <ul class="sidebar-menu" data-widget="treeview">
                <li class="header">Menu System</li>

                <li><a href="?halaman=beranda"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li><a href="?halaman=tambah_akun_peserta"><i class="fa fa-user-plus"></i> <span>Tambah Akun</span></a>
                </li>
                <li><a href="?halaman=verifikasi_perusahaan"><i class="fa fa-check-circle"></i> <span>Verifikasi
                      Perusahaan</span></a></li>
                <li><a href="?halaman=loker_tampil"><i class="fa fa-briefcase"></i> Lowongan Kerja</a></li>

                <!-- <li class="treeview">
                <a href="#"><i class="fa fa-briefcase"></i><span>Kelola Lowongan</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="?halaman=loker_tampil"><i class="fa fa-briefcase"></i> Lowongan Kerja</a></li>
                    <li><a href="?halaman=pendaftar_tampil"><i class="fa fa-user"></i> Pendaftar</a></li>
                </ul>
            </li> 
            
            <li class="treeview">
                <a href="#"><i class="fa fa-info-circle"></i><span>Kelola Informasi</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="?halaman=jadwal_tampil"><i class="fa fa-calendar"></i> Penjadwalan Ujian</a></li>
                    <li><a href="?halaman=hasil_tampil"><i class="fa fa-bullhorn"></i> Pengumuman Hasil</a></li>
                </ul>
            </li> -->

                <li class="treeview">
                  <a href="#"><i class="fa fa-user-o"></i><span>Pelacakan Alumni</span><span
                      class="pull-right-container"><span class="label label-primary pull-right">2</span></span></a>
                  <ul class="treeview-menu">
                    <li><a href="?halaman=tracerb"><i class="fa fa-building"></i> Alumni Bekerja</a></li>
                    <li><a href="?halaman=tracerbk"><i class="fa fa-home"></i> Alumni Belum Bekerja</a></li>
                    <li><a href="?halaman=tracers"><i class="fa fa-university"></i> Alumni Studi Lanjut</a></li>
                  </ul>
                </li>

                <li class="treeview">
                  <a href="#"><i class="fa fa-share"></i><span>Kelola User</span><span class="pull-right-container"><i
                        class="fa fa-angle-left pull-right"></i></span></a>
                  <ul class="treeview-menu">
                    <li><a href="?halaman=super_tampil"><i class="fa fa-user-secret"></i> Super User</a></li>
                    <li><a href="?halaman=siswa_tampil"><i class="fa fa-user-secret"></i> User Peserta</a></li>
                    <li><a href="?halaman=perusahaan_tampil"><i class="fa fa-user-secret"></i> User Perusahaan</a></li>
                  </ul>
                </li>

                <!--   <li class="treeview">
                <a href="#"><i class="fa fa-share"></i><span>Laporan</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Data Alumni<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="?halaman=laporan_alumnib"><i class="fa fa-circle-o"></i> Alumni Bekerja</a></li>
                            <li><a href="?halaman=laporan_alumnibk"><i class="fa fa-circle-o"></i> Alumni Belum Bekerja</a></li>
                            <li><a href="?halaman=laporan_alumnis"><i class="fa fa-circle-o"></i> Alumni Studi</a></li>
                        </ul>
                    </li>
                    <li><a href="?halaman=laporan_pendaftar"><i class="fa fa-circle-o"></i> Data Pendaftar</a></li> 
                </ul>
            </li> -->

                <li class="header">Menu Lain</li>
                <li><a class="nav-link" data-toggle="modal" data-target="#exampleModalAdmin"><i
                      class="fa fa-sign-out"></i>
                    <span>Logout</span></a></li>
              </ul>
            </section>
          </aside>
          <?php
          }
          ?>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- ✅ JAVASCRIPT INTERAKSI MODERN -->
    <script>
      $(document).ready(function () {
        // Smooth hover effects
        $('.sidebar-menu a').hover(
          function () { $(this).find('i').css('transform', 'scale(1.1)'); },
          function () { $(this).find('i').css('transform', 'scale(1)'); }
        );

        // Active menu highlight
        $('.sidebar-menu a').on('click', function () {
          $('.sidebar-menu li').removeClass('active');
          $(this).parent('li').addClass('active');
        });
      });
    </script>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Menjadikan halaman web dinamis, 
                dengan menjadikan halaman lain yang dipanggil sebagai sebuah konten dari index.php-->
        <?php
        if (isset($_GET['halaman'])) {
          $hal = $_GET['halaman'];

          switch ($hal) {
            case 'beranda':
              include "pages/beranda.php";
              break;
            case 'profile':
              include "pages/profile.php";
              break;
            case 'profile_perusahaan':
              include "pages/profile.php";
              break;
            case 'edit_profile_perusahaan':
              include "pages/perusahaan/edit_profile.php";
              break;
            case 'profile_update_perusahaan':
              include "pages/perusahaan/profile_update.php";
              break;
            case 'upload_foto':
              include "pages/upload_foto.php";
              break;
            case 'siswa_tampil':
              include "pages/peserta/siswa_tampil.php";
              break;
            case 'siswa_tambah':
              include "pages/peserta/siswa_tambah.php";
              break;
            case 'siswa_detail':
              include "pages/peserta/siswa_detail.php";
              break;
            case 'siswa_ubah':
              include "pages/peserta/siswa_ubah.php";
              break;
            case 'siswa_aksi':
              include "pages/peserta/siswa_aksi.php";
              break;


            case 'loker_tampil':
              include "pages/loker/loker_tampil.php";
              break;
            case 'loker_tampil_per':
              include "pages/loker/loker_tampil_per.php";
              break;
            case 'loker_ubah':
              include "pages/loker/loker_ubah.php";
              break;
            case 'loker_arsip':
              include "pages/loker/loker_arsip.php";
              break;
            case 'loker_konfirm':
              include "pages/loker/loker_konfirm.php";
              break;
            case 'loker_tambah':
              include "pages/loker/loker_tambah.php";
              break;
            case 'loker_tambah_per':
              include "pages/loker/loker_tambah_per.php";
              break;
            case 'loker_aksi':
              include "pages/loker/loker_aksi.php";
              break;


            case 'jadwal_tampil':
              include "pages/jadwal/jadwal_tampil.php";
              break;
            case 'jadwal_tambah':
              include "pages/jadwal/jadwal_tambah.php";
              break;
            case 'jadwal_ubah':
              include "pages/jadwal/jadwal_ubah.php";
              break;
            case 'jadwal_arsip':
              include "pages/jadwal/jadwal_arsip.php";
              break;
            case 'jadwal_aksi':
              include "pages/jadwal/jadwal_aksi.php";
              break;


            case 'hasil_tampil':
              include "pages/kelulusan/hasil_tampil.php";
              break;
            case 'hasil_tambah_per':
              include "pages/kelulusan/hasil_tambah_per.php";
              break;
            case 'download':
              include "pages/kelulusan/download.php";
              break;
            case 'hasil_ubah':
              include "pages/kelulusan/hasil_ubah.php";
              break;
            case 'hasil_aksi':
              include "pages/kelulusan/hasil_aksi.php";
              break;
            case 'hasil_arsip':
              include "pages/kelulusan/hasil_arsip.php";
              break;
            case 'hasil_unarsip':
              include "pages/kelulusan/hasil_unarsip.php";
              break;


            case 'user_tampil':
              include "pages/user/user_tampil.php";
              break;
            case 'user_tambah':
              include "pages/user/user_tambah.php";
              break;
            case 'user_ubah':
              include "pages/user/user_ubah.php";
              break;
            case 'user_aksi':
              include "pages/user/user_aksi.php";
              break;


            case 'super_tampil':
              include "pages/user/super_tampil.php";
              break;
            case 'super_tambah':
              include "pages/user/super_tambah.php";
              break;
            case 'super_ubah':
              include "pages/user/super_ubah.php";
              break;
            case 'super_aksi':
              include "pages/user/super_aksi.php";
              break;
            case 'super_aktif':
              include "pages/user/super_aktif.php";
              break;


            case 'pendaftar_tampil':
              include "pages/pendaftar/pendaftar_tampil.php";
              break;
            case 'pendaftar_tambah':
              include "pages/pendaftar/pendaftar_tambah.php";
              break;
            case 'pendaftar_aksi':
              include "pages/pendaftar/pendaftar_aksi.php";
              break;
            case 'pendaftar_detail':
              include "pages/pendaftar/detail.php";
              break;
            case 'ubah_status':
              include "pages/pendaftar/ubah_status.php";
              break;

            case 'perusahaan_tampil':
              include "pages/perusahaan/perusahaan_tampil.php";
              break;
            case 'perusahaan_detail':
              include "pages/perusahaan/perusahaan_detail.php";
              break;

            case 'sekolah_tampil':
              include "pages/sekolah/sekolah_tampil.php";
              break;
            case 'sekolah_tambah':
              include "pages/sekolah/sekolah_tambah.php";
              break;
            case 'sekolah_ubah':
              include "pages/sekolah/sekolah_ubah.php";
              break;
            case 'sekolah_aksi':
              include "pages/sekolah/sekolah_aksi.php";
              break;

            case 'lowongan':
              include "pages/informasi_loker.php";
              break;

            case 'laporan_per':
              include "pages/laporan/laporan_perusahaan.php";
              break;
            case 'laporan_loker':
              include "pages/laporan/laporan_loker.php";
              break;
            case 'laporan_alumnib':
              include "pages/laporan/laporan_alumnib.php";
              break;
            case 'laporan_alumnibk':
              include "pages/laporan/laporan_alumnibk.php";
              break;
            case 'laporan_alumnis':
              include "pages/laporan/laporan_alumnis.php";
              break;
            case 'laporan_chart':
              include "pages/laporan/grafik.php";
              break;
            case 'laporan_pendaftar':
              include "pages/laporan/laporan_pendaftar.php";
              break;
            case 'cetak_kerja_semua':
              include "pages/laporan/cetak_alumni.php";
              break;
            case 'cetak_kerja':
              include "pages/laporan/cetak_alumnib.php";
              break;
            case 'cetak_studi':
              include "pages/laporan/cetak_alumni_s.php";
              break;


            case 'tracerb':
              include "pages/tracer/tracer_tampil.php";
              break;
            case 'tracerbk':
              include "pages/tracer/tracer_tampilbkk.php";
              break;
            case 'tracers':
              include "pages/tracer/tracer_tampilsl.php";
              break;
            case 'tracer_detail':
              include "pages/tracer/tracer_detail.php";
              break;
            case 'tracer_tampilbkk':
              include "pages/tracer/tracer_tampilbkk.php";
              break;
            case 'tracer_tampilbkk_sl':
              include "pages/tracer/tracer_tampilbkk_sl.php";
              break;
            case 'tracer_ubah':
              include "pages/tracer/tracer_ubah.php";
              break;


            case 'tambah_akun_peserta':
              include "pages/admin/tambah_akun_peserta.php";
              break;
            case 'data_user':
              include "pages/admin/data_user.php";
              break;


            case 'tambah_sosial_media':
              include "pages/tambah_sosial_media.php";
              break;
            case 'edit_sosial_media':
              include "pages/edit_sosial_media.php";
              break;
            case 'update_sosial_media':
              include "pages/update_sosial_media.php";
              break;
            case 'hapus_sosial_media':
              include "pages/hapus_sosial_media.php";
              break;


            case 'edit_dokumen_perusahaan':
              include "pages/edit_dokumen_perusahaan.php";
              break;
            case 'update_dokumen_perusahaan':
              include "pages/update_dokumen_perusahaan.php";
              break;
            case 'hapus_dokumen_perusahaan':
              include "pages/hapus_dokumen_perusahaan.php";
              break;


            case 'verifikasi_perusahaan':
              include "pages/verifikasi_perusahaan.php";
              break;
            case 'proses_verifikasi':
              include "pages/proses_verifikasi.php";
              break;
            case 'profile_peserta':
              include "pages/profile_peserta.php";
              break;

            default:
              echo "<center><h3> ERROR !</h3></center>";
              break;
          }
        } else {
          include "pages/beranda.php";
        }
        ?>
      </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark" style="display: none;">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <!-- <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div> -->
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <!-- <div class="tab-pane" id="control-sidebar-settings-tab"> -->

        <!-- /.tab-pane -->
      </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->

  <script src="bower_components/chart.js/Chart.js"></script>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="bower_components/raphael/raphael.min.js"></script>
  <script src="bower_components/morris.js/morris.min.js"></script>
  <!-- Sparkline -->
  <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="bower_components/moment/min/moment.min.js"></script>
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <!-- page script -->
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
      })
    })
  </script>
  <!-- <script>
  $(function () {
    "use strict";

   
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        {y: '2006', a: 100, b: 90},
        {y: '2007', a: 75, b: 65},
        {y: '2008', a: 50, b: 40},
        {y: '2009', a: 75, b: 65},
        {y: '2010', a: 50, b: 40},
        {y: '2011', a: 75, b: 65},
        {y: '2012', a: 100, b: 90}
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['CPU', 'DISK'],
      hideHover: 'auto'
    });
  });
</script> -->

  <!-- Modal Logout Admin / Ka. BKK / Waka Humas -->
  <div class="modal fade" id="exampleModalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div class="modal-header"
          style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius:16px 16px 0 0;padding:25px;">
          <h5 class="modal-title" style="color:white;font-weight:700;">👋 Yakin Keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" style="color:white;"><span
              aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body" style="padding:25px;">Apakah Anda yakin ingin keluar dari sistem?</div>
        <div class="modal-footer" style="border:none;padding:20px 25px;">
          <button class="btn" type="button" data-dismiss="modal" style="background:#f1f5f9;">Cancel</button>
          <a class="btn" href="../logout.php"
            style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Logout Perusahaan -->
  <div class="modal fade" id="exampleModalPerusahaan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div class="modal-header"
          style="background:linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);border-radius:16px 16px 0 0;padding:25px;">
          <h5 class="modal-title" style="color:white;font-weight:700;">👋 Yakin Keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" style="color:white;"><span
              aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body" style="padding:25px;">Apakah Anda yakin ingin keluar dari sistem?</div>
        <div class="modal-footer" style="border:none;padding:20px 25px;">
          <button class="btn" type="button" data-dismiss="modal" style="background:#f1f5f9;">Cancel</button>
          <a class="btn" href="../logout.php"
            style="background:linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);color:white;">Logout</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
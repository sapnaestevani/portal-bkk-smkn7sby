<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// ambil role dari session
$data_status = isset($_SESSION['ses_level']) ? $_SESSION['ses_level'] : "";
include_once("koneksi.php");
?>


<?php
if ($data_status == "Ka. BKK" || $data_status == "admin") {
  
  // Hitung semua data sekali query untuk efisiensi
  $lowongan_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM tb_lowongan"))[0];
  $perusahaan_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM tb_user WHERE role='perusahaan'"))[0];
  $siswa_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM tb_siswa"))[0];
  $pendaftar_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM tb_lamaran"))[0];
?>

<style>
  /* Modern Dashboard Styling */
  .modern-dashboard {
    padding: 20px -40px;
    background: linear-gradient(135deg, #f5f6f7 0%, #e5e7eb 100%);
    min-height: 100vh;
  }
  
  .dashboard-header {
    text-align: center;
    margin-bottom: 50px;
    animation: fadeInDown 0.8s ease;
  }
  
  .dashboard-header h1 {
    font-size: 42px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
  }
  
  .dashboard-header p {
    font-size: 18px;
    color: #718096;
    font-weight: 500;
  }
  
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto 50px auto;
    padding: 0 20px;
  }
  
  .stat-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    animation: fadeInUp 0.8s ease backwards;
  }
  
  .stat-card:nth-child(1) { animation-delay: 0.1s; }
  .stat-card:nth-child(2) { animation-delay: 0.2s; }
  .stat-card:nth-child(3) { animation-delay: 0.3s; }
  .stat-card:nth-child(4) { animation-delay: 0.4s; }
  
  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--card-color), var(--card-color-secondary));
    transition: height 0.4s ease;
  }
  
  .stat-card:hover::before {
    height: 100%;
    opacity: 0.1;
  }
  
  .stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  }
  
  .stat-card.lowongan { --card-color: #06b6d4; --card-color-secondary: #3b82f6; }
  .stat-card.perusahaan { --card-color: #10b981; --card-color-secondary: #34d399; }
  .stat-card.siswa { --card-color: #f59e0b; --card-color-secondary: #fbbf24; }
  .stat-card.pendaftar { --card-color: #ef4444; --card-color-secondary: #f87171; }
  
  .stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin-bottom: 20px;
    background: linear-gradient(135deg, var(--card-color), var(--card-color-secondary));
    color: white;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }
  
  .stat-number {
    font-size: 48px;
    font-weight: 800;
    background: linear-gradient(135deg, var(--card-color), var(--card-color-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
    line-height: 1;
  }
  
  .stat-label {
    font-size: 16px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 15px;
  }
  
  .stat-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--card-color);
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: gap 0.3s ease;
  }
  
  .stat-card:hover .stat-link {
    gap: 12px;
  }
  
  .logo-section {
    text-align: center;
    padding: 40px 20px;
    animation: fadeIn 1s ease;
  }
  
  .logo-section img {
    max-width: 250px;
    height: auto;
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.15));
    transition: transform 0.4s ease;
    border-radius: 20px;
  }
  
  .logo-section img:hover {
    transform: scale(1.05) rotate(2deg);
  }
  
  .logo-text {
    margin-top: 25px;
    font-family: 'Courier New', monospace;
    font-size: 20px;
    font-weight: 700;
    color: #2d3748;
    line-height: 1.6;
  }
  
  .logo-text span {
    display: block;
    font-size: 16px;
    color: #718096;
    font-weight: 500;
  }
  
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @media (max-width: 768px) {
    .dashboard-header h1 {
      font-size: 32px;
    }
    
    .stats-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    
    .stat-number {
      font-size: 40px;
    }
    
    .logo-section img {
      max-width: 200px;
    }
  }
</style>
<div class="modern-dashboard">
  <!-- Header -->
  <div class="dashboard-header">
    <h1>🎓 Dashboard Admin</h1>
    <p>Portal Bursa Kerja Khusus - SMK  Negeri  7  Surabaya</p>
  </div>
  
  <!-- Stats Grid -->
  <div class="stats-grid">
    <!-- Lowongan Kerja -->
    <a href="?halaman=loker_tampil" class="stat-card lowongan">
      <div class="stat-icon">
        <i class="fa fa-briefcase"></i>
      </div>
      <div class="stat-number"><?= $lowongan_count; ?></div>
      <div class="stat-label">Lowongan Kerja</div>
      <div class="stat-link">
        Selengkapnya <i class="fa fa-arrow-right"></i>
      </div>
    </a>
    
    <!-- Perusahaan -->
    <a href="?halaman=perusahaan_tampil" class="stat-card perusahaan">
      <div class="stat-icon">
        <i class="fa fa-building"></i>
      </div>
      <div class="stat-number"><?= $perusahaan_count; ?></div>
      <div class="stat-label">Perusahaan</div>
      <div class="stat-link">
        Selengkapnya <i class="fa fa-arrow-right"></i>
      </div>
    </a>

    <!-- Siswa Terdaftar -->
    <a href="?halaman=tambah_akun_peserta" class="stat-card siswa">
      <div class="stat-icon">
        <i class="fa fa-graduation-cap"></i>
      </div>
      <div class="stat-number"><?= $siswa_count; ?></div>
      <div class="stat-label">Tambah Akun</div>
      <div class="stat-link">
        Selengkapnya <i class="fa fa-arrow-right"></i>
      </div>
    </a> 

    <!-- Data Pendaftar -->
    <a href="?halaman=verifikasi_perusahaan" class="stat-card pendaftar">
      <div class="stat-icon">
        <i class="fa fa-users"></i>
      </div>
      <div class="stat-number"><?= $pendaftar_count; ?></div>
      <div class="stat-label">Verifikasi Akun Perusahaan</div>
      <div class="stat-link">
        Selengkapnya <i class="fa fa-arrow-right"></i>
      </div>
    </a>
  </div> 
    
    <!-- Siswa Terdaftar 
    <a href="?halaman=siswa_tampil" class="stat-card siswa">
      <div class="stat-icon">
        <i class="fa fa-graduation-cap"></i>
      </div>
      <div class="stat-number"><?= $siswa_count; ?></div>
      <div class="stat-label">Siswa Terdaftar</div>
      <div class="stat-link">
        Selengkapnya <i class="fa fa-arrow-right"></i>
      </div>
    </a> -->
    
    <!-- Data Pendaftar 
    <a href="?halaman=pendaftar_tampil" class="stat-card pendaftar">
      <div class="stat-icon">
        <i class="fa fa-users"></i>
      </div>
      <div class="stat-number"><?= $pendaftar_count; ?></div>
      <div class="stat-label">Data Pendaftar</div>
      <div class="stat-link">
        Selengkapnya <i class="fa fa-arrow-right"></i>
      </div>
    </a>
  </div> -->
  
  <!-- Logo Section -->
  <div class="logo-section">
    <img src="../images/logosmk.png" alt="Logo SMK Negeri 7 Surabaya">
    <div class="logo-text">
      Portal Bursa Kerja Khusus
      <span>SMK Negeri 7 Surabaya</span>
    </div>
  </div>
</div>




    <!-- beranda nya punya perusahaan -->

  <?php
} elseif ($data_status == "perusahaan") {
  ?>

  <div class="form-group">

    <style>
      /* Modern Dashboard Styling - Sama dengan Siswa */
      .modern-dashboard {
        padding: 20px 0;
      }

      /* Progress Card Modern */
      .progress-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        color: white;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
      }

      .progress-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
      }

      @keyframes pulse {

        0%,
        100% {
          transform: scale(1);
          opacity: 0.5;
        }

        50% {
          transform: scale(1.1);
          opacity: 0.8;
        }
      }

      .progress-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
      }

      .progress-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 24px;
      }

      .progress-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
      }

      .progress-subtitle {
        font-size: 14px;
        opacity: 0.9;
      }

      .modern-progress {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        height: 30px;
        overflow: hidden;
        position: relative;
        z-index: 1;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      .modern-progress-bar {
        background: linear-gradient(90deg, #fff 0%, #f0f0f0 100%);
        height: 100%;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: #667eea;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }

      .modern-progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
      }

      @keyframes shimmer {
        0% {
          transform: translateX(-100%);
        }

        100% {
          transform: translateX(100%);
        }
      }

      .progress-text {
        position: relative;
        z-index: 2;
      }

      /* Alert Modern */
      .alert-modern {
        border-radius: 15px;
        padding: 20px 25px;
        margin-bottom: 25px;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 15px;
        animation: slideIn 0.5s ease;
      }

      @keyframes slideIn {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .alert-icon {
        font-size: 32px;
      }

      .alert-content {
        flex: 1;
      }

      .alert-title {
        font-weight: 700;
        margin-bottom: 5px;
      }

      .alert-message {
        margin: 0;
        opacity: 0.9;
      }

      .alert-danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
      }

      .alert-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
      }

      /* Info Cards Modern */
      .info-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
      }

      .info-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
      }

      .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--card-gradient);
        transition: height 0.3s ease;
      }

      .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      }

      .info-card:hover::before {
        height: 100%;
        opacity: 0.05;
      }

      .info-card-blue {
        --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }

      .info-card-orange {
        --card-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      }

      .info-card-green {
        --card-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      }

      .card-icon {
        width: 60px;
        height: 60px;
        background: var(--card-gradient);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 20px;
        color: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }

      .card-number {
        font-size: 48px;
        font-weight: 800;
        background: var(--card-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        line-height: 1;
      }

      .card-label {
        font-size: 16px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 20px;
      }

      .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 15px;
        border-top: 2px solid #f1f5f9;
      }

      .card-link {
        color: var(--card-color, #667eea);
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
      }

      .info-card:hover .card-link {
        gap: 12px;
      }

      .card-arrow {
        transition: transform 0.3s ease;
      }

      .info-card:hover .card-arrow {
        transform: translateX(5px);
      }

      /* Responsive */
      @media (max-width: 768px) {
        .info-cards {
          grid-template-columns: 1fr;
        }

        .progress-card {
          padding: 20px;
        }

        .card-number {
          font-size: 36px;
        }
      }

      /* Animation for cards */
      .info-card {
        animation: fadeInUp 0.6s ease backwards;
      }

      .info-card:nth-child(1) {
        animation-delay: 0.1s;
      }

      .info-card:nth-child(2) {
        animation-delay: 0.2s;
      }

      .info-card:nth-child(3) {
        animation-delay: 0.3s;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* Portal BKK Section */
      .portal-bkk-section {
        text-align: center;
        margin: 40px 0 30px 0;
        padding: 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      }

      .portal-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #1e293b;
        margin: 0;
      }

      .portal-title-secondary {
        color: #3b82f6;
      }

      .logo-bkk {
        max-width: 200px;
        width: 100%;
        height: auto;
        display: block;
        margin: 20px auto 0 auto;
        filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.1));
        transition: transform 0.3s ease;
      }

      .logo-bkk:hover {
        transform: scale(1.05);
      }

      @media (max-width:768px) {
        .portal-title {
          font-size: 18px !important;
        }

        .logo-bkk {
          max-width: 150px !important;
        }
      }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        🏢 Beranda
        <small>Portal BKK SMK Negeri 7 Surabaya</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content modern-dashboard">

      <?php
      // === LOGIKA PHP TETAP SAMA - TIDAK DIUBAH ===
      $username = $_SESSION['ses_username'];

      $sql_profil = mysqli_query($con, "
  SELECT 
    u.username,
    p.id_perusahaan, 
    p.nama_perusahaan,
    p.email,
    p.alamat,
    p.bidang_usaha,
    p.jumlah_karyawan,
    p.deskripsi,
    p.manfaat,
    p.logo,
    p.status_verifikasi,
    d.file_nib,
    d.file_npwp,
    d.file_mou
  FROM tb_user u
  LEFT JOIN tb_perusahaan p ON u.id_user = p.id_user
  LEFT JOIN tb_dokumen_perusahaan d ON p.id_perusahaan = d.id_perusahaan
  WHERE u.username='$username'
");
      $profil = mysqli_fetch_assoc($sql_profil);

      /* =========================
         HITUNG PROGRESS (FIX)
         ========================= */
      $total = 11;
      $isi = 0;

      /* DATA PERUSAHAAN */
      if (!empty($profil['nama_perusahaan']))
        $isi++;
      if (!empty($profil['email']))
        $isi++;
      if (!empty($profil['alamat']))
        $isi++;
      if (!empty($profil['bidang_usaha']))
        $isi++;
      if (!empty($profil['jumlah_karyawan']))
        $isi++;
      if (!empty($profil['deskripsi']))
        $isi++;
      if (!empty($profil['manfaat']))
        $isi++;
      if (!empty($profil['logo']))
        $isi++;

      /* DOKUMEN */
      if (!empty($profil['file_nib']))
        $isi++;
      if (!empty($profil['file_npwp']))
        $isi++;
      if (!empty($profil['file_mou']))
        $isi++;

      /* HITUNG PERSEN */
      $persen = ($isi / $total) * 100;
      $persen = round($persen);

      /* =========================
         WARNA PROGRESS
         ========================= */
      $warna_progress = "progress-bar-danger";
      if ($persen == 100) {
        $warna_progress = "progress-bar-success";
      } elseif ($persen >= 80) {
        $warna_progress = "progress-bar-orange";
      } elseif ($persen >= 50) {
        $warna_progress = "progress-bar-warning";
      }
      ?>

      <!-- Alert Messages (Modern Style) -->
      <?php if ($persen < 100) { ?>
        <div class="alert-modern alert-warning">
          <div class="alert-icon">⚠️</div>
          <div class="alert-content">
            <div class="alert-title">Profil perusahaan belum lengkap!</div>
            <div class="alert-message">Lengkapi profil perusahaan terlebih dahulu sebelum mengajukan verifikasi ke BKK SMKN
              7 Surabaya.</div>
          </div>
        </div>
      <?php } ?>

      <!-- Progress Card (Modern Style) -->
      <div class="progress-card">
        <div class="progress-header">
          <div class="progress-icon">🏢</div>
          <div>
            <div class="progress-title">Kelengkapan Profil Perusahaan</div>
            <div class="progress-subtitle">Lengkapi data untuk meningkatkan kredibilitas</div>
          </div>
        </div>
        <div class="modern-progress">
          <div class="modern-progress-bar" style="width: 0%" data-width="<?php echo $persen; ?>">
            <span class="progress-text"><?php echo $persen; ?>%</span>
          </div>
        </div>
      </div>

      <!-- Tombol Ajukan Verifikasi -->
      <?php if ($persen == 100 && $profil['status_verifikasi'] == "Belum Diverifikasi") { ?>
        <div style="margin-bottom: 25px;">
          <a href="?halaman=proses_ajukan_verifikasi" class="btn btn-success"
            style="border-radius:12px;padding:12px 24px;font-weight:600;box-shadow:0 4px 12px rgba(16, 185, 129, 0.3);">
            <i class="fa fa-send"></i> Ajukan Verifikasi
          </a>
        </div>
      <?php } ?>

      <!-- Info Cards (Modern Style) -->
      <div class="info-cards">


        <!-- Card 1: Lowongan Kerja -->
        <a href="?halaman=loker_tampil" class="info-card info-card-blue">
          <div class="card-icon">💼</div>
          <div class="card-number">
            <?php
            // ✅ FIX: Gunakan tabel dan kolom yang benar
            $id_perusahaan = isset($profil['id_perusahaan']) ? intval($profil['id_perusahaan']) : 0;

            if ($id_perusahaan > 0) {
              // ✅ Tabel: tb_lowongan, Kolom: id_lowongan, id_perusahaan
              $sql_loker = mysqli_query($con, "SELECT COUNT(*) as total FROM tb_lowongan WHERE id_perusahaan='$id_perusahaan'");
              if ($sql_loker) {
                $row_loker = mysqli_fetch_assoc($sql_loker);
                echo $row_loker['total'] ?? 0;
              } else {
                echo "0";
              }
            } else {
              echo "0";
            }
            ?>
          </div>
          <div class="card-label">Lowongan Kerja Aktif</div>
          <div class="card-footer">
            <span class="card-link">
              Selengkapnya
              <i class="fa fa-arrow-circle-right card-arrow"></i>
            </span>
          </div>
        </a>

        <!-- Card 2: Pendaftar 
        <a href="?halaman=pendaftar_tampil" class="info-card info-card-orange">
          <div class="card-icon">👥</div>
          <div class="card-number">
            <?php
            // ✅ FIX: Gunakan tabel dan kolom yang benar
            if ($id_perusahaan > 0) {
              // ✅ Tabel: tb_lamaran (bukan tb_pendaftar)
              // ✅ Join dengan tb_lowongan untuk filter berdasarkan perusahaan
              $sql_pendaftar = mysqli_query($con, "
        SELECT COUNT(*) as total 
        FROM tb_lamaran l
        INNER JOIN tb_lowongan lw ON l.id_lowongan = lw.id_lowongan
        WHERE lw.id_perusahaan='$id_perusahaan'
      ");
              if ($sql_pendaftar) {
                $row_pendaftar = mysqli_fetch_assoc($sql_pendaftar);
                echo $row_pendaftar['total'] ?? 0;
              } else {
                echo "0";
              }
            } else {
              echo "0";
            }
            ?>
          </div>
          <div class="card-label">Total Pendaftar</div>
          <div class="card-footer">
            <span class="card-link">
              Selengkapnya
              <i class="fa fa-arrow-circle-right card-arrow"></i>
            </span>
          </div>
        </a> -->

        <!-- Card 3: Profil Perusahaan -->
        <a href="?halaman=profile#perusahaan" class="info-card info-card-green">
          <div class="card-icon">🏢</div>
          <div class="card-number"><?php echo $persen; ?>%</div>
          <div class="card-label">Kelengkapan Profil</div>
          <div class="card-footer">
            <span class="card-link">
              Kelola Profil
              <i class="fa fa-arrow-circle-right card-arrow"></i>
            </span>
          </div>
        </a>

      </div>

      <!-- Portal BKK Section (Center) -->
      <div class="row">
        <div class="col-md-12">
          <div class="portal-bkk-section">
            <h3 class="portal-title">Portal Bursa Kerja Khusus</h3>
            <h3 class="portal-title portal-title-secondary">SMK Negeri 7 Surabaya</h3>
            <img src="../images/logosmk.png" class="logo-bkk" alt="Logo BKK">
          </div>
        </div>
      </div>

      <!-- Tab Section -->
      <div class="row">
        <section class="col-lg-7 connectedSortable">
          <div class="nav-tabs-custom">
            <!-- Konten tab dapat ditambahkan sesuai kebutuhan -->
          </div>
        </section>
      </div>

    </section>
    <!-- /.content -->

    <script>
      // Animate progress bar on load
      window.addEventListener('load', function () {
        const progressBar = document.querySelector('.modern-progress-bar');
        if (progressBar) {
          const targetWidth = progressBar.getAttribute('data-width');
          setTimeout(() => {
            progressBar.style.width = targetWidth + '%';
          }, 300);
        }
      });
    </script>

  </div>






  <!-- Beranda nya punya Alumni/Siswa-->
  </div>
  <?php
} elseif ($data_status == "siswa") {
  ?>
  <div class="form-group">

    <style>
      /* Modern Dashboard Styling */
      .modern-dashboard {
        padding: 20px 0;
      }

      /* Progress Card Modern */
      .progress-card {
        background: linear-gradient(135deg, #6687ea 0%, #40229c 100%);
        border-radius: 20px;
        padding: 30px;
        color: white;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
      }

      .progress-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
      }

      @keyframes pulse {

        0%,
        100% {
          transform: scale(1);
          opacity: 0.5;
        }

        50% {
          transform: scale(1.1);
          opacity: 0.8;
        }
      }

      .progress-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
      }

      .progress-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 24px;
      }

      .progress-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
      }

      .progress-subtitle {
        font-size: 14px;
        opacity: 0.9;
      }

      .modern-progress {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        height: 30px;
        overflow: hidden;
        position: relative;
        z-index: 1;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      .modern-progress-bar {
        background: linear-gradient(90deg, #fff 0%, #f0f0f0 100%);
        height: 100%;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: #667eea;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }

      .modern-progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
      }

      @keyframes shimmer {
        0% {
          transform: translateX(-100%);
        }

        100% {
          transform: translateX(100%);
        }
      }

      /* Alert Modern */
      .alert-modern {
        border-radius: 15px;
        padding: 20px 25px;
        margin-bottom: 25px;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 15px;
        animation: slideIn 0.5s ease;
      }

      @keyframes slideIn {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .alert-icon {
        font-size: 32px;
      }

      .alert-content {
        flex: 1;
      }

      .alert-title {
        font-weight: 700;
        margin-bottom: 5px;
      }

      .alert-message {
        margin: 0;
        opacity: 0.9;
      }

      .alert-danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
      }

      .alert-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
      }

      /* Info Cards Modern */
      .info-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
      }

      .info-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
      }

      .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--card-gradient);
        transition: height 0.3s ease;
      }

      .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      }

      .info-card:hover::before {
        height: 100%;
        opacity: 0.05;
      }

      .info-card-blue {
        --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }

      .info-card-orange {
        --card-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      }

      .info-card-green {
        --card-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      }

      .card-icon {
        width: 60px;
        height: 60px;
        background: var(--card-gradient);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 20px;
        color: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }

      .card-number {
        font-size: 48px;
        font-weight: 800;
        background: var(--card-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        line-height: 1;
      }

      .card-label {
        font-size: 16px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 20px;
      }

      .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 15px;
        border-top: 2px solid #f1f5f9;
      }

      .card-link {
        color: var(--card-color, #667eea);
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
      }

      .info-card:hover .card-link {
        gap: 12px;
      }

      .card-arrow {
        transition: transform 0.3s ease;
      }

      .info-card:hover .card-arrow {
        transform: translateX(5px);
      }

      /* Responsive */
      @media (max-width: 768px) {
        .info-cards {
          grid-template-columns: 1fr;
        }

        .progress-card {
          padding: 20px;
        }

        .card-number {
          font-size: 36px;
        }
      }

      /* Animation for cards */
      .info-card {
        animation: fadeInUp 0.6s ease backwards;
      }

      .info-card:nth-child(1) {
        animation-delay: 0.1s;
      }

      .info-card:nth-child(2) {
        animation-delay: 0.2s;
      }

      .info-card:nth-child(3) {
        animation-delay: 0.3s;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        🏠 Beranda
        <small>Portal BKK SMK Negeri 7 Surabaya</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content modern-dashboard">

      <?php
      // cek session dulu
      if (!isset($_SESSION['ses_nisn'])) {
        echo "Session NISN tidak ada";
        exit;
      }

      // ambil nisn dari session
      $nisn = $_SESSION['ses_nisn'];

      // ambil data peserta
      $sql_profil = mysqli_query($con, "SELECT * FROM tb_siswa WHERE nisn='$nisn'");
      $profil = mysqli_fetch_assoc($sql_profil);

      $id_siswa = isset($profil['id_siswa']) ? $profil['id_siswa'] : 0;

      // cek tracer
      $sql_tracer = mysqli_query($con, "SELECT * FROM tb_tracer WHERE id_siswa='$id_siswa'");
      $tracer = mysqli_fetch_assoc($sql_tracer);

      $persen = 0;

      // Hitung kriteria profil (total 80%)
      if (!empty($profil['nik']))
        $persen += 10;
      if (!empty($profil['nama']))
        $persen += 10;
      if (!empty($profil['alamat']))
        $persen += 10;
      if (!empty($profil['no_hp']))
        $persen += 10;
      if (!empty($profil['deskripsi']))
        $persen += 10;
      if (!empty($profil['email']))
        $persen += 10;
      if (!empty($profil['status_perkawinan']))
        $persen += 10;
      if (!empty($profil['foto']))
        $persen += 10;

      // Tracer Study (20%)
      if ($tracer && !empty($tracer['id_tracer'])) {
        $persen += 20;
      }

      // Pastikan persentase tidak lebih dari 100
      if ($persen > 100)
        $persen = 100;
      ?>

      <!-- Alert Messages -->
      <?php
      if (!$tracer || empty($tracer['id_tracer'])) {
        ?>
        <div class="alert-modern alert-danger">
          <div class="alert-icon">⚠️</div>
          <div class="alert-content">
            <div class="alert-title">Tracer Study belum diisi!</div>
            <div class="alert-message">Mohon mengisi data tracer study terlebih dahulu untuk mendukung keperluan monitoring dan evaluasi sekolah.</div>
          </div>
        </div>
        <?php
      } elseif ($persen < 100) {
        ?>
        <div class="alert-modern alert-warning">
          <div class="alert-icon">ℹ️</div>
          <div class="alert-content">
            <div class="alert-title">Profil Anda belum lengkap!</div>
            <div class="alert-message">Lengkapi profil hingga <b>100%</b> untuk mendukung keperluan monitoring dan evaluasi sekolah.</div>
          </div>
        </div>
        <?php
      }
      ?>

      <!-- Progress Card -->
      <div class="progress-card">
        <div class="progress-header">
          <div class="progress-icon">👤</div>
          <div>
            <div class="progress-title">Kelengkapan Profil Anda</div>
            <div class="progress-subtitle">Lengkapi data diri untuk meningkatkan peluang</div>
          </div>
        </div>
        <div class="modern-progress">
          <div class="modern-progress-bar" style="width: 0%" data-width="<?php echo $persen; ?>">
            <span class="progress-text"><?php echo $persen; ?>%</span>
          </div>
        </div>
      </div>

      <!-- Info Cards -->
<div class="info-cards">

  <!-- Card 1: Lowongan Kerja -->
  <a href="?halaman=loker" class="info-card info-card-blue">

    <div class="card-icon">💼</div>

    <div class="card-number">
      <?php

      $sql_hitung = "
      SELECT COUNT(id_lowongan) AS total 
      FROM tb_lowongan 
      WHERE LOWER(TRIM(status)) = 'aktif'
      AND (
          batas_lamaran IS NULL 
          OR DATE(batas_lamaran) >= CURDATE()
      )";

      $q_hit = mysqli_query($con, $sql_hitung);

      $row = mysqli_fetch_assoc($q_hit);

      echo $row['total'];

      ?>
    </div>

    <div class="card-label">Informasi Lowongan Kerja</div>

    <div class="card-footer">
      <span class="card-link">
        Selengkapnya
        <i class="fa fa-arrow-circle-right card-arrow"></i>
      </span>
    </div>

  </a>

        <!-- Card 2: Pendaftaran -->
      <!--  <a href="?halaman=pendaftar" class="info-card info-card-orange">
          <div class="card-icon">📋</div>
          <div class="card-number">
            <?php
            $sql_hitung = "SELECT COUNT(id_lamaran) AS total FROM tb_lamaran WHERE id_siswa='$id_siswa'";
            $q_hit = mysqli_query($con, $sql_hitung);
            $row = mysqli_fetch_assoc($q_hit);
            echo $row['total'];
            ?>
          </div>
          <div class="card-label">Tampilan Pendaftaran Anda</div>
          <div class="card-footer">
            <span class="card-link">
              Selengkapnya
              <i class="fa fa-arrow-circle-right card-arrow"></i>
            </span>
          </div>
        </a> -->

        <!-- Card 3: Profil -->
        <a href="?halaman=profile_peserta&id_siswa=<?php echo $id_siswa; ?>" class="info-card info-card-green">
          <div class="card-icon">👨‍🎓</div>
          <div class="card-number">
            <?php
            $sql_hitung = "SELECT COUNT(nisn) AS total FROM tb_siswa WHERE nisn='$nisn'";
            $q_hit = mysqli_query($con, $sql_hitung);
            $row = mysqli_fetch_assoc($q_hit);
            echo $row['total'];
            ?>
          </div>
          <div class="card-label">Profil Anda</div>
          <div class="card-footer">
            <span class="card-link">
              Selengkapnya
              <i class="fa fa-arrow-circle-right card-arrow"></i>
            </span>
          </div>
        </a>
      </div>

    </section>

    <script>
      // Animate progress bar on load
      window.addEventListener('load', function () {
        const progressBar = document.querySelector('.modern-progress-bar');
        const targetWidth = progressBar.getAttribute('data-width');

        setTimeout(() => {
          progressBar.style.width = targetWidth + '%';
        }, 300);
      });
    </script>

  </div>
  <?php
}
?>
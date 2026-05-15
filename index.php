<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>BKK - SMK Negeri 7 Surabaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Portal Bursa Kerja Khusus SMK Negeri 7 Surabaya - Menghubungkan Tamatan Berkualitas dengan Dunia Industri">
  <meta name="author" content="BKK SMKN 7 Surabaya">
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <style>
    :root {
      --primary: #1a56db;
      --primary-dark: #1040a0;
      --primary-light: #eff6ff;
      --secondary: #0f172a;
      --accent: #f59e0b;
      --accent-light: #fef3c7;
      --success: #10b981;
      --danger: #ef4444;
      --light: #f8fafc;
      --gray: #64748b;
      --gray-light: #e2e8f0;
      --dark: #0f172a;
      --white: #ffffff;
      --gradient-primary: linear-gradient(135deg, var(--primary) 0%, #3b82f6 50%, #60a5fa 100%);
      --gradient-dark: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%);
      --gradient-accent: linear-gradient(135deg, var(--accent) 0%, #fbbf24 100%);
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
      --shadow-md: 0 4px 20px rgba(0,0,0,0.1);
      --shadow-lg: 0 10px 40px rgba(0,0,0,0.15);
      --shadow-xl: 0 20px 60px rgba(0,0,0,0.2);
      --radius: 12px;
      --radius-lg: 20px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--dark);
      background: var(--light);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* ===== NAVBAR ===== */
    .navbar-custom {
      background: var(--gradient-dark);
      backdrop-filter: blur(10px);
      padding: 0.75rem 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      transition: var(--transition);
      box-shadow: var(--shadow-md);
    }

    .navbar-custom.scrolled {
      padding: 0.5rem 0;
      background: rgba(15, 23, 42, 0.95);
    }

    .navbar-brand {
      font-weight: 800;
      font-size: 1.25rem;
      color: var(--white) !important;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .navbar-brand i {
      font-size: 1.5rem;
      color: var(--accent);
    }

    .navbar-brand span {
      background: var(--gradient-accent);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .navbar-nav .nav-link {
      color: rgba(255,255,255,0.85) !important;
      font-weight: 500;
      padding: 0.5rem 1rem !important;
      margin: 0 2px;
      border-radius: 8px;
      transition: var(--transition);
      position: relative;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--white) !important;
      background: rgba(255,255,255,0.1);
    }

    .navbar-nav .nav-link.active::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%);
      width: 20px;
      height: 3px;
      background: var(--accent);
      border-radius: 2px;
    }

    .dropdown-menu {
      background: var(--white);
      border: none;
      border-radius: var(--radius);
      box-shadow: var(--shadow-lg);
      padding: 0.5rem 0;
      margin-top: 8px;
      animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-item {
      padding: 0.6rem 1.25rem;
      font-weight: 500;
      color: var(--dark);
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .dropdown-item:hover {
      background: var(--primary-light);
      color: var(--primary);
      padding-left: 1.5rem;
    }

    .dropdown-item i {
      color: var(--primary);
      font-size: 0.9rem;
    }

    .navbar-toggler {
      border: none;
      padding: 0.5rem;
    }

    .navbar-toggler:focus { box-shadow: none; }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .btn-exit {
      background: var(--gradient-accent);
      color: var(--dark) !important;
      font-weight: 700;
      padding: 0.5rem 1.25rem !important;
      border-radius: 50px;
      transition: var(--transition);
      margin-left: 8px;
    }

    .btn-exit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
    }

    /* ===== HERO SECTION ===== */
    #hero {
      min-height: 105vh;
      background: var(--gradient-dark);
      position: relative;
      display: flex;
      align-items: center;
      padding-top: 80px;
      overflow: hidden;
    }

    #hero::before {
      content: '';
      position: absolute;
      top: -30%;
      right: -20%;
      width: 700px;
      height: 700px;
      background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
      border-radius: 50%;
    }

    #hero::after {
      content: '';
      position: absolute;
      bottom: -20%;
      left: -10%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
      border-radius: 50%;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      color: var(--white);
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.15);
      padding: 8px 20px;
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: 500;
      margin-bottom: 24px;
    }

    .hero-badge i { color: var(--accent); }

    .hero-title {
      font-size: clamp(2rem, 4vw, 3.5rem);
      font-weight: 900;
      line-height: 1.15;
      margin-bottom: 16px;
    }

    .hero-title .highlight {
      background: var(--gradient-accent);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
      font-size: clamp(1rem, 2vw, 1.25rem);
      color: rgba(255,255,255,0.8);
      margin-bottom: 32px;
      max-width: 500px;
    }

    .hero-values {
      list-style: none;
      padding: 0;
      margin: 0 0 32px 0;
    }

    .hero-values li {
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
      margin-bottom: 12px;
    }

    .hero-values li .icon {
      width: 32px;
      height: 32px;
      background: rgba(245,158,11,0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .hero-values li .icon i {
      color: var(--accent);
      font-size: 0.85rem;
    }

    .hero-btns {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .btn-hero-primary {
      background: var(--gradient-primary);
      color: var(--white);
      border: none;
      padding: 0.75rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-hero-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 32px rgba(26, 86, 219, 0.4);
      color: var(--white);
    }

    .btn-hero-outline {
      background: transparent;
      color: var(--white);
      border: 2px solid rgba(255,255,255,0.3);
      padding: 0.75rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-hero-outline:hover {
      background: rgba(255,255,255,0.1);
      border-color: var(--white);
    }

    /* FIX BUTTON HERO MOBILE */
.btn-hero-outline,
.btn-hero-primary{
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-align: center;
}

/* MOBILE */
@media (max-width: 767px){

    .hero-btns{
        width: 100%;
    }

    .btn-hero-primary,
    .btn-hero-outline{
        width: 100%;
        padding: 14px 20px;
        font-size: 15px;
    }

    .btn-hero-outline i,
    .btn-hero-primary i{
        font-size: 16px;
    }
}

    .hero-image {
      position: relative;
      z-index: 2;
    }

    .hero-image-card {
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: var(--radius-lg);
      padding: 16px;
      box-shadow: var(--shadow-xl);
    }

    .hero-image-card img {
      width: 100%;
      border-radius: var(--radius);
      height: 350px;
      object-fit: cover;
    }

    /* ===== CONTENT WRAPPER ===== */
    .content-wrapper {
      padding-top: 0;
      min-height: calc(100vh - 80px);
    }

    .container-fluid {
      padding: 0;
    }

    /* ===== FOOTER ===== */
    footer {
      background: var(--gradient-dark);
      color: rgba(255,255,255,0.8);
      padding: 3rem 0 1.5rem;
      margin-top: auto;
    }

    .footer-brand {
      font-weight: 800;
      font-size: 1.25rem;
      color: var(--white);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .footer-brand i { color: var(--accent); }

    .footer-links h6 {
      color: var(--white);
      font-weight: 700;
      margin-bottom: 1rem;
      font-size: 1rem;
    }

    .footer-links a {
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      display: block;
      padding: 0.25rem 0;
      transition: var(--transition);
      font-size: 0.9rem;
    }

    .footer-links a:hover {
      color: var(--accent);
      padding-left: 4px;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,0.1);
      padding-top: 1.5rem;
      margin-top: 2rem;
      text-align: center;
      font-size: 0.85rem;
      color: rgba(255,255,255,0.6);
    }

    .social-links {
      display: flex;
      gap: 12px;
      margin-top: 1rem;
    }

    .social-links a {
      width: 40px;
      height: 40px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      text-decoration: none;
      transition: var(--transition);
    }

    .social-links a:hover {
      background: var(--primary);
      transform: translateY(-3px);
    }

    /* ===== UTILITIES ===== */
    .section-padding { padding: 80px 0; }
    
    .text-gradient {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .bg-gradient-primary { background: var(--gradient-primary); }
    
    .card-modern {
      background: var(--white);
      border: 1px solid var(--gray-light);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
      transition: var(--transition);
      height: 100%;
    }

    .card-modern:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-lg);
      border-color: transparent;
    }

    .btn-primary-custom {
      background: var(--gradient-primary);
      border: none;
      color: var(--white);
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(26, 86, 219, 0.3);
      color: var(--white);
    }

    /* ===== SCROLL TO TOP ===== */
    .scroll-top {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 48px;
      height: 48px;
      background: var(--gradient-primary);
      color: var(--white);
      border: none;
      border-radius: 50%;
      font-size: 1.25rem;
      box-shadow: var(--shadow-md);
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
      z-index: 999;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .scroll-top.active {
      opacity: 1;
      visibility: visible;
    }

    .scroll-top:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
      .navbar-collapse {
        background: var(--secondary);
        padding: 1rem;
        border-radius: var(--radius);
        margin-top: 1rem;
      }
      
      .hero-title { font-size: 2.25rem; }
      .hero-image-card img { height: 280px; }
    }

    @media (max-width: 767px) {
      .hero-title { font-size: 1.75rem; }
      .hero-subtitle { font-size: 1rem; }
      .hero-image-card img { height: 220px; }
      .hero-btns { flex-direction: column; }
      .btn-hero-primary, .btn-hero-outline { width: 100%; justify-content: center; }
      .section-padding { padding: 60px 0; }
    }

    @media (max-width: 575px) {
      .navbar-brand { font-size: 1.1rem; }
      .hero-title { font-size: 1.5rem; }
      .hero-values li { font-size: 0.9rem; }
    }
  </style>
</head>

<body>

  <!-- ======================== NAVBAR ======================== -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="?halaman=beranda">
      <i class="bi bi-briefcase-fill"></i>
      Portal BKK <span>SMKN 7 Surabaya</span>
    </a>

    <!-- Toggle Mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link <?php echo (!isset($_GET['halaman']) || $_GET['halaman']=='beranda') ? 'active' : ''; ?>" href="?halaman=beranda">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['halaman']) && $_GET['halaman']=='struktur') ? 'active' : ''; ?>" href="?halaman=struktur">Struktur Organisasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['halaman']) && $_GET['halaman']=='profil') ? 'active' : ''; ?>" href="?halaman=profil">Profil BKK</a>
        </li>
        
        <!-- Dropdown Informasi 
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownInfo" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Informasi
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownInfo">
            <li><a class="dropdown-item" href="?halaman=loker_tampil"><i class="bi bi-briefcase me-2"></i>Lowongan Kerja</a></li>
            <li><a class="dropdown-item" href="?halaman=info_jadwal"><i class="bi bi-calendar-event me-2"></i>Jadwal Tes</a></li>
            <li><a class="dropdown-item" href="?halaman=info_hasil"><i class="bi bi-clipboard-check me-2"></i>Pengumuman Hasil</a></li>
          </ul>
        </li> -->

       <!-- <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['halaman']) && $_GET['halaman']=='contact') ? 'active' : ''; ?>" href="?halaman=contact">Contact</a>
        </li> -->

        <!-- Dropdown Login -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownLogin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownLogin">
            <li><a class="dropdown-item" href=login_perusahaan.php><i class="bi bi-building me-2"></i>Perusahaan</a></li>
            <li><a class="dropdown-item" href="login_admin.php"><i class="bi bi-shield-lock me-2"></i>Admin/Operator</a></li>
            <li><a class="dropdown-item" href="adminbkk/peserta.php"><i class="bi bi-person-badge me-2"></i>Siswa/Alumni</a></li>
          </ul>
        </li>

        <!-- Exit -->
        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
          <a href="https://smkn7sby.sch.id/" class="btn btn-exit nav-link">Exit</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- ======================== CSS TAMBAHAN ======================== -->
<style>
  /* Fix untuk dropdown mobile */
  @media (max-width: 991px){

    .navbar-collapse{
        position: absolute;
        top: 100%;
        left: 10px;
        right: 10px;

        background: #081226;
        border-radius: 18px;

        padding: 16px;
        margin-top: 10px;

        z-index: 9999;

        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

}
@media (max-width: 991px){

    .navbar .container{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: nowrap;
    }

    .navbar-toggler{
        margin: 0 !important;
        flex-shrink: 0;
    }

}
    .dropdown-menu {
      background: rgba(255,255,255,0.05) !important;
      border: 1px solid rgba(255,255,255,0.1) !important;
      box-shadow: none !important;
      padding: 0;
      margin-top: 0.5rem !important;
    }

    .dropdown-item {
      color: rgba(255,255,255,0.85) !important;
      padding: 0.75rem 1.25rem;
      border-radius: 8px;
      margin: 2px 0;
    }

    .dropdown-item:hover {
      background: rgba(255,255,255,0.1) !important;
      color: #fff !important;
    }

    .dropdown-item i {
      color: var(--accent) !important;
    }

    .nav-item.dropdown.show > .nav-link {
      background: rgba(255,255,255,0.1);
      border-radius: 8px;
    }
  

  /* Desktop dropdown */
  @media (min-width: 992px) {
    .dropdown-menu {
      margin-top: 8px !important;
      animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  }
</style>

<!-- ======================== JAVASCRIPT FIX ======================== -->
<script>
  // Pastikan Bootstrap JS sudah dimuat
  document.addEventListener('DOMContentLoaded', function() {
    // Fix untuk dropdown di mobile - tutup menu setelah klik link
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    dropdownItems.forEach(item => {
      item.addEventListener('click', function() {
        // Tutup mobile menu setelah klik dropdown item
        if (window.innerWidth < 992) {
          const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
          if (bsCollapse) {
            bsCollapse.hide();
          }
        }
      });
    });

    // Prevent dropdown dari menutup terlalu cepat di mobile
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.dropdown-toggle');
      const menu = dropdown.querySelector('.dropdown-menu');
      
      if (toggle && menu && window.innerWidth < 992) {
        toggle.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          // Toggle show class
          const isOpen = dropdown.classList.contains('show');
          
          // Tutup semua dropdown lain
          dropdowns.forEach(d => {
            if (d !== dropdown) {
              d.classList.remove('show');
              d.querySelector('.dropdown-menu')?.classList.remove('show');
            }
          });
          
          // Toggle dropdown ini
          if (!isOpen) {
            dropdown.classList.add('show');
            menu.classList.add('show');
          } else {
            dropdown.classList.remove('show');
            menu.classList.remove('show');
          }
        });
      }
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.dropdown')) {
        dropdowns.forEach(dropdown => {
          dropdown.classList.remove('show');
          dropdown.querySelector('.dropdown-menu')?.classList.remove('show');
        });
      }
    });
  });
</script>
  <!-- ======================== HERO SECTION (Default: Beranda) ======================== -->
  <?php if (!isset($_GET['halaman']) || $_GET['halaman'] == 'beranda'): ?>
  <section id="hero">
    <div class="container">
      <div class="row align-items-center g-4">
        <!-- Left: Text -->
        <div class="col-lg-6 hero-content" data-aos="fade-right" data-aos-duration="800">
          <div class="hero-badge">
            <i class="bi bi-award-fill"></i>
            Bursa Kerja Khusus
          </div>
          <h1 class="hero-title">
            Menghubungkan <span class="highlight">Tamatan Berkualitas</span> dengan Dunia Industri
          </h1>
          <p class="hero-subtitle">
            BKK SMKN 7 Surabaya berkomitmen memberikan pelayanan prima untuk penyaluran tenaga kerja profesional, unggul, dan bermartabat.
          </p>
          
          <ul class="hero-values">
            <li><span class="icon"><i class="bi bi-check-lg"></i></span> Lowongan Kerja Terupdate</li>
            <li><span class="icon"><i class="bi bi-check-lg"></i></span> Kerjasama Dengan Berbagai Perusahaan</li>
            <li><span class="icon"><i class="bi bi-check-lg"></i></span> Pendampingan Karir Profesional</li>
          </ul>

          <div class="hero-btns">
            <a href="adminbkk/peserta.php" class="btn-hero-primary">
              <i class="bi bi-search"></i>Lihat Lowongan
            </a>
            <a href="?halaman=profil" class="btn-hero-outline">
              <i class="bi bi-info-circle"></i>Tentang Kami
            </a>
          </div>
        </div>

        <!-- Right: Image Slider -->
        <div class="col-lg-6 hero-image" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
          <div class="hero-image-card">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="assets/img/slides/BKK.jpg" alt="BKK SMKN 7 Surabaya" />
                </div>
                <div class="carousel-item">
                  <img src="assets/img/slides/smk7sby.jpg" alt="SMKN 7 Surabaya" />
                </div>
                <div class="carousel-item">
                  <img src="assets/img/slides/SMK Bisa Hebat V3.jpg" alt="SMK Vokasi" />
                </div>
                <div class="carousel-item">
                  <img src="assets/img/slides/keunggulan.jpg" alt="Keunggulan" />
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ======================== DYNAMIC CONTENT WRAPPER ======================== -->
  <div class="content-wrapper">
    <div class="container-fluid">
      <?php 
        if(isset($_GET['halaman'])){
            $hal = $_GET['halaman'];
            switch ($hal) {
                case 'beranda':
                    include "beranda.php";
                    break;
                case 'struktur':
                    include "struktur.php";
                    break;
                case 'profil':
                    include "profilbkk.php";
                    break;
                case 'loker_tampil':
                    include "loker_tampil.php";
                    break;
                case 'info_jadwal':
                    include "jadwal_tes.php";
                    break;
                case 'info_hasil':
                    include "kelulusan_tampil.php";
                    break;
                case 'alumnib':
                    include "alumni_bekerja.php";
                    break;
                case 'alumnis':
                    include "alumni_kuliah.php";
                    break;
                case 'alumni':
                    include "lacak_alumni.php";
                    break;
                case 'cari':
                    include "cari.php";
                    break;
                case 'contact':
                    include "contact.php";
                    break;
                case 'reg_peserta':
                    include "reg_peserta.php";
                    break;
                case 'reg_tracer':
                    include "tracer_add.php";
                    break;
                case 'user_add':
                    include "user_add.php";
                    break;
                case 'login':
                    include "login/alumni.php";
                    break;
                case 'alumni_det':
                    include "alumni_detail.php";
                    break;
                case 'lacak':
                    include "lacak.php";
                    break;
                default:
                    echo "<div class='container py-5'><div class='alert alert-danger text-center fw-bold' role='alert'><i class='bi bi-exclamation-triangle me-2'></i>Halaman tidak ditemukan!</div></div>";
                    break;    
            }
        } else {
            include "berandas.php";
        }
      ?>
    </div>
  </div>

  <!-- ======================== FOOTER ======================== -->
  <footer>
    <div class="container">
      <div class="row g-4">
        <!-- Brand -->
        <div class="col-lg-4 col-md-6">
          <div class="footer-brand">
            <i class="bi bi-briefcase-fill"></i>
            BKK SMKN 7 Surabaya
          </div>
          <p class="mb-3" style="font-size: 0.9rem;">
            Lembaga penyaluran tenaga kerja profesional yang menghubungkan tamatan SMK Negeri 7 Surabaya dengan dunia industri.
          </p>
          <div class="social-links">
            <a href="https://www.instagram.com/smkn7sby_official?igsh=bGM1c2txdGo0ZXJq"><i class="bi bi-instagram"></i></a>
            <a href="https://www.facebook.com/share/18rcsbUwg2/"><i class="bi bi-facebook"></i></a>
            <a href="https://smkn7sby.sch.id/"><i class="bi bi-globe me-1"></i></a>
            <a href="https://youtube.com/@smkn7sby_official?si=iVsuHhZ_t3l5JvY-"><i class="bi bi-youtube"></i></a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="col-lg-2 col-md-6 footer-links">
          <h6>Menu</h6>
          <a href="?halaman=beranda"><i class="bi bi-chevron-right me-1"></i> Beranda</a>
          <a href="?halaman=struktur"><i class="bi bi-chevron-right me-1"></i> Struktur BKK</a>
          <a href="?halaman=profil"><i class="bi bi-chevron-right me-1"></i> Profil BKK</a>
        <!--  <a href="?halaman=loker_tampil"><i class="bi bi-chevron-right me-1"></i> Lowongan</a>
          <a href="?halaman=contact"><i class="bi bi-chevron-right me-1"></i> Kontak</a> -->
        </div>

        <!-- Informasi -->
        <div class="col-lg-3 col-md-6 footer-links">
          <h6>Informasi</h6>
        <!--  <a href="?halaman=info_jadwal"><i class="bi bi-chevron-right me-1"></i> Jadwal Tes</a>
          <a href="?halaman=info_hasil"><i class="bi bi-chevron-right me-1"></i> Pengumuman</a> -->
          <a href="login_admin.php"><i class="bi bi-chevron-right me-1"></i> Login Admin</a>
          <a href="login_perusahaan.php"><i class="bi bi-chevron-right me-1"></i> Login Perusahaan</a>
          <a href="/adminbkk/peserta.php"><i class="bi bi-chevron-right me-1"></i> Login Siswa</a>
        </div> 

        <!-- Contact Info -->
        <div class="col-lg-3 col-md-6 footer-links">
          <h6>Kontak</h6>
          <a href="https://maps.google.com/?q=Jl.+Pawiyatan+No.2,+Bubutan,+Surabaya"><i class="bi bi-geo-alt me-1"></i> Jl. Pawiyatan No.2, Bubutan, Kec. Bubutan, Surabaya, Jawa Timur 60174</a>
          <i class="bi bi-telephone me-1"></i> (031) 1234-5678</a>
          <a href="mailto:bkk@smkn7sby.sch.id"><i class="bi bi-envelope me-1"></i> bkk@smkn7sby.sch.id</a>
          <a href="https://smkn7sby.sch.id/" target="_blank"><i class="bi bi-globe me-1"></i> smkn7sby.sch.id</a>
        </div>
      </div>

      <!-- Bottom -->
      <div class="footer-bottom">
        <p class="mb-0">
          &copy; <?php echo date('Y'); ?> <strong>BKK SMK Negeri 7 Surabaya</strong>. All Rights Reserved.
        </p>
      </div>
    </div>
  </footer>

  <!-- Scroll to Top -->
  <button class="scroll-top" id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="bi bi-chevron-up"></i>
  </button>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Init AOS Animation
    AOS.init({ once: true, offset: 80, duration: 600 });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const navbar = document.querySelector('.navbar-custom');
      const scrollTop = document.getElementById('scrollTopBtn');
      
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
      
      if (window.scrollY > 400) {
        scrollTop.classList.add('active');
      } else {
        scrollTop.classList.remove('active');
      }
    });

    // Close mobile menu on link click
    // Close mobile menu hanya untuk link biasa
document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle), .dropdown-item').forEach(link => {

  link.addEventListener('click', () => {

    // hanya di mobile
    if (window.innerWidth < 992) {

      const collapse = document.querySelector('.navbar-collapse');

      if (collapse.classList.contains('show')) {

        const bsCollapse = bootstrap.Collapse.getInstance(collapse);

        if (bsCollapse) {
          bsCollapse.hide();
        }
      }
    }
  });
});

// Fix dropdown mobile Bootstrap
document.addEventListener('DOMContentLoaded', function () {

  // khusus mobile
  if (window.innerWidth < 992) {

    // cegah navbar collapse tertutup saat klik dropdown
    document.querySelectorAll('.dropdown').forEach(function(dropdown) {

      dropdown.addEventListener('hide.bs.dropdown', function (e) {

        if (e.clickEvent && e.clickEvent.target.closest('.dropdown-toggle')) {

          e.preventDefault();

        }
      });

    });

    // tutup navbar hanya saat item dropdown dipilih
    document.querySelectorAll('.dropdown-item').forEach(function(item) {

      item.addEventListener('click', function () {

        const navbarCollapse = document.querySelector('.navbar-collapse');

        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);

        if (bsCollapse) {
          bsCollapse.hide();
        }

      });

    });

  }

});
  </script>

</body>
</html>
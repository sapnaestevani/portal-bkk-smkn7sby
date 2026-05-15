<!-- ======================== STRUKTUR ORGANISASI ======================== -->
<section id="struktur" class="section-padding" style="background: linear-gradient(180deg, var(--light, #f8fafc) 0%, #fff 100%);">
  <div class="container">
    
    <!-- Section Header -->
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="badge bg-primary bg-subtle text-primary px-3 py-2 mb-3">
        <i class="bi bi-diagram-3-fill me-1"></i>Organisasi
      </span>
      <h2 class="fw-bold mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Struktur Organisasi</h2>
      <p class="text-muted mb-0">BKK SMK Negeri 7 Surabaya</p>
    </div>

    <!-- Org Chart Image -->
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="zoom-in" data-aos-duration="800">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden org-card">
          <div class="card-body p-0 org-img-wrapper">
            <img src="assets/img/slides/STOBKK.jpg" alt="Struktur Organisasi BKK SMKN 7 Surabaya" class="img-fluid w-100">
            <div class="org-overlay">
              <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-zoom-in me-1"></i>Klik untuk memperbesar
              </span>
            </div>
          </div>
          <div class="card-footer bg-white border-top-0 text-center py-4">
            <a href="assets/img/slides/STOBKK.jpg" target="_blank" class="btn btn-primary-custom px-4">
              <i class="bi bi-fullscreen me-2"></i>Lihat Gambar Penuh
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Context -->
    <div class="row justify-content-center mt-5">
      <div class="col-lg-9" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-0 bg-primary bg-subtle rounded-4 p-4 p-lg-5">
          <div class="row align-items-center g-4">
            <div class="col-auto d-none d-lg-block">
              <div class="bg-primary text-white rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                <i class="bi bi-people-fill fs-3"></i>
              </div>
            </div>
            <div class="col">
              <h5 class="fw-bold mb-2 mb-lg-3">Koordinasi & Alur Kerja BKK</h5>
              <p class="text-muted mb-0 small lh-lg">
                Struktur organisasi BKK SMKN 7 Surabaya dirancang secara hierarkis dan fungsional untuk memastikan pelayanan ketenagakerjaan berjalan efisien. Mulai dari penanggung jawab utama hingga tim pelaksana yang menangani administrasi, informasi lowongan, penempatan alumni, serta kerjasama dengan Dunia Usaha dan Industri (DU/DI).
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ======================== CSS TAMBAHAN ======================== -->
<style>
  /* Container Gambar */
  .org-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .org-img-wrapper {
    position: relative;
    background: #f1f5f9;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .org-img-wrapper img {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }

  .org-img-wrapper:hover img {
    transform: scale(1.02);
  }

  /* Overlay Hover Effect */
  .org-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
  }

  .org-img-wrapper:hover .org-overlay {
    opacity: 1;
  }

  /* Responsive Adjustments */
  @media (max-width: 767px) {
    .org-img-wrapper {
      min-height: 200px;
    }
    .section-padding {
      padding: 60px 0;
    }
  }
</style>

<!-- ======================== JS INTERACTION ======================== -->
<script>
  // Klik gambar untuk buka full size (UX enhancement)
  document.querySelector('.org-img-wrapper')?.addEventListener('click', function() {
    const imgSrc = this.querySelector('img').src;
    window.open(imgSrc, '_blank', 'noopener,noreferrer');
  });
</script>
<?php
// ✅ 1. Perbaiki path koneksi
include_once __DIR__ . '/../../koneksi.php';

// ✅ 2. Validasi parameter kode
if (!isset($_GET['kode']) || empty($_GET['kode'])) {
    die("<script>alert('Kode lowongan tidak ditemukan!'); window.history.back();</script>");
}

$id_loker = mysqli_real_escape_string($con, $_GET['kode']);

// ✅ 3. Query dengan tabel & kolom yang BENAR
$sql_cek = "SELECT l.*, p.nama_perusahaan 
            FROM tb_lowongan l
            LEFT JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan
            WHERE l.id_lowongan = '$id_loker'";

$query_cek = mysqli_query($con, $sql_cek);

if (!$query_cek) {
    die("<div class='alert alert-danger'>Query Error: " . mysqli_error($con) . "</div>");
}

$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

if (!$data_cek) {
    die("<script>alert('Data lowongan tidak ditemukan di database!'); window.history.back();</script>");
}
?>

<!-- Modern CSS -->
<style>
    .modern-form-container {
        background: linear-gradient(135deg, #f6f6f9 0%, #f3f1f5 100%);
        padding: 40px 20px;
        min-height: 100vh;
        margin-top: -30px;
    }
    
    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #1e156f 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
    }
    
    .modern-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.3;
    }
    
    .modern-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    
    .modern-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }
    
    .modern-body {
        padding: 40px 30px;
    }
    
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #182d89;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title i {
        font-size: 20px;
    }
    
    .form-group-modern {
        margin-bottom: 25px;
    }
    
    .form-label-modern {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-label-modern .required {
        color: #e53e3e;
        margin-left: 2px;
    }
    
    .form-control-modern {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control-modern:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    textarea.form-control-modern {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }
    
    .form-control-readonly {
        background: #edf2f7 !important;
        color: #718096;
        cursor: not-allowed;
    }
    
    .row-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
    }
    
    .btn-modern {
        padding: 12px 30px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #1c0434 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    
    .btn-secondary-modern {
        background: #e2e8f0;
        color: #0c2f6a;
    }
    
    .btn-secondary-modern:hover {
        background: #cbd5e0;
        transform: translateY(-2px);
    }
    
    .input-icon {
        position: relative;
    }
    
    .input-icon i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 16px;
    }
    
    .input-icon .form-control-modern {
        padding-left: 45px;
    }
    
    .help-text {
        font-size: 12px;
        color: #718096;
        margin-top: 5px;
    }
    
    @media (max-width: 768px) {
        .modern-form-container {
            padding: 20px 10px;
        }
        
        .modern-body {
            padding: 25px 20px;
        }
        
        .modern-header h2 {
            font-size: 22px;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn-modern {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .modern-card {
        animation: fadeIn 0.5s ease;
    }
</style>

<!-- Modern Form -->
<div class="modern-form-container">
    <div class="modern-card">
        <!-- Header -->
        <div class="modern-header">
            <h2><i class="fa fa-edit"></i> Ubah Data Lowongan</h2>
            <p>Perbarui informasi lowongan kerja perusahaan Anda</p>
        </div>
        
        <!-- Body -->
        <div class="modern-body">
            <form action="?halaman=loker_aksi" method="post" enctype="multipart/form-data">
                
                <!-- Hidden ID -->
                <input type="hidden" name="txtkode_loker" value="<?php echo htmlspecialchars($data_cek['id_lowongan']); ?>">

                <!-- Section: Informasi Dasar -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fa fa-building"></i>
                        Informasi Dasar
                    </div>
                    
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fa fa-building me-2"></i>Nama Perusahaan
                        </label>
                        <div class="input-icon">
                            <input type="text" class="form-control-modern form-control-readonly" 
                                   value="<?php echo htmlspecialchars($data_cek['nama_perusahaan']); ?>" 
                                   readonly>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            Judul Lowongan <span class="required">*</span>
                        </label>
                        <div class="input-icon">
                            <input type="text" class="form-control-modern" name="txtjudul_lowongan" 
                                   value="<?php echo htmlspecialchars($data_cek['judul_lowongan']); ?>" 
                                   placeholder="Contoh: Staff Administrasi" required>
                            <i class="fa fa-briefcase"></i>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            Jenis Kelamin <span class="required">*</span>
                        </label>
                        <select name="txtjekel" class="form-control-modern" required>
                            <option value="">- Pilih Jenis Kelamin -</option>
                            <option value="Pria" <?php if($data_cek['jekel']=="Pria") echo "selected"; ?>>Pria</option>
                            <option value="Wanita" <?php if($data_cek['jekel']=="Wanita") echo "selected"; ?>>Wanita</option>
                            <option value="Pria/Wanita" <?php if($data_cek['jekel']=="Pria/Wanita") echo "selected"; ?>>Pria/Wanita</option>
                        </select>
                    </div>
                </div>

                <!-- Section: Detail Posisi -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fa fa-info-circle"></i>
                        Detail Posisi
                    </div>
                    
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            Tentang Posisi <small class="text-muted">(Opsional)</small>
                        </label>
                        <textarea class="form-control-modern" name="txtposisi" rows="4" 
                                  placeholder="Jelaskan gambaran umum posisi ini..."><?php echo htmlspecialchars($data_cek['posisi']); ?></textarea>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            Tugas dan Tanggung Jawab <span class="required">*</span>
                        </label>
                        <textarea class="form-control-modern" name="txtdeskripsi" rows="5" 
                                  placeholder="• Tugas 1&#10;• Tugas 2&#10;• Tugas 3" required><?php echo htmlspecialchars($data_cek['deskripsi']); ?></textarea>
                        <div class="help-text">Gunakan bullet points untuk memudahkan pembacaan</div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            Kualifikasi <span class="required">*</span>
                        </label>
                        <textarea class="form-control-modern" name="txtkualifikasi" rows="5" 
                                  placeholder="• Kualifikasi 1&#10;• Kualifikasi 2&#10;• Kualifikasi 3" required><?php echo htmlspecialchars($data_cek['kualifikasi']); ?></textarea>
                    </div>
                </div>

                <!-- Section: Informasi Tambahan -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fa fa-map-marker-alt"></i>
                        Informasi Tambahan
                    </div>
                    
                    <div class="row-modern">
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fa fa-map-pin me-2"></i>Lokasi
                            </label>
                            <textarea class="form-control-modern" name="txtlokasi" rows="3" 
                                      placeholder="Kota, Provinsi"><?php echo htmlspecialchars($data_cek['lokasi']); ?></textarea>
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fa fa-briefcase me-2"></i>Jenis Pekerjaan
                            </label>
                            <textarea class="form-control-modern" name="txtjenis_pekerjaan" rows="3" 
                                      placeholder="Full-time, Part-time, Contract, dll"><?php echo htmlspecialchars($data_cek['jenis_pekerjaan']); ?></textarea>
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fa fa-money-bill-wave me-2"></i>Gaji
                            </label>
                            <input type="text" class="form-control-modern" name="txtgaji" 
                                   value="<?php echo htmlspecialchars($data_cek['gaji']); ?>" 
                                   placeholder="Contoh: Rp 3.000.000 - Rp 5.000.000">
                        </div>
                    </div>
                </div>

                <!-- Section: Tanggal -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fa fa-calendar-alt"></i>
                        Jadwal Posting
                    </div>
                    
                    <div class="row-modern">
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                Tanggal Posting <span class="required">*</span>
                            </label>
                            <input type="date" class="form-control-modern" name="txttanggal_posting" 
                                   value="<?php echo htmlspecialchars($data_cek['tanggal_posting']); ?>" required>
                        </div>
                        
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                Batas Lamaran <span class="required">*</span>
                            </label>
                            <input type="date" class="form-control-modern" name="txtbatas_lamaran" 
                                   value="<?php echo htmlspecialchars($data_cek['batas_lamaran']); ?>" required>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <button type="submit" class="btn-modern btn-primary-modern" name="btnUBAH">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="?halaman=loker_tampil" class="btn-modern btn-secondary-modern">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
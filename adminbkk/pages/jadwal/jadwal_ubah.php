<?php
// Pastikan koneksi tersedia
if (!isset($con)) {
    include_once("koneksi.php");
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek akses
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('Akses ditolak!');window.location='../login.php';</script>";
    exit;
}

// ✅ FIX: Ambil dan sanitasi ID dari GET
$id_jadwal = isset($_GET['kode']) ? intval($_GET['kode']) : 0;

if ($id_jadwal <= 0) {
    echo "<script>alert('❌ ID jadwal tidak valid!');window.location.href='?halaman=jadwal_tampil';</script>";
    exit;
}

// ✅ FIX: Query data dengan field yang sesuai database
$sql_cek = "SELECT * FROM tb_jadwal WHERE id_jadwal = '$id_jadwal'";
$query_cek = mysqli_query($con, $sql_cek);

if (!$query_cek) {
    echo "<script>alert('Error query: ".mysqli_error($con)."');window.history.back();</script>";
    exit;
}

$data_cek = mysqli_fetch_assoc($query_cek);

if (!$data_cek) {
    echo "<script>alert('❌ Data jadwal tidak ditemukan!');window.location.href='?halaman=jadwal_tampil';</script>";
    exit;
}
?>

<style>
    /* Modern Edit Form Styling */
    .edit-form-container {
        max-width: 1600px;
        margin: 40px auto;
        padding: 0 20px;
        animation: fadeIn 0.6s ease;
        margin-top: -10px;
    }
    
    .page-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 35px 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        text-align: center;
    }
    
    .page-header-modern h1 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 10px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    
    .page-header-modern p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }
    
    .modern-form-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    .form-body-modern {
        padding: 36px;
    }
    
    .form-group-modern {
        margin-bottom: 28px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 10px;
        color: #2d3748;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-label i {
        color: #667eea;
        font-size: 16px;
    }
    
    .required {
        color: #ef4444;
        margin-left: 2px;
    }
    
    .form-control-modern {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .form-control-modern:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .form-control-modern:disabled {
        background: #f1f5f9;
        cursor: not-allowed;
        opacity: 0.7;
    }
    
    .form-control-modern::placeholder {
        color: #a0aec0;
    }
    
    textarea.form-control-modern {
        min-height: 100px;
        resize: vertical;
    }
    
    .input-icon-wrapper {
        position: relative;
    }
    
    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }
    
    .input-icon-wrapper .form-control-modern {
        padding-left: 48px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    
    .form-footer {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        padding: 25px 40px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        align-items: center;
    }
    
    .btn-modern {
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }
    
    .btn-secondary-modern {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        color: #4a5568;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        color: #2d3748;
    }
    
    .info-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .readonly-field {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border: 2px solid #cbd5e0;
    }
    
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
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        
        .form-body-modern {
            padding: 25px 20px;
        }
        
        .form-footer {
            flex-direction: column-reverse;
            padding: 20px;
        }
        
        .btn-modern {
            width: 100%;
            justify-content: center;
        }
        
        .page-header-modern h1 {
            font-size: 26px;
        }
    }
</style>

<div class="edit-form-container">
    <div class="page-header-modern">
        <h1><i class="fa fa-calendar-edit"></i> Edit Jadwal Tes</h1>
        <p>Perbarui informasi jadwal tes seleksi</p>
    </div>
    
    <div class="modern-form-card">
        <form action="?halaman=jadwal_aksi" method="POST">
            <!-- Hidden fields untuk proses -->
            <input type="hidden" name="aksi" value="ubah">
            <input type="hidden" name="id_jadwal" value="<?= $data_cek['id_jadwal']; ?>">
            
            <div class="form-body-modern">
                
                <!-- ID Jadwal (Readonly) -->
                <div class="form-group-modern">
                    <label class="form-label">
                        <i class="fa fa-hashtag"></i> ID Jadwal
                    </label>
                    <span class="info-badge">#<?= htmlspecialchars($data_cek['id_jadwal']); ?></span>
                </div>

                <!-- Lowongan (Readonly) -->
                <div class="form-group-modern">
                    <label class="form-label">
                        <i class="fa fa-briefcase"></i> Lowongan
                    </label>
                    <?php
                    // Ambil nama lowongan untuk ditampilkan
                    $sql_loker = mysqli_query($con, "
                        SELECT id_lowongan, judul_lowongan FROM tb_lowongan 
                        WHERE id_lowongan = '".$data_cek['id_lowongan']."'
                    ");
                    $nama_loker = 'Lowongan tidak ditemukan';
                    if ($sql_loker && mysqli_num_rows($sql_loker) > 0) {
                        $loker = mysqli_fetch_assoc($sql_loker);
                        $nama_loker = $loker['judul_lowongan'];
                    }
                    ?>
                    <input type="text" class="form-control-modern readonly-field" 
                           value="<?= htmlspecialchars($nama_loker); ?>" 
                           readonly disabled>
                    <input type="hidden" name="id_lowongan" value="<?= $data_cek['id_lowongan']; ?>">
                    <small style="color: #718096; margin-top: 6px; display: block;">
                        <i class="fa fa-info-circle"></i> Lowongan tidak dapat diubah
                    </small>
                </div>

                <!-- Tanggal dan Waktu (2 kolom) -->
                <div class="form-row">
                    <div class="form-group-modern">
                        <label class="form-label">
                            <i class="fa fa-calendar"></i> Tanggal Tes <span class="required">*</span>
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="fa fa-calendar input-icon"></i>
                            <input type="date" class="form-control-modern" name="tanggal" 
                                   value="<?= htmlspecialchars($data_cek['tanggal']); ?>" required>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label">
                            <i class="fa fa-clock"></i> Waktu <span class="required">*</span>
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="fa fa-clock input-icon"></i>
                            <input type="time" class="form-control-modern" name="waktu" 
                                   value="<?= htmlspecialchars($data_cek['waktu']); ?>" required>
                        </div>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="form-group-modern">
                    <label class="form-label">
                        <i class="fa fa-map-marker-alt"></i> Lokasi/Tempat <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fa fa-map-marker-alt input-icon"></i>
                        <input type="text" class="form-control-modern" name="lokasi" 
                               placeholder="Contoh: Ruang Meeting Lt.2"
                               value="<?= htmlspecialchars($data_cek['lokasi']); ?>" required>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group-modern">
                    <label class="form-label">
                        <i class="fa fa-info-circle"></i> Keterangan
                    </label>
                    <textarea class="form-control-modern" name="keterangan" rows="3" 
                              placeholder="Tambahkan keterangan tambahan jika diperlukan"><?= htmlspecialchars($data_cek['keterangan']); ?></textarea>
                </div>

            </div>
            
            <div class="form-footer">
                <a href="?halaman=jadwal_tampil" class="btn-modern btn-secondary-modern">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="btnUBAH" class="btn-modern btn-primary-modern">
                    <i class="fa fa-save"></i> Update Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
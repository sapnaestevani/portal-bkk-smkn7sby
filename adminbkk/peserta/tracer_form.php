<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("../koneksi.php");

if (!isset($_SESSION["ses_nisn"])) {
    header("Location: ../peserta.php");
    exit;
}

$nisn = $_SESSION["ses_nisn"];

// ✅ Ambil id_siswa dari tb_siswa berdasarkan nisn
$sql_siswa = mysqli_query($con, "SELECT id_siswa FROM tb_siswa WHERE nisn='$nisn'");
$row_siswa = mysqli_fetch_assoc($sql_siswa);
$id_siswa = $row_siswa['id_siswa'] ?? 0;

// ✅ Gunakan id_siswa untuk query tracer
$cek = mysqli_query($con, "SELECT * FROM tb_tracer WHERE id_siswa='$id_siswa'");
$data = mysqli_fetch_assoc($cek);

// ✅ INISIALISASI SEMUA VARIABEL
$status="";
$instansi="";
$jenis="";
$gaji="";
$mulai="";
$pekerjaan="";
$waktu="";
$nama_kampus="";
$jurusan_kuliah="";
$jenjang_pendidikan="";
$status_kampus="";
$sumber_biaya="";
$aktivitas="";
$cara_cari_kerja="";
$kendala="";
$luar_kota="";

if($data){
    $status=$data['status_setelah_lulus'];
    $instansi=$data['nama_instansi'];
    $jenis=$data['jenis_instansi'];
    $gaji=$data['gaji'];
    $mulai=$data['tahun_mulai'];
    $pekerjaan=$data['posisi'];
    $waktu=$data['waktu'];
    $nama_kampus=$data['nama_kampus'] ?? "";
    $jurusan_kuliah=$data['jurusan_kuliah'] ?? "";
    $jenjang_pendidikan=$data['jenjang_pendidikan'] ?? "";
    $status_kampus=$data['status_kampus'] ?? "";
    $sumber_biaya=$data['sumber_biaya'] ?? "";
    $aktivitas=$data['aktivitas'] ?? "";
    $cara_cari_kerja=$data['cara_cari_kerja'] ?? "";
    $kendala=$data['kendala'] ?? "";
    $luar_kota=$data['luar_kota'] ?? "";
}

if(isset($_POST['simpan'])){

    $status = $_POST['status'] ?? "";
    if($status == ""){
        $status = "Belum Bekerja";
    }

    $instansi = $_POST['instansi'] ?? "";
    $jenis = $_POST['jenis'] ?? "";
    $gaji = $_POST['gaji'] ?? "";
    $mulai = $_POST['mulai'] ?? "";
    if(!empty($mulai)){
        $mulai = intval($mulai);
    }
    $pekerjaan = $_POST['pekerjaan'] ?? "";
    $waktu = $_POST['waktu'] ?? "";

    $nama_kampus = $_POST['nama_kampus'] ?? "";
    $jurusan_kuliah = $_POST['jurusan_kuliah'] ?? "";
    $jenjang_pendidikan = $_POST['jenjang_pendidikan'] ?? "";
    $status_kampus = $_POST['status_kampus'] ?? "";
    $sumber_biaya = $_POST['sumber_biaya'] ?? "";

    $aktivitas = $_POST['aktivitas'] ?? "";
    $cara_cari_kerja = $_POST['cara_cari_kerja'] ?? "";
    $kendala = $_POST['kendala'] ?? "";
    $luar_kota = $_POST['luar_kota'] ?? "";

    // ✅ Escape semua input untuk keamanan
    $status_esc = mysqli_real_escape_string($con, $status);
    $instansi_esc = mysqli_real_escape_string($con, $instansi);
    $jenis_esc = mysqli_real_escape_string($con, $jenis);
    $gaji_esc = mysqli_real_escape_string($con, $gaji);
    $pekerjaan_esc = mysqli_real_escape_string($con, $pekerjaan);
    $waktu_esc = mysqli_real_escape_string($con, $waktu);
    $nama_kampus_esc = mysqli_real_escape_string($con, $nama_kampus);
    $jurusan_kuliah_esc = mysqli_real_escape_string($con, $jurusan_kuliah);
    $jenjang_pendidikan_esc = mysqli_real_escape_string($con, $jenjang_pendidikan);
    $status_kampus_esc = mysqli_real_escape_string($con, $status_kampus);
    $sumber_biaya_esc = mysqli_real_escape_string($con, $sumber_biaya);
    $aktivitas_esc = mysqli_real_escape_string($con, $aktivitas);
    $cara_cari_kerja_esc = mysqli_real_escape_string($con, $cara_cari_kerja);
    $kendala_esc = mysqli_real_escape_string($con, $kendala);
    $luar_kota_esc = mysqli_real_escape_string($con, $luar_kota);

    // ✅ Cek apakah data tracer sudah ada
    $cek2 = mysqli_query($con, "SELECT * FROM tb_tracer WHERE id_siswa='$id_siswa'");

    if(mysqli_num_rows($cek2)>0){
        // UPDATE
        $mulai_val = !empty($mulai) ? "'".mysqli_real_escape_string($con, $mulai)."'" : "NULL";
        
        $query = "UPDATE tb_tracer SET
        status_setelah_lulus='$status_esc',
        nama_instansi='$instansi_esc',
        jenis_instansi='$jenis_esc',
        gaji='$gaji_esc',
        tahun_mulai=$mulai_val,
        posisi='$pekerjaan_esc',
        waktu='$waktu_esc',
        nama_kampus='$nama_kampus_esc',
        jurusan_kuliah='$jurusan_kuliah_esc',
        jenjang_pendidikan='$jenjang_pendidikan_esc',
        status_kampus='$status_kampus_esc',
        sumber_biaya='$sumber_biaya_esc',
        aktivitas='$aktivitas_esc',
        cara_cari_kerja='$cara_cari_kerja_esc',
        kendala='$kendala_esc',
        luar_kota='$luar_kota_esc'
        WHERE id_siswa='$id_siswa'";

        mysqli_query($con, $query) or die(mysqli_error($con));

    } else {
        // INSERT
        $mulai_val = !empty($mulai) ? "'".mysqli_real_escape_string($con, $mulai)."'" : "NULL";
        
        $query = "INSERT INTO tb_tracer
        (id_siswa,status_setelah_lulus,nama_instansi,jenis_instansi,gaji,tahun_mulai,posisi,waktu,
        nama_kampus,jurusan_kuliah,jenjang_pendidikan,status_kampus,sumber_biaya,
        aktivitas,cara_cari_kerja,kendala,luar_kota)
        VALUES
        ('$id_siswa','$status_esc','$instansi_esc','$jenis_esc','$gaji_esc',$mulai_val,
        '$pekerjaan_esc','$waktu_esc',
        '$nama_kampus_esc','$jurusan_kuliah_esc','$jenjang_pendidikan_esc','$status_kampus_esc','$sumber_biaya_esc',
        '$aktivitas_esc','$cara_cari_kerja_esc','$kendala_esc','$luar_kota_esc')";

        mysqli_query($con, $query) or die(mysqli_error($con));
    }

    // ✅ Tampilkan alert modern
    ?>
    <div class="alert-overlay alert-success">
        <div class="alert-box">
            <div class="alert-icon">✓</div>
            <div class="alert-title">Berhasil!</div>
            <div class="alert-message">Data tracer berhasil disimpan</div>
            <button class="alert-button" onclick="window.location='?halaman=tracer'">OK</button>
        </div>
    </div>
    <?php
    echo "<meta http-equiv='refresh' content='1.5; url=?halaman=tracer'>";
}
?>

<style>
/* Modern Alert Styling */
.alert-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

.alert-box {
    background: white;
    border-radius: 20px;
    padding: 40px;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
    animation: slideDown 0.4s ease;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.alert-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
}

.alert-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: white;
    animation: scaleIn 0.5s ease 0.2s both;
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
}

.alert-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 10px;
}

.alert-message {
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 30px;
    line-height: 1.6;
}

.alert-button {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
    border: none;
    padding: 14px 40px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.alert-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
}

/* Modern Tracer View Styling */
html, body {
    height:100%;

    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
}

.tracer-wrapper {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.tracer-header {
    background: linear-gradient(135deg, #667eea 0%, #09033e 100%);
    color: white;
    padding: 30px;
    border-radius: 20px 20px 0 0;
    text-align: center;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.tracer-header h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.tracer-header-icon {
    font-size: 32px;
}

.tracer-card {
    background: white;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    margin-bottom: 30px;
}

.tracer-section {
    margin-bottom: 35px;
}

.tracer-section-title {
    font-size: 18px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 3px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 10px;
}

.tracer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.tracer-item {
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.tracer-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
}

.tracer-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tracer-value {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    word-break: break-word;
}

.tracer-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-top: 5px;
}

.form-control {
    color: #333 !important; /* Warna teks gelap */
    background-color: #fff !important; /* Background putih */
}

.form-control, select.form-control {
    font-size: 14px !important;
    line-height: 1.5 !important;
    text-indent: 0 !important; /* Hapus indent negatif */
    opacity: 1 !important; /* Pastikan tidak transparan */
}

/* Fix untuk semua select dropdown */
select.form-control,
.form-control {
    color: #2d3748 !important;
    background-color: #ffffff !important;
    font-size: 14px !important;
    line-height: 1.5 !important;
    padding: 4px 12px !important;
    text-indent: 0 !important;
    opacity: 1 !important;
}

/* Fix untuk options di dalam select */
select.form-control option {
    color: #2d3748 !important;
    background: #ffffff !important;
    padding: 8px 12px !important;
}

/* Placeholder option */
select.form-control option[value=""] {
    color: #a0aec0 !important;
}

.badge-success {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
}

.badge-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.badge-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: white;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #2f0c7a 0%, #0c0331 100%);
    color: white;
    padding: 14px 30px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    border: none;
    cursor: pointer;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
}

/* Form Styling */
.tracer-container {
    max-width: 1450px;
    margin: 10px auto;
    padding: 0 20px;
}

.tracer-form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 30px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.form-section {
    margin-bottom: 30px;
    padding: 25px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 15px;
    border: 2px solid #e5e7eb;
}

.form-section h4 {
    font-size: 16px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
    padding: 14px 30px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #e5e7eb;
    color: #374151;
    padding: 14px 30px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    margin-left: 10px;
}

.btn-cancel:hover {
    background: #d1d5db;
    transform: translateY(-2px);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from { 
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes scaleIn {
    from { 
        opacity: 0;
        transform: scale(0);
    }
    to { 
        opacity: 1;
        transform: scale(1);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .tracer-grid {
        grid-template-columns: 1fr;
    }
    
    .tracer-header h2 {
        font-size: 22px;
    }
    
    .tracer-card, .tracer-form-card {
        padding: 25px;
    }
}
</style>


<?php if($data && !empty($data['status_setelah_lulus']) && !isset($_GET['edit'])){ ?>

<div class="tracer-wrapper">
    <div class="tracer-header">
        <h2>
            <span class="tracer-header-icon">📊</span>
            Data Tracer Study Anda
        </h2>
    </div>
    
    <div class="tracer-card">
        
        <div class="tracer-section">
            <div class="tracer-section-title">
                <span>🎓</span> Informasi Utama
            </div>
            <div class="tracer-grid">
                <div class="tracer-item">
                    <div class="tracer-label">📌 Status Setelah Lulus</div>
                    <div class="tracer-value">
                        <?php 
                        $status_text = htmlspecialchars($data['status_setelah_lulus'] ?? '');
                        $badge_class = 'badge-primary';
                        if(strtolower($status_text) == 'bekerja') $badge_class = 'badge-success';
                        if(strtolower($status_text) == 'belum bekerja') $badge_class = 'badge-warning';
                        ?>
                        <span class="tracer-badge <?php echo $badge_class; ?>"><?php echo $status_text; ?></span>
                    </div>
                </div>

                <?php if(strtolower($data['status_setelah_lulus'] ?? '')=="bekerja"){ ?>
                    <div class="tracer-item">
                        <div class="tracer-label">🏢 Nama Perusahaan</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['nama_instansi'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">🏭 Jenis Perusahaan</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['jenis_instansi'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">💼 Posisi / Jabatan</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['posisi'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">⏱️ Waktu Mendapat Kerja</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['waktu'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">💰 Gaji Pertama</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['gaji'] ?? '-'); ?></div>
                    </div>
                <?php } ?>

                <?php if(($data['status_setelah_lulus'] ?? '')=="Studi"){ ?>
                    <div class="tracer-item">
                        <div class="tracer-label">🎓 Nama Kampus</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['nama_kampus'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">📚 Jurusan Kuliah</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['jurusan_kuliah'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">🎯 Jenjang Pendidikan</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['jenjang_pendidikan'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">🏫 Status Kampus</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['status_kampus'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">💵 Sumber Biaya</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['sumber_biaya'] ?? '-'); ?></div>
                    </div>
                <?php } ?>

                <?php if(isset($data['status_setelah_lulus']) && strtolower($data['status_setelah_lulus'])=="belum bekerja"){ ?>
                    <div class="tracer-item">
                        <div class="tracer-label">📝 Aktivitas Saat Ini</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['aktivitas'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">🔍 Cara Mencari Kerja</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['cara_cari_kerja'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">⚠️ Kendala Mendapat Kerja</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['kendala'] ?? '-'); ?></div>
                    </div>
                    <div class="tracer-item">
                        <div class="tracer-label">🌍 Bersedia Kerja Luar Kota</div>
                        <div class="tracer-value"><?php echo htmlspecialchars($data['luar_kota'] ?? '-'); ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="?halaman=tracer&edit=1" class="btn-edit">
                <span>✏️</span> Edit Data Tracer
            </a>
        </div>
    </div>
</div>

<?php } ?>

<?php if(!$data || isset($_GET['edit'])){ ?>

<div class="tracer-container">
    <div class="tracer-form-card">
        <div class="form-title">
            <span>📝</span> Tracer Study Alumni
        </div>

        <form method="POST">
            <div class="form-section">
                <h4><span>🎓</span> Status Setelah Lulus</h4>
                <div class="form-group">
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Bekerja" <?php if($status=="Bekerja") echo "selected"; ?>>Bekerja</option>
                        <option value="Studi" <?php if($status=="Studi") echo "selected"; ?>>Studi Lanjut</option>
                        <option value="Belum Bekerja" <?php if($status=="Belum Bekerja") echo "selected"; ?>>Belum Bekerja</option>
                    </select>
                </div>
            </div>

            <div id="form_bekerja" class="form-section" style="display:none;">
                <h4><span>💼</span> Data Pekerjaan</h4>
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="instansi" class="form-control" value="<?php echo htmlspecialchars($instansi); ?>" placeholder="Masukkan nama perusahaan">
                </div>

                <div class="form-group">
                    <label>Jenis Perusahaan</label>
                    <select name="jenis" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="BUMN" <?php if($jenis=="BUMN") echo "selected"; ?>>BUMN</option>
                        <option value="Swasta" <?php if($jenis=="Swasta") echo "selected"; ?>>Swasta</option>
                        <option value="Wirausaha" <?php if($jenis=="Wirausaha") echo "selected"; ?>>Wirausaha</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Posisi / Jabatan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="<?php echo htmlspecialchars($pekerjaan); ?>" placeholder="Masukkan posisi/jabatan">
                </div>

                <div class="form-group">
                    <label>Waktu Mendapat Kerja</label>
                    <select name="waktu" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1 Bulan" <?php if($waktu=="1 Bulan") echo "selected"; ?>>1 Bulan</option>
                        <option value="2 Bulan" <?php if($waktu=="2 Bulan") echo "selected"; ?>>2 Bulan</option>
                        <option value="3 Bulan" <?php if($waktu=="3 Bulan") echo "selected"; ?>>3 Bulan</option>
                        <option value=">6 Bulan" <?php if($waktu==">6 Bulan") echo "selected"; ?>>Lebih 6 Bulan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Gaji Pertama</label>
                    <select name="gaji" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="<2.000.000" <?php if($gaji=="<2.000.000") echo "selected"; ?>>&lt; 2.000.000</option>
                        <option value="2.000.000-4.000.000" <?php if($gaji=="2.000.000-4.000.000") echo "selected"; ?>>2.000.000 - 4.000.000</option>
                        <option value=">4.000.000" <?php if($gaji==">4.000.000") echo "selected"; ?>>&gt; 4.000.000</option>
                    </select>
                </div>
            </div>

            <div id="form_studi" class="form-section" style="display:none;">
                <h4><span>🎓</span> Data Studi Lanjut</h4>
                <div class="form-group">
                    <label>Nama Kampus</label>
                    <input type="text" name="nama_kampus" class="form-control" value="<?php echo htmlspecialchars($nama_kampus); ?>" placeholder="Masukkan nama kampus">
                </div>

                <div class="form-group">
                    <label>Jurusan Kuliah</label>
                    <input type="text" name="jurusan_kuliah" class="form-control" value="<?php echo htmlspecialchars($jurusan_kuliah); ?>" placeholder="Masukkan jurusan kuliah">
                </div>

                <div class="form-group">
                    <label>Jenjang Pendidikan</label>
                    <select name="jenjang_pendidikan" class="form-control">
                        <option value="D3" <?php if($jenjang_pendidikan=="D3") echo "selected"; ?>>D3</option>
                        <option value="D4" <?php if($jenjang_pendidikan=="D4") echo "selected"; ?>>D4</option>
                        <option value="S1" <?php if($jenjang_pendidikan=="S1") echo "selected"; ?>>S1</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Kampus</label>
                    <select name="status_kampus" class="form-control">
                        <option value="Perguruan Tinggi Negeri" <?php if($status_kampus=="Perguruan Tinggi Negeri") echo "selected"; ?>>Perguruan Tinggi Negeri</option>
                        <option value="Perguruan Tinggi Swasta" <?php if($status_kampus=="Perguruan Tinggi Swasta") echo "selected"; ?>>Perguruan Tinggi Swasta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sumber Biaya</label>
                    <select name="sumber_biaya" class="form-control">
                        <option value="Mandiri" <?php if($sumber_biaya=="Mandiri") echo "selected"; ?>>Mandiri</option>
                        <option value="Beasiswa" <?php if($sumber_biaya=="Beasiswa") echo "selected"; ?>>Beasiswa</option>
                    </select>
                </div>
            </div>

            <div id="form_belum" class="form-section" style="display:none;">
                <h4><span>📝</span> Aktivitas Alumni</h4>
                <div class="form-group">
                    <label>Aktivitas Saat Ini</label>
                    <select name="aktivitas" class="form-control">
                        <option value="Mencari Kerja" <?php if($aktivitas=="Mencari Kerja") echo "selected"; ?>>Mencari Kerja</option>
                        <option value="Wirausaha" <?php if($aktivitas=="Wirausaha") echo "selected"; ?>>Wirausaha</option>
                        <option value="Kursus" <?php if($aktivitas=="Kursus") echo "selected"; ?>>Kursus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Cara Mencari Kerja</label>
                    <select name="cara_cari_kerja" class="form-control">
                        <option value="Internet" <?php if($cara_cari_kerja=="Internet") echo "selected"; ?>>Internet</option>
                        <option value="BKK Sekolah" <?php if($cara_cari_kerja=="BKK Sekolah") echo "selected"; ?>>BKK Sekolah</option>
                        <option value="Relasi" <?php if($cara_cari_kerja=="Relasi") echo "selected"; ?>>Relasi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kendala Mendapat Kerja</label>
                    <input type="text" name="kendala" class="form-control" value="<?php echo htmlspecialchars($kendala); ?>" placeholder="Masukkan kendala yang dihadapi">
                </div>

                <div class="form-group">
                    <label>Bersedia Kerja Luar Kota</label>
                    <select name="luar_kota" class="form-control">
                        <option value="Ya" <?php if($luar_kota=="Ya") echo "selected"; ?>>Ya</option>
                        <option value="Tidak" <?php if($luar_kota=="Tidak") echo "selected"; ?>>Tidak</option>
                    </select>
                </div>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" name="simpan" class="btn-submit">
                    <span>💾</span> Simpan Data Tracer
                </button>
                <a href="?halaman=tracer" class="btn-cancel">
                    <span>❌</span> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php } ?>

<script>
function tampilForm(){
    var statusEl = document.getElementById("status");
    if(!statusEl) return;

    var s = statusEl.value;

    var bekerja = document.getElementById("form_bekerja");
    var studi = document.getElementById("form_studi");
    var belum = document.getElementById("form_belum");

    if(bekerja) bekerja.style.display="none";
    if(studi) studi.style.display="none";
    if(belum) belum.style.display="none";

    if(s=="Bekerja"){
        if(bekerja) bekerja.style.display="block";
    }
    if(s=="Studi"){
        if(studi) studi.style.display="block";
    }
    if(s=="Belum Bekerja"){
        if(belum) belum.style.display="block";
    }
}

document.addEventListener("DOMContentLoaded", function(){
    var statusEl = document.getElementById("status");
    if(statusEl){
        statusEl.addEventListener("change", tampilForm);
    }
    tampilForm();
});
</script>
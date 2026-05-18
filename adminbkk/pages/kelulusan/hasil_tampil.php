<?php
// Pastikan koneksi tersedia
if (!isset($con)) {
    include_once("koneksi.php");
}

// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek akses - wajib login
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('❌ Session habis! Silakan login ulang.'); window.location.href='../login.php';</script>";
    exit;
}

// Ambil data session
$data_status = isset($_SESSION['ses_level']) ? $_SESSION['ses_level'] : '';
$data_nama = isset($_SESSION['ses_nama']) ? htmlspecialchars($_SESSION['ses_nama']) : '';

// ✅ PENTING: Pastikan variabel ini terisi dari session login
$id_siswa = isset($_SESSION['ses_id_siswa']) ? intval($_SESSION['ses_id_siswa']) : 0;
$id_perusahaan_session = isset($_SESSION['ses_id_perusahaan']) ? intval($_SESSION['ses_id_perusahaan']) : 0;

// DEBUG VISUAL DI LAYAR (Hapus baris ini setelah sistem berjalan normal)
if ($data_status == "siswa") {
    echo "<div style='background:#fff3cd; color:#856404; padding:10px; border:1px solid #ffeeba; margin-bottom:10px;'>";
    echo "<strong>DEBUG MODE:</strong><br>";
    echo "ID Siswa dari Session: <b>" . ($id_siswa > 0 ? $id_siswa : "KOSONG/0") . "</b><br>";

    if ($id_siswa > 0) {
        // Cek lowongan apa saja yang dilamar siswa ini
        $cek_lamaran = mysqli_query($con, "SELECT l.judul_lowongan FROM tb_lamaran lm JOIN tb_lowongan l ON lm.id_lowongan = l.id_lowongan WHERE lm.id_siswa = '$id_siswa'");
        echo "Lowongan yang Dilamar: ";
        if (mysqli_num_rows($cek_lamaran) > 0) {
            while ($lam = mysqli_fetch_assoc($cek_lamaran)) {
                echo "<span class='badge badge-info'>" . $lam['judul_lowongan'] . "</span> ";
            }
        } else {
            echo "<span class='text-danger'>TIDAK ADA LAMARAN TERDAFTAR</span>";
        }
    }
    echo "</div>";
}
?>

<div class="form-group">
    <br>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            

            <?php if ($data_status == "Ka. BKK" || $data_status == "admin"): ?>
              <!--  <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFilter">
                    <i class="fa fa-filter"></i> Filter -->
                </a>
            <?php elseif ($data_status == "perusahaan"): ?>
                
            <?php endif; ?>
        </div>

        <!-- Modal Filter (Admin/Ka. BKK) -->
        <?php if ($data_status == "Ka. BKK" || $data_status == "admin"): ?>
       <?php endif; ?>

<style>
    /* Modern Results Styling */
    .results-container {
        padding: 20px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        animation: fadeIn 0.6s ease;
        margin-top: -35px;
    }
    
    .page-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 35px 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .page-title h1 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .page-title p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }
    
    .btn-filter-modern {
        background: white;
        color: #667eea;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-filter-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        color: #764ba2;
    }
    
    .modern-table-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    .table-responsive-modern {
        overflow-x: auto;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    
    .modern-table thead {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
    }
    
    .modern-table thead th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 700;
        color: #2d3748;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        border-bottom: 2px solid #cbd5e0;
        white-space: nowrap;
    }
    
    .modern-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:last-child {
        border-bottom: none;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        transform: scale(1.005);
    }
    
    .modern-table tbody td {
        padding: 16px 20px;
        color: #4a5568;
        font-size: 14px;
        border: none;
        vertical-align: middle;
    }
    
    .result-id {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
    }
    
    .company-name {
        font-weight: 600;
        color: #2d3748;
    }
    
    .job-title {
        color: #667eea;
        font-weight: 600;
    }
    
    .result-date {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    
    .keterangan-text {
        color: #64748b;
        font-size: 13px;
    }
    
    .btn-download-modern {
        background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
    }
    
    .btn-download-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        color: white;
    }
    
    .action-buttons-modern {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }
    
    .btn-action-modern {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        font-size: 14px;
    }
    
    .btn-edit-modern {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .btn-delete-modern {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .btn-action-modern:hover {
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        color: white;
    }
    
    .badge-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-lulus {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    .badge-tidak-lulus {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }
    
    .empty-state-modern i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .dataTables_wrapper {
        padding: 20px;
    }
    
    .dataTables_filter input {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 16px;
        margin-left: 10px;
        transition: all 0.3s ease;
    }
    
    .dataTables_filter input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 3px;
        border: none !important;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
        color: #2d3748 !important;
        transition: all 0.3s ease;
        padding: 8px 14px !important;
    }
    
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
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
        .page-header-modern {
            flex-direction: column;
            text-align: center;
        }
        
        .page-title h1 {
            justify-content: center;
            font-size: 26px;
        }
        
        .modern-table {
            font-size: 12px;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 15px;
        }
        
        .action-buttons-modern {
            flex-direction: column;
        }
        
        .btn-action-modern {
            width: 100%;
        }
    }

    /* =========================================
   MODAL TAMBAH PENGUMUMAN RESPONSIVE
========================================= */

#modalTambah .modal-dialog{
    width:92% !important;
    max-width:650px !important;

    margin:85px auto 30px auto !important;

    animation:modalFade .3s ease;
}

/* MODAL CONTENT */
#modalTambah .modal-content{
    border:none !important;
    border-radius:22px !important;
    overflow:hidden !important;

    box-shadow:0 10px 35px rgba(0,0,0,0.25) !important;
}

/* HEADER */
#modalTambah .modal-header{
    position:relative !important;

    background:linear-gradient(135deg,#667eea 0%,#764ba2 100%) !important;

    padding:24px 28px !important;

    display:flex !important;
    align-items:center !important;
    justify-content:center !important;

    border:none !important;
}

/* TITLE */
#modalTambah .modal-header h4{
    width:100% !important;

    margin:0 !important;

    text-align:center !important;

    color:#fff !important;

    font-size:28px !important;
    font-weight:700 !important;

    line-height:1.3 !important;
}

/* CLOSE BUTTON */
#modalTambah .modal-header .close{
    position:absolute !important;

    right:22px !important;
    top:12% !important;

    transform:translateY(-50%) !important;

    margin:0 !important;

    color:#fff !important;

    opacity:1 !important;

    font-size:34px !important;

    text-shadow:none !important;
}

/* BODY */
#modalTambah .modal-body{
    padding:28px !important;
    background:#fff !important;
}

/* FORM */
#modalTambah .form-group{
    margin-bottom:22px !important;
}

#modalTambah label{
    font-size:16px !important;
    font-weight:700 !important;
    color:#333 !important;
    margin-bottom:10px !important;
}

/* INPUT */
#modalTambah .form-control{
    height:52px !important;

    border-radius:14px !important;

    border:1px solid #dcdfe6 !important;

    font-size:16px !important;

    box-shadow:none !important;
}

/* TEXTAREA */
#modalTambah textarea.form-control{
    height:110px !important;
    resize:none !important;
    padding-top:14px !important;
}

/* FOCUS */
#modalTambah .form-control:focus{
    border-color:#667eea !important;

    box-shadow:0 0 0 4px rgba(102,126,234,0.12) !important;
}

/* FOOTER */
#modalTambah .modal-footer{
    border:none !important;

    padding:20px 28px 28px !important;

    display:flex !important;
    justify-content:flex-end !important;
    gap:12px !important;

    flex-wrap:wrap !important;
}

/* BUTTON */
#modalTambah .btn{
    min-width:120px !important;

    height:48px !important;

    border-radius:12px !important;

    font-size:15px !important;
    font-weight:600 !important;
}

/* MOBILE */
@media (max-width:768px){

    #modalTambah .modal-dialog{
        width:94% !important;

        margin:120px auto 20px auto !important;
    }

    #modalTambah .modal-header{
        padding:22px 18px !important;
    }

    #modalTambah .modal-header h4{
        font-size:22px !important;
    }

    #modalTambah .modal-header .close{
        right:4px !important;
        top:-24px;
        font-size:30px !important;
    }

    #modalTambah .modal-body{
        padding:22px 18px !important;
    }

    #modalTambah .form-control{
        font-size:15px !important;
    }

    #modalTambah .modal-footer{
        justify-content:center !important;
    }

    #modalTambah .btn{
        width:100% !important;
    }

}

/* ANIMATION */
@keyframes modalFade{
    from{
        opacity:0;
        transform:translateY(25px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}
</style>

<div class="results-container">
    <div class="page-header-modern">
        <div class="page-title">
            <h1>
                <i class="fa fa-award"></i>
                <?php
                if ($data_status == "Ka. BKK" || $data_status == "admin") {
                    echo "Hasil Kelulusan Semua Perusahaan";
                } elseif ($data_status == "perusahaan") {
                    echo "Pengumuman Kelulusan - " . htmlspecialchars($data_nama);
                } else {
                    echo "Pengumuman Kelulusan Saya";
                }
                ?>
            </h1>
            <p>Informasi hasil seleksi dan kelulusan peserta</p>
        </div>
        
        <?php if ($data_status == "Ka. BKK" || $data_status == "admin"): ?>
            <button type="button" class="btn-filter-modern" data-toggle="modal" data-target="#modalFilter">
                <i class="fa fa-filter"></i> Filter
            </button>
        <?php elseif ($data_status == "perusahaan"): ?>
            <button type="button" class="btn-filter-modern" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah Pengumuman
            </button>
        <?php endif; ?>
    </div>
    
    <div class="modern-table-card">
        <div class="table-responsive-modern">
            <table id="example1" class="modern-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>ID</th>
                        <th>Perusahaan</th>
                        <th>Lowongan</th>
                        <th>Tanggal</th>
                        <th>File Pengumuman</th>
                        <th>Keterangan</th>
                        <?php if ($data_status != "siswa"): ?>
                            <th width="12%">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;

                    // ✅ QUERY BERDASARKAN ROLE
                    
                    // ADMIN & KA. BKK: Lihat SEMUA pengumuman
                    if ($data_status == "Ka. BKK" || $data_status == "admin") {
                        $where = "1=1";
                        if (isset($_GET['txtket']) && !empty($_GET['txtket'])) {
                            $where .= " AND k.keterangan = '" . mysqli_real_escape_string($con, $_GET['txtket']) . "'";
                        }
                        $sql = "
                            SELECT k.*, p.nama_perusahaan, l.judul_lowongan 
                            FROM tb_kelulusan k 
                            JOIN tb_lowongan l ON k.id_lowongan = l.id_lowongan 
                            JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan 
                            WHERE $where 
                            ORDER BY k.id_kelulusan DESC, k.tanggal_pengumuman DESC
                        ";

                        // PERUSAHAAN: Hanya lihat pengumuman milik sendiri
                    } elseif ($data_status == "perusahaan" && $id_perusahaan_session > 0) {
                        $sql = "
                            SELECT k.*, p.nama_perusahaan, l.judul_lowongan 
                            FROM tb_kelulusan k 
                            JOIN tb_lowongan l ON k.id_lowongan = l.id_lowongan 
                            JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan 
                            WHERE p.id_perusahaan = '$id_perusahaan_session' 
                            ORDER BY k.id_kelulusan DESC, k.tanggal_pengumuman DESC
                        ";

                        // SISWA: HANYA lihat pengumuman untuk lowongan YANG DILAMAR
                    } elseif ($data_status == "siswa" && $id_siswa > 0) {
                        $sql = "
                            SELECT k.*, p.nama_perusahaan, l.judul_lowongan 
                            FROM tb_kelulusan k 
                            INNER JOIN tb_lowongan l ON k.id_lowongan = l.id_lowongan 
                            INNER JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan 
                            WHERE k.id_lowongan IN (
                                SELECT id_lowongan 
                                FROM tb_lamaran 
                                WHERE id_siswa = '$id_siswa'
                            )
                            ORDER BY k.id_kelulusan DESC, k.tanggal_pengumuman DESC
                        ";
                    } else {
                        $sql = "SELECT * FROM tb_kelulusan WHERE 1=0";
                    }

                    $query = mysqli_query($con, $sql);

                    if (!$query) {
                        echo "<tr><td colspan='8' class='text-danger text-center'>Error Query: " . htmlspecialchars(mysqli_error($con)) . "</td></tr>";
                    } elseif (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='8'>";
                        echo "<div class='empty-state-modern'>";
                        echo "<i class='fa fa-inbox'></i>";
                        if ($data_status == "siswa") {
                            echo "<h4>📭 Belum ada pengumuman untuk lowongan yang Anda lamar.</h4>";
                        } else {
                            echo "<h4>📭 Belum ada data hasil kelulusan.</h4>";
                        }
                        echo "</div></td></tr>";
                    } else {
                        while ($d = mysqli_fetch_assoc($query)) {
                            // Tentukan class badge berdasarkan keterangan
                            $keterangan_lower = strtolower($d['keterangan'] ?? '');
                            $badge_class = '';
                            if (strpos($keterangan_lower, 'lulus') !== false && strpos($keterangan_lower, 'tidak') === false) {
                                $badge_class = 'badge-lulus';
                            } else {
                                $badge_class = 'badge-tidak-lulus';
                            }
                    ?>
                    <tr>
                        <td class="text-center"><strong><?= $no++; ?></strong></td>
                        <td><span class="result-id">#<?= htmlspecialchars($d['id_kelulusan']); ?></span></td>
                        <td><span class="company-name"><?= htmlspecialchars($d['nama_perusahaan']); ?></span></td>
                        <td><span class="job-title"><?= htmlspecialchars($d['judul_lowongan']); ?></span></td>
                        <td>
                            <?php if ($d['tanggal_pengumuman']): ?>
                                <span class="result-date">
                                    <i class="fa fa-calendar"></i> <?= date('d-m-Y', strtotime($d['tanggal_pengumuman'])); ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($d['berkas'])):
                                $file_path = "pages/kelulusan/terupload/" . $d['berkas'];
                                if (file_exists($file_path)): ?>
                                    <a href="<?= htmlspecialchars($file_path); ?>" target="_blank" class="btn-download-modern">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"><i class="fa fa-exclamation-triangle"></i> File hilang</span>
                                <?php endif;
                            else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($d['keterangan'])): ?>
                                <span class="badge-status <?= $badge_class; ?>">
                                    <?= htmlspecialchars($d['keterangan']); ?>
                                </span>
                            <?php else: ?>
                                <span class="keterangan-text">-</span>
                            <?php endif; ?>
                        </td>
                        <?php if ($data_status != "siswa"): ?>
                        <td>
                            <div class="action-buttons-modern">
                                <a href="?halaman=hasil_ubah&kode=<?= $d['id_kelulusan']; ?>" 
                                   class="btn-action-modern btn-edit-modern" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="?halaman=hasil_aksi&aksi=hapus&kode=<?= $d['id_kelulusan']; ?>" 
                                   onclick="return confirm('⚠️ Yakin hapus data ini?')"
                                   class="btn-action-modern btn-delete-modern" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Filter dan Tambah tetap sama seperti kode sebelumnya -->
<?php if ($data_status == "Ka. BKK" || $data_status == "admin"): ?>
<!-- Modal Filter -->
<div id="modalFilter" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white"><i class="fa fa-filter"></i> Filter Keterangan</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="GET">
                    <input type="hidden" name="halaman" value="hasil_tampil">
                    <div class="form-group">
                        <label>Pilih Keterangan</label>
                        <select class="form-control" name="txtket">
                            <option value="">- Semua Keterangan -</option>
                            <?php
                            $sql_ket = mysqli_query($con, "SELECT DISTINCT keterangan FROM tb_kelulusan WHERE keterangan IS NOT NULL ORDER BY keterangan");
                            while ($k = mysqli_fetch_assoc($sql_ket)) {
                                $sel = (isset($_GET['txtket']) && $_GET['txtket'] == $k['keterangan']) ? 'selected' : '';
                                echo '<option value="'.htmlspecialchars($k['keterangan']).'" '.$sel.'>'.htmlspecialchars($k['keterangan']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        <?php if (isset($_GET['txtket']) && !empty($_GET['txtket'])): ?>
                            <a href="?halaman=hasil_tampil" class="btn btn-default">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($data_status == "perusahaan"): ?>
<!-- Modal Tambah -->
<div id="modalTambah" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="?halaman=hasil_tambah_per" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white"><i class="fa fa-plus"></i> Tambah Pengumuman</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Lowongan Kerja <span class="text-danger">*</span></label>
                        <select name="txtlowongan" class="form-control" required>
                            <option value="">- Pilih Lowongan -</option>
                            <?php
                            $sql_loker = mysqli_query($con, "SELECT id_lowongan, judul_lowongan FROM tb_lowongan WHERE id_perusahaan = '$id_perusahaan_session' AND status = 'aktif' ORDER BY judul_lowongan ASC");
                            while ($l = mysqli_fetch_assoc($sql_loker)) {
                                echo '<option value="'.$l['id_lowongan'].'">'.htmlspecialchars($l['judul_lowongan']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File Pengumuman <span class="text-danger">*</span></label>
                        <input type="file" name="berkas" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Lulus, Tidak Lulus"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pengumuman <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pengumuman" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- DataTables Script -->
<script>
$(document).ready(function() {
    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().destroy();
    }
    
    if ($.fn.DataTable) {
        $('#example1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
            'language': {
                'search': '🔍 Cari:',
                'lengthMenu': 'Tampilkan _MENU_ data',
                'info': 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                'paginate': { 'first': '«', 'last': '»', 'next': '›', 'previous': '‹' },
                'zeroRecords': 'Tidak ada data ditemukan',
                'emptyTable': 'Tidak ada data tersedia'
            }
        });
    }
});
</script>

<!-- Modal Tambah (Khusus Perusahaan) -->
<?php if ($data_status == "perusahaan"): ?>
    <div id="modalTambah" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="?halaman=hasil_tambah_per" method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                        <h4 class="text-white"><i class="fa fa-plus"></i> Tambah Pengumuman Kelulusan</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Lowongan Kerja <span class="text-danger">*</span></label>
                            <select name="txtlowongan" class="form-control" required>
                                <option value="">- Pilih Lowongan -</option>
                                <?php
                                $sql_loker = mysqli_query($con, "
                                SELECT id_lowongan, judul_lowongan 
                                FROM tb_lowongan 
                                WHERE id_perusahaan = '$id_perusahaan_session' 
                                AND status = 'aktif' 
                                ORDER BY judul_lowongan ASC
                            ");
                                if ($sql_loker && mysqli_num_rows($sql_loker) > 0) {
                                    while ($l = mysqli_fetch_assoc($sql_loker)) {
                                        echo "<option value='" . $l['id_lowongan'] . "'>" . htmlspecialchars($l['judul_lowongan']) . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Tidak ada lowongan aktif</option>";
                                }
                                ?>
                            </select>
                            <small class="text-muted">Pengumuman ini hanya akan terlihat oleh siswa yang melamar lowongan
                                ini.</small>
                        </div>
                        <div class="form-group">
                            <label>File Pengumuman <span class="text-danger">*</span></label>
                            <input type="file" name="berkas" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png"
                                required>
                            <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"
                                placeholder="Contoh: Lulus, Tidak Lulus, dll"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengumuman <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengumuman" class="form-control" value="<?= date('Y-m-d'); ?>"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#example1')) $('#example1').DataTable().destroy();
        $('#example1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
            'pageLength': 10,
            'language': {
                'search': '🔍 Cari:',
                'lengthMenu': 'Tampilkan _MENU_ data',
                'info': 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                'paginate': { 'first': '«', 'last': '»', 'next': '›', 'previous': '‹' },
                'zeroRecords': '🔍 Tidak ada data yang cocok',
                'emptyTable': '📭 Tidak ada data tersedia'
            }
        });
    });
</script>
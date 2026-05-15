<?php
include_once("koneksi.php");

// ✅ FIX: Cek session sebelum akses
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ambil data user dengan validasi
$data_status = isset($_SESSION['ses_level']) ? $_SESSION['ses_level'] : '';
$nisn_siswa = isset($_SESSION['ses_nisn']) ? mysqli_real_escape_string($con, $_SESSION['ses_nisn']) : '';
$id_perusahaan = isset($_SESSION['ses_id_perusahaan']) ? intval($_SESSION['ses_id_perusahaan']) : 0;
?>

<style>
    /* Modern Schedule Styling */
    .schedule-container {
        padding: 30px -15px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        animation: fadeIn 0.6s ease;
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
    
    .btn-modern-primary {
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
    
    .btn-modern-primary:hover {
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
    
    .schedule-id {
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
    
    .schedule-date {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    
    .schedule-time {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    
    .location-text {
        color: #64748b;
        font-size: 13px;
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
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
    }
    
    .btn-delete-modern {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);
    }
    
    .btn-action-modern:hover {
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        color: white;
    }
    
    /* Modal Modern */
    .modal-modern .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }
    
    .modal-modern .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        border: none;
    }
    
    .modal-modern .modal-title {
        font-weight: 700;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .modal-modern .close {
        color: white;
        opacity: 1;
        text-shadow: none;
        font-size: 28px;
    }
    
    .modal-modern .modal-body {
        padding: 30px;
    }
    
    .modal-modern .form-group {
        margin-bottom: 22px;
    }
    
    .modal-modern label {
        display: block;
        margin-bottom: 8px;
        color: #2d3748;
        font-weight: 600;
        font-size: 14px;
    }
    
    .modal-modern .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .modal-modern .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .modal-modern .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    
    .btn-modal-cancel {
        background: #e2e8f0;
        color: #4a5568;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-modal-cancel:hover {
        background: #cbd5e0;
    }
    
    .btn-modal-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .btn-modal-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
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

    /* =====================================================
   RESPONSIVE ALL DEVICE
===================================================== */
@media (max-width: 992px) {

  .schedule-container {
    padding: 9px !important;
  }

  .page-header-modern {
    flex-direction: column !important;
    align-items: stretch !important;
    text-align: center !important;
    padding: 25px 20px !important;
    border-radius: 18px !important;
    gap: 18px !important;
  }

  .page-title h1 {
    justify-content: center !important;
    font-size: 24px !important;
    line-height: 1.4;
    flex-wrap: wrap;
  }

  .page-title p {
    font-size: 13px !important;
  }

  .btn-modern-primary {
    width: 100% !important;
    justify-content: center !important;
    min-height: 48px !important;
    font-size: 14px !important;
  }

  .modern-table-card {
    border-radius: 18px !important;
    overflow: hidden !important;
  }

  .table-responsive-modern {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
  }

  .modern-table {
    min-width: 1000px !important;
  }

  .modern-table thead th {
    padding: 14px 12px !important;
    font-size: 12px !important;
    white-space: nowrap !important;
  }

  .modern-table tbody td {
    padding: 14px 12px !important;
    font-size: 12px !important;
    white-space: nowrap !important;
  }

  .schedule-id,
  .schedule-date,
  .schedule-time {
    font-size: 11px !important;
    padding: 5px 10px !important;
  }

  .company-name,
  .job-title,
  .location-text {
    font-size: 12px !important;
    line-height: 1.5;
  }

  .action-buttons-modern {
    flex-direction: row !important;
    justify-content: center !important;
    gap: 6px !important;
  }

  .btn-action-modern {
    width: 34px !important;
    height: 34px !important;
    font-size: 13px !important;
  }

  /* MODAL */
  .modal-dialog {
    width: 95% !important;
    margin: 15px auto !important;
  }

  .modal-modern .modal-content {
    border-radius: 18px !important;
  }

  .modal-modern .modal-header {
    padding: 20px !important;
  }

  .modal-modern .modal-title {
    font-size: 18px !important;
    line-height: 1.5;
  }

  .modal-modern .modal-body {
    padding: 20px !important;
    max-height: 75vh !important;
    overflow-y: auto !important;
  }

  .modal-modern .modal-footer {
    flex-direction: column !important;
    gap: 10px !important;
    padding: 20px !important;
  }

  .btn-modal-save,
  .btn-modal-cancel {
    width: 100% !important;
    min-height: 46px !important;
    justify-content: center !important;
    display: flex !important;
    align-items: center !important;
  }

  .modal-modern .form-control {
    min-height: 46px !important;
    font-size: 14px !important;
  }

  textarea.form-control {
    min-height: 90px !important;
  }

  /* DATATABLE */
  .dataTables_wrapper {
    padding: 12px !important;
  }

  .dataTables_length,
  .dataTables_filter,
  .dataTables_info,
  .dataTables_paginate {
    text-align: center !important;
    float: none !important;
    margin-bottom: 10px !important;
  }

  .dataTables_filter input {
    width: 100% !important;
    margin-left: 0 !important;
    margin-top: 8px !important;
  }

  .dataTables_paginate .paginate_button {
    padding: 6px 12px !important;
    font-size: 12px !important;
  }

  /* EMPTY STATE */
  .empty-state-modern {
    padding: 40px 15px !important;
  }

  .empty-state-modern i {
    font-size: 48px !important;
  }

  .empty-state-modern h4 {
    font-size: 16px !important;
    line-height: 1.5;
  }
}

/* EXTRA SMALL DEVICE */
@media (max-width: 576px) {

  .page-title h1 {
    font-size: 20px !important;
  }

  .modern-table {
    min-width: 900px !important;
  }

  .schedule-container {
    padding: 10px !important;
  }

  .page-header-modern {
    padding: 20px 15px !important;
  }

  .modal-modern .modal-body {
    padding: 15px !important;
  }

  .modal-modern .modal-header {
    padding: 18px 15px !important;
  }

  .modal-modern .modal-footer {
    padding: 15px !important;
  }
}

</style>
<div class="schedule-container">
    <div class="page-header-modern">
        <div class="page-title">
            <h1><i class="fa fa-calendar-alt"></i> Jadwal Tes Seleksi</h1>
            <p>Kelola jadwal tes seleksi penerimaan karyawan</p>
        </div>
        
        <?php if ($data_status == "perusahaan"): ?>
            <button type="button" class="btn-modern-primary" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus"></i> Tambah Jadwal
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
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Kegiatan</th>
                        <th>Keterangan</th>
                        <?php if ($data_status != "siswa"): ?>
                            <th width="12%">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    
                    // ==================== QUERY BERDASARKAN ROLE ====================
                    
                    // ✅ ADMIN & KA. BKK: Lihat SEMUA jadwal
                    if ($data_status == "admin" || $data_status == "Ka. BKK") {
                        $sql = "
                            SELECT 
                                j.id_jadwal,
                                j.tanggal,
                                j.waktu,
                                j.lokasi,
                                j.judul_kegiatan,
                                j.keterangan,
                                j.status,
                                p.nama_perusahaan,
                                l.judul_lowongan
                            FROM tb_jadwal j
                            INNER JOIN tb_lowongan l ON j.id_lowongan = l.id_lowongan
                            INNER JOIN tb_perusahaan p ON j.id_perusahaan = p.id_perusahaan
                            WHERE j.status != 'dibatalkan'
                            ORDER BY j.tanggal DESC, j.waktu DESC
                        ";
                        
                    // ✅ PERUSAHAAN: Hanya lihat jadwal MILIK SENDIRI
                    } elseif ($data_status == "perusahaan" && $id_perusahaan > 0) {
                        $sql = "
                            SELECT 
                                j.id_jadwal,
                                j.tanggal,
                                j.waktu,
                                j.lokasi,
                                j.judul_kegiatan,
                                j.keterangan,
                                j.status,
                                p.nama_perusahaan,
                                l.judul_lowongan
                            FROM tb_jadwal j
                            INNER JOIN tb_lowongan l ON j.id_lowongan = l.id_lowongan
                            INNER JOIN tb_perusahaan p ON j.id_perusahaan = p.id_perusahaan
                            WHERE j.id_perusahaan = '$id_perusahaan'
                            AND j.status != 'dibatalkan'
                            ORDER BY j.tanggal DESC, j.waktu DESC
                        ";
                        
                    // ✅ SISWA: Hanya lihat jadwal untuk lowongan yang DILAMAR
                    } elseif ($data_status == "siswa" && !empty($nisn_siswa)) {
                        $sql = "
                            SELECT DISTINCT
                                j.id_jadwal,
                                j.tanggal,
                                j.waktu,
                                j.lokasi,
                                j.judul_kegiatan,
                                j.keterangan,
                                j.status,
                                p.nama_perusahaan,
                                l.judul_lowongan
                            FROM tb_jadwal j
                            INNER JOIN tb_lamaran lm ON j.id_lamaran = lm.id_lamaran
                            INNER JOIN tb_lowongan l ON lm.id_lowongan = l.id_lowongan
                            INNER JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan
                            WHERE lm.nisn = '$nisn_siswa'
                            AND j.status != 'dibatalkan'
                            ORDER BY j.tanggal DESC, j.waktu DESC
                        ";
                        
                    } else {
                        // Default: query kosong untuk role tidak valid
                        $sql = "SELECT * FROM tb_jadwal WHERE 1=0";
                    }
                    
                    $query = mysqli_query($con, $sql);
                    
                    if (!$query) {
                        echo "<tr><td colspan='10' class='text-danger text-center'>Error: " . htmlspecialchars(mysqli_error($con)) . "</td></tr>";
                    } elseif (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='10'>";
                        echo "<div class='empty-state-modern'>";
                        echo "<i class='fa fa-calendar-times'></i>";
                        if ($data_status == "siswa") {
                            echo "<h4>📭 Belum ada jadwal untuk lowongan yang Anda lamar.</h4>";
                        } else {
                            echo "<h4>📭 Belum ada jadwal tes.</h4>";
                        }
                        echo "</div></td></tr>";
                    } else {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td class="text-center"><strong><?= $no++; ?></strong></td>
                        <td><span class="schedule-id">#<?= htmlspecialchars($data['id_jadwal']); ?></span></td>
                        <td><span class="company-name"><?= htmlspecialchars($data['nama_perusahaan']); ?></span></td>
                        <td><span class="job-title"><?= htmlspecialchars($data['judul_lowongan']); ?></span></td>
                        <td><span class="schedule-date"><i class="fa fa-calendar"></i> <?= date('d-m-Y', strtotime($data['tanggal'])); ?></span></td>
                        <td><span class="schedule-time"><i class="fa fa-clock"></i> <?= date('H:i', strtotime($data['waktu'])); ?> WIB</span></td>
                        <td><span class="location-text"><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($data['lokasi']); ?></span></td>
                        <td><span class="location-text"><i class="fa fa-calendar-check"></i> <?= htmlspecialchars($data['judul_kegiatan']); ?></span></td>
                        <td><?= htmlspecialchars($data['keterangan']); ?></td>
                        
                        <?php if ($data_status != "siswa"): ?>
                        <td>
                            <div class="action-buttons-modern">
                                <a href="?halaman=jadwal_ubah&kode=<?= $data['id_jadwal']; ?>" 
                                   class="btn-action-modern btn-edit-modern" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="?halaman=jadwal_aksi&aksi=hapus&kode=<?= $data['id_jadwal']; ?>" 
                                   onclick="return confirm('⚠️ Yakin hapus jadwal ini?')"
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

<!-- ==================== MODAL TAMBAH JADWAL (Hanya untuk Perusahaan) ==================== -->
<?php if ($data_status == "perusahaan"): ?>
<div id="myModal" class="modal fade modal-modern" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="?halaman=jadwal_tambah" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-calendar-plus"></i> Input Jadwal Tes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><i class="fa fa-briefcase"></i> Lowongan Kerja <span class="text-danger">*</span></label>
                        <select name="txtlowongan" class="form-control" required>
                            <option value="">- Pilih Lowongan -</option>
                            <?php
                            $sql_loker = mysqli_query($con, "
                                SELECT id_lowongan, judul_lowongan 
                                FROM tb_lowongan 
                                WHERE id_perusahaan = '$id_perusahaan' 
                                AND status = 'aktif'
                                ORDER BY judul_lowongan ASC
                            ");
                            if ($sql_loker) {
                                while ($loker = mysqli_fetch_assoc($sql_loker)) {
                                    echo '<option value="'.$loker['id_lowongan'].'">'
                                        .htmlspecialchars($loker['judul_lowongan']).'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-clock"></i> Waktu <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="waktu" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fa fa-map-marker-alt"></i> Lokasi/Tempat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="lokasi" 
                               placeholder="Contoh: Ruang Meeting Lt.2" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fa fa-calendar-check"></i> Kegiatan</label>
                        <textarea class="form-control" name="judul_kegiatan" rows="2" placeholder="Contoh: Interview"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fa fa-info-circle"></i> Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2" placeholder="Masukkan keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" name="btnSimpan" class="btn-modal-save">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- DataTables Script dengan Anti-Duplikasi -->
<script>
$(document).ready(function() {
    // Destroy existing DataTable to prevent duplication error
    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().destroy();
    }
    
    // Initialize DataTable
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
                'paginate': {
                    'first': '«',
                    'last': '»',
                    'next': '›',
                    'previous': '‹'
                },
                'zeroRecords': 'Tidak ada data ditemukan',
                'emptyTable': 'Tidak ada data tersedia'
            }
        });
    }
});
</script>
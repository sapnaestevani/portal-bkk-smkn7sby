<?php
// 1. Pastikan koneksi tersedia
if (!isset($con)) {
    include_once("../koneksi.php");
}

// 2. Session Handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Cek Akses: Wajib Login
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('❌ Session habis! Silakan login ulang.'); window.location.href='../login.php';</script>";
    exit;
}

// 4. Ambil ID Siswa dari Session
// PASTIKAN di file login.php Anda ada baris: $_SESSION['ses_id_siswa'] = $row['id_siswa'];
$id_siswa = isset($_SESSION['ses_id_siswa']) ? intval($_SESSION['ses_id_siswa']) : 0;
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .modern-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e5e6e7 100%);
        padding: 30px 20px;
        min-height: calc(100vh - 100px);
        margin-top: -20px;
    }
    
    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .modern-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .header-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        backdrop-filter: blur(10px);
    }
    
    .header-title h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }
    
    .header-title p {
        margin: 5px 0 0 0;
        font-size: 14px;
        opacity: 0.9;
        font-weight: 400;
    }
    
    .modern-body {
        padding: 30px;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ecf1 100%);
        color: #2d3748;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 18px 15px;
        border: none;
        text-align: left;
    }
    
    .modern-table thead th:first-child {
        border-radius: 12px 0 0 0;
    }
    
    .modern-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    }
    
    .modern-table tbody td {
        padding: 20px 15px;
        border-bottom: 1px solid #e8ecf1;
        color: #555;
        font-size: 14px;
        vertical-align: middle;
    }
    
    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-lulus {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
    }
    
    .status-tidak-lulus {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);
    }
    
    .btn-download-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .btn-download-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #888;
    }
    
    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ecf1 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 50px;
    }
    
    .empty-state h3 {
        color: #2d3748;
        margin: 0 0 10px 0;
        font-size: 22px;
        font-weight: 700;
    }
    
    .empty-state p {
        color: #777;
        font-size: 14px;
        margin: 0;
    }
    
    .id-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
    }
    
    .company-name {
        font-weight: 600;
        color: #2d3748;
    }
    
    .job-title {
        color: #555;
        font-weight: 500;
    }
    
    .date-text {
        color: #777;
        font-size: 13px;
    }
    
    .dataTables_wrapper {
        margin-top: 20px;
    }
    
    .dataTables_filter input {
        border: 2px solid #e8ecf1;
        border-radius: 10px;
        padding: 8px 15px;
        margin-left: 10px;
        transition: all 0.3s;
    }
    
    .dataTables_filter input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .dataTables_length select {
        border: 2px solid #e8ecf1;
        border-radius: 10px;
        padding: 8px 15px;
        margin-right: 10px;
    }
    
    @media (max-width: 768px) {
        .modern-header {
            padding: 20px;
        }
        
        .header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .modern-body {
            padding: 20px;
            overflow-x: auto;
        }
        
        .modern-table {
            min-width: 800px;
        }
    }
</style>

<div class="modern-container">
    <div class="modern-card">
        <div class="modern-header">
            <div class="header-content">
                <div class="header-icon">
    <i class="fa fa-graduation-cap"></i>
</div>
                <div class="header-title">
                    <h2>Hasil Kelulusan Saya</h2>
                    <p>Lihat hasil seleksi dari perusahaan yang Anda lamar</p>
                </div>
            </div>
        </div>
        
        <div class="modern-body">
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;

                    // Query hanya jika ID siswa valid
                    if ($id_siswa > 0) {
                        $sql_tampil = "
                            SELECT 
                                k.id_kelulusan,
                                p.nama_perusahaan,
                                l.judul_lowongan,
                                k.berkas,
                                k.keterangan,
                                k.tanggal_pengumuman
                            FROM tb_kelulusan k
                            JOIN tb_lowongan l ON k.id_lowongan = l.id_lowongan
                            JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan
                            WHERE k.id_lowongan IN (
                                SELECT id_lowongan 
                                FROM tb_lamaran 
                                WHERE id_siswa = '$id_siswa'
                            )
                            ORDER BY k.id_kelulusan DESC
                        ";
                    } else {
                        $sql_tampil = "SELECT * FROM tb_kelulusan WHERE 1=0";
                    }

                    $query_tampil = mysqli_query($con, $sql_tampil);

                    if (!$query_tampil) {
                        echo "<tr><td colspan='7' class='text-center py-5'>
                                <div class='empty-state'>
                                    <div class='empty-state-icon'>❌</div>
                                    <h3>Error Query</h3>
                                    <p>" . htmlspecialchars(mysqli_error($con)) . "</p>
                                </div>
                              </td></tr>";
                    } elseif (mysqli_num_rows($query_tampil) == 0) {
                        echo "<tr><td colspan='7'>
                                <div class='empty-state'>
                                    <div class='empty-state-icon'>📭</div>
                                    <h3>Belum Ada Pengumuman</h3>
                                    <p>Belum ada pengumuman untuk lowongan yang Anda lamar.</p>
                                </div>
                              </td></tr>";
                    } else {
                        while ($data = mysqli_fetch_assoc($query_tampil)) {
                            // Tentukan class dan icon untuk status
                            $status_class = '';
                            $status_icon = '';
                            $status_text = htmlspecialchars($data['keterangan'] ?? '-');
                            
                            if (stripos($status_text, 'lulus') !== false && stripos($status_text, 'tidak') === false) {
                                $status_class = 'status-lulus';
                                $status_icon = '✅';
                            } else {
                                $status_class = 'status-tidak-lulus';
                                $status_icon = '';
                            }
                        ?>
                        <tr>
                            <td class="text-center"><strong><?= $no++; ?></strong></td>
                            <td><span class="id-badge">#<?= htmlspecialchars($data['id_kelulusan']); ?></span></td>
                            <td><span class="company-name"><?= htmlspecialchars($data['nama_perusahaan']); ?></span></td>
                            <td><span class="job-title"><?= htmlspecialchars($data['judul_lowongan']); ?></span></td>
                            <td><span class="date-text"><?= !empty($data['tanggal_pengumuman']) ? date('d-m-Y', strtotime($data['tanggal_pengumuman'])) : '-'; ?></span></td>
                            <td>
                                <?php if (!empty($data['berkas'])): 
                                    $file_path = "../pages/kelulusan/terupload/" . $data['berkas'];
                                    if (file_exists($file_path)): ?>
                                        <a href="<?= htmlspecialchars($file_path); ?>" target="_blank" class="btn-download-modern">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #fa709a; font-weight: 600;">⚠️ File hilang</span>
                                    <?php endif; 
                                else: ?>
                                    <span style="color: #999;">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge <?= $status_class; ?>">
                                    <?= $status_icon; ?> <?= $status_text; ?>
                                </span>
                            </td>
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

<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().destroy();
    }
    
    $('#example1').DataTable({
        'paging': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'responsive': true,
        'pageLength': 10,
        'language': {
            'search': '🔍 Cari:',
            'lengthMenu': 'Tampilkan _MENU_ data',
            'zeroRecords': '😕 Tidak ada data ditemukan',
            'emptyTable': '📭 Tidak ada data tersedia',
            'info': 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            'infoEmpty': 'Menampilkan 0 data',
            'infoFiltered': '(difilter dari _MAX_ total data)',
            'paginate': {
                'first': '️ Pertama',
                'last': '⏭️ Terakhir',
                'next': '▶️',
                'previous': '◀️'
            }
        }
    });
});
</script>
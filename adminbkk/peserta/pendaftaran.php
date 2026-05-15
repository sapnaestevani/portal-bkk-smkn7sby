<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("../koneksi.php");

// ✅ Ambil nisn dari session dengan validasi
$data_nisn = isset($_SESSION["ses_nisn"]) ? mysqli_real_escape_string($con, $_SESSION["ses_nisn"]) : '';

if (empty($data_nisn)) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='../login.php';</script>";
    exit;
}
?>

<style>
    /* Modern Card Design */
    .modern-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 20px 0;
        border: none;
    }

    .modern-header {
        background: linear-gradient(135deg, #0b184f 0%, #7472ea 100%);
        color: white;
        padding: 30px;
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

    .modern-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .modern-header .subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 5px;
        position: relative;
        z-index: 1;
    }

    .modern-body {
        padding: 30px;
    }

    /* Modern Table */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .modern-table thead th {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        color: #2d3748;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 15px;
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
        background: white;
        transition: all 0.3s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8faff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    }

    .modern-table tbody td {
        padding: 18px 15px;
        border-bottom: 1px solid #e8ecf1;
        vertical-align: middle;
        font-size: 14px;
        color: #4a5568;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Modern Badges */
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-diproses {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #92400e;
    }

    .status-diterima {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        color: #065f46;
    }

    .status-ditolak {
        background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
        color: #991b1b;
    }

    .status-dibatalkan {
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
        color: #374151;
    }

    .status-panggilan-wawancara {
        background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        color: #1e3a8a;
    }

    /* Modern Buttons */
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .btn-download {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
    }

    .btn-batalkan {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-jadwal {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h4 {
        color: #6b7280;
        margin: 10px 0;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-table {
            font-size: 12px;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 8px;
        }
        
        .btn-modern {
            padding: 8px 12px;
            font-size: 11px;
        }
        
        .status-badge {
            padding: 6px 12px;
            font-size: 10px;
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

    .form-group{
        margin-top: -15px;
    }
</style>

<div class="form-group">
    <div class="modern-card">
        <div class="modern-header">
            <h3>📋 Riwayat Lamaran Kerja</h3>
            <div class="subtitle">Pantau status lamaran pekerjaan Anda di sini</div>
        </div>

        <div class="modern-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Lowongan</th>
                            <th>Nama Perusahaan</th>
                            <th>NISN</th>
                            <th>Lowongan</th>
                            <th>Berkas</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ✅ Query dengan sanitasi dan join yang benar
                        $sql_tampil = "
                            SELECT 
                                l.id_lamaran,
                                l.id_lowongan,
                                l.cv,
                                l.status,
                                p.nama_perusahaan,
                                s.nisn,
                                lw.judul_lowongan
                            FROM tb_lamaran l
                            JOIN tb_lowongan lw ON l.id_lowongan = lw.id_lowongan
                            JOIN tb_perusahaan p ON lw.id_perusahaan = p.id_perusahaan
                            JOIN tb_siswa s ON l.id_siswa = s.id_siswa
                            WHERE s.nisn = '$data_nisn'
                            ORDER BY l.created_at DESC
                        ";
                        
                        $query_tampil = mysqli_query($con, $sql_tampil);
                        
                        if (!$query_tampil) {
                            echo "<tr><td colspan='8' class='text-danger'>Error Query: " . mysqli_error($con) . "</td></tr>";
                        } elseif (mysqli_num_rows($query_tampil) == 0) {
                            ?>
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📭</div>
                                        <h4>Belum Ada Lamaran</h4>
                                        <p>Anda belum mengirim lamaran pekerjaan. Yuk, mulai cari lowongan yang sesuai!</p>
                                        <a href="?halaman=loker" class="btn-modern btn-download" style="margin-top: 20px;">
                                            <i class="fa fa-briefcase"></i> Cari Lowongan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        } else {
                            $no = 1;
                            while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
                                // Tentukan class status
                                $status_class = '';
                                $status_text = $data['status'];
                                
                                switch($data['status']) {
                                    case 'Diproses':
                                        $status_class = 'status-diproses';
                                        break;
                                    case 'Diterima':
                                        $status_class = 'status-diterima';
                                        break;
                                    case 'Ditolak':
                                        $status_class = 'status-ditolak';
                                        break;
                                    case 'Dibatalkan':
                                        $status_class = 'status-dibatalkan';
                                        break;
                                    case 'Panggilan Wawancara':
                                        $status_class = 'status-panggilan-wawancara';
                                        break;
                                    default:
                                        $status_class = 'status-diproses';
                                }
                                ?>
                                <tr>
                                    <td><strong><?php echo $no++; ?></strong></td>
                                    <td><span style="font-family: monospace; background: #f1f5f9; padding: 4px 8px; border-radius: 6px;"><?php echo htmlspecialchars($data['id_lowongan']); ?></span></td>
                                    <td><strong><?php echo htmlspecialchars($data['nama_perusahaan']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($data['nisn']); ?></td>
                                    <td><?php echo htmlspecialchars($data['judul_lowongan']); ?></td>
                                    <td>
                                        <?php 
                                        if (!empty($data['cv'])) {
                                            echo '<a href="../pages/pendaftar/upload/' . htmlspecialchars($data['cv']) . '" target="_blank" class="btn-modern btn-download">
                                                    <i class="fa fa-download"></i> Download
                                                  </a>';
                                        } else {
                                            echo '<span class="text-muted">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                        // ✅ Logika tombol berdasarkan status
                                        if ($data['status'] == 'Diproses') { 
                                            ?>
                                            <a href="index_pst.php?halaman=batal_lamaran&id=<?php echo $data['id_lamaran']; ?>"
                                                class="btn-modern btn-batalkan"
                                                onclick="return confirm('Yakin ingin membatalkan lamaran ini?')">
                                                <i class="fa fa-times"></i> Batalkan
                                            </a>
                                            <?php 
                                        } elseif ($data['status'] == 'Panggilan Wawancara') { 
                                            ?>
                                            <a href="index_pst.php?halaman=jadwal&id_lamaran=<?php echo $data['id_lamaran']; ?>"
                                                class="btn-modern btn-jadwal"
                                                title="Lihat Jadwal Wawancara">
                                                <i class="fa fa-calendar"></i> Lihat Jadwal
                                            </a>
                                            <?php 
                                        } elseif ($data['status'] == 'Diterima') { 
                                            ?>
                                            <span class="status-badge status-diterima">
                                                <i class="fa fa-check-circle"></i> Selamat!
                                            </span>
                                            <?php 
                                        } elseif ($data['status'] == 'Ditolak') { 
                                            ?>
                                            <span class="status-badge status-ditolak">
                                                <i class="fa fa-times-circle"></i> Ditolak
                                            </span>
                                            <?php 
                                        } elseif ($data['status'] == 'Dibatalkan') { 
                                            ?>
                                            <span class="status-badge status-dibatalkan">
                                                <i class="fa fa-ban"></i> Dibatalkan
                                            </span>
                                            <?php 
                                        }
                                        ?>
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
</div>
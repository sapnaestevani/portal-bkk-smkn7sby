<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("koneksi.php");

// Validasi parameter
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

if (empty($kode)) {
    echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
    exit;
}

// Query data tracer + siswa
$sql = "SELECT 
            t.*,
            s.nama,
            s.nisn,
            s.jurusan,
            s.tahun_lulus,
            s.jekel,
            s.foto
        FROM tb_tracer t
        INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
        WHERE t.id_tracer = '$kode'
        LIMIT 1";

$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.history.back();</script>";
    exit;
}

$data = mysqli_fetch_assoc($result);

// ✅ AMBIL ID SISWA UNTUK QUERY DATA PROFIL
$id_siswa = $data['id_siswa'] ?? 0;

// ✅ QUERY DATA LENGKAP SISWA
$sql_siswa = "SELECT * FROM tb_siswa WHERE id_siswa = '$id_siswa' LIMIT 1";
$result_siswa = mysqli_query($con, $sql_siswa);
$data_siswa = ($result_siswa && mysqli_num_rows($result_siswa) > 0) ? mysqli_fetch_assoc($result_siswa) : null;

// ✅ QUERY DATA KELUARGA
$sql_keluarga = "SELECT * FROM tb_keluarga WHERE id_siswa = '$id_siswa'";
$result_keluarga = mysqli_query($con, $sql_keluarga);
$data_keluarga = [];
if ($result_keluarga) {
    while ($row = mysqli_fetch_assoc($result_keluarga)) {
        $data_keluarga[] = $row;
    }
}

// ✅ QUERY DATA SOSIAL MEDIA
$sql_sosmed = "SELECT * FROM tb_sosial_media WHERE id_user IN (SELECT id_user FROM tb_siswa WHERE id_siswa = '$id_siswa')";
$result_sosmed = mysqli_query($con, $sql_sosmed);
$data_sosmed = [];
if ($result_sosmed) {
    while ($row = mysqli_fetch_assoc($result_sosmed)) {
        $data_sosmed[] = $row;
    }
}

// ✅ QUERY DATA DOKUMEN
$sql_dokumen = "SELECT * FROM tb_dokumen WHERE id_siswa = '$id_siswa' LIMIT 1";
$result_dokumen = mysqli_query($con, $sql_dokumen);
$data_dokumen = ($result_dokumen && mysqli_num_rows($result_dokumen) > 0) ? mysqli_fetch_assoc($result_dokumen) : null;

// ✅ QUERY DATA PENDIDIKAN
$sql_pendidikan = "SELECT * FROM tb_pendidikan WHERE id_siswa = '$id_siswa' ORDER BY tgl_selesai DESC";
$result_pendidikan = mysqli_query($con, $sql_pendidikan);
$data_pendidikan = [];
if ($result_pendidikan) {
    while ($row = mysqli_fetch_assoc($result_pendidikan)) {
        $data_pendidikan[] = $row;
    }
}

// Tentukan badge color berdasarkan status
$status_badge = [
    'Bekerja' => 'success',
    'Studi' => 'info',
    'Belum Bekerja' => 'warning'
];
$status_color = $status_badge[$data['status_setelah_lulus']] ?? 'secondary';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Alumni - <?= htmlspecialchars($data['nama']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ✅ FIX: Reset margin/padding untuk mencegah konflik dengan portal */
        .detail-standalone-wrapper {
            all: initial;
            display: block;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .detail-standalone-wrapper * {
            box-sizing: border-box;
        }

        /* ✅ FIX: Pastikan container tidak terpengaruh sidebar portal */
        .detail-standalone-wrapper .container {
            max-width: 3000px;
            margin: 0 auto !important;
            padding: 10px !important;
            position: relative !important;
            z-index: 1 !important;
            background: transparent !important;
        }

        /* ✅ FIX: Override style portal yang mungkin bentrok */
        .detail-standalone-wrapper body {
            margin: 0 !important;
            padding: 0 !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            min-height: 100vh !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        /* ✅ FIX: Hide portal elements jika ada yang ikut ter-render */
        .detail-standalone-wrapper .main-sidebar,
        .detail-standalone-wrapper .main-header,
        .detail-standalone-wrapper .control-sidebar,
        .detail-standalone-wrapper .content-wrapper>*:not(.container) {
            display: none !important;
        }

        /* Original Styles - Tetap sama seperti kode Anda */
        .page-header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: -20px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
            font-size: 32px;
            color: #667eea;
        }

        .page-title h1 {
            font-size: 28px;
            color: #2d3748;
            font-weight: 700;
        }

        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 60px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            /* ✅ Support background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .profile-avatar i {
            transition: opacity 0.3s;
        }

        .profile-avatar[style*="background-image"] i {
            opacity: 0;
        }

        .profile-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .profile-nisn {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .profile-status {
            display: inline-block;
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }

        .content-section {
            padding: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #667eea;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
        }

        .info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }

        .info-label {
            font-size: 13px;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label i {
            color: #667eea;
            font-size: 16px;
        }

        .info-value {
            font-size: 16px;
            color: #2d3748;
            font-weight: 600;
            word-break: break-word;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-badge.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .status-badge.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .status-badge.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            padding: 30px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top: 2px solid #e2e8f0;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 87, 108, 0.4);
        }

        .btn-close {
            background: linear-gradient(135deg, #434343 0%, #000000 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                text-align: center;
            }

            .page-title h1 {
                font-size: 24px;
            }

            .profile-header {
                padding: 30px 20px;
            }

            .profile-name {
                font-size: 24px;
            }

            .content-section {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
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

        .main-card {
            animation: fadeIn 0.6s ease-out;
        }

        /* Tambahkan di bagian <style> */
        .empty-state-message {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px dashed #f59e0b;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            color: #92400e;
            font-size: 15px;
        }

        .empty-state-message i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    <!-- ✅ WRAPPER: Mencegah konflik dengan layout portal -->
    <div class="detail-standalone-wrapper">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <i class="fa fa-user-graduate"></i>
                    <h1>Detail Alumni</h1>
                </div>
                <a href="javascript:history.back()" class="btn-back">
                    <i class="fa fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Main Card -->
            <div class="main-card">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-avatar"
                        style="background-image: url('<?= !empty($data_siswa['foto']) ? 'peserta/foto/' . htmlspecialchars($data_siswa['foto']) : 'dist/img/pegawai.png'; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <?php if (empty($data_siswa['foto'])): ?>
                            <i class="fa fa-user"></i>
                        <?php endif; ?>
                    </div>
                    <h2 class="profile-name"><?= htmlspecialchars($data['nama']); ?></h2>
                    <p class="profile-nisn">
                        <i class="fa fa-id-card"></i> NISN: <?= htmlspecialchars($data['nisn']); ?>
                    </p>
                    <span class="profile-status">
                        <i
                            class="fa fa-<?= $data['status_setelah_lulus'] == 'Bekerja' ? 'briefcase' : ($data['status_setelah_lulus'] == 'Studi' ? 'graduation-cap' : 'clock'); ?>"></i>
                        <?= htmlspecialchars($data['status_setelah_lulus']); ?>
                    </span>
                </div>

                <!-- Personal Information -->
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-user-circle"></i>
                        Informasi Pribadi
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-hashtag"></i> ID Tracer
                            </div>
                            <div class="info-value">#<?= htmlspecialchars($data['id_tracer']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-id-card"></i> NISN
                            </div>
                            <div class="info-value"><?= htmlspecialchars($data['nisn']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-user"></i> Nama Lengkap
                            </div>
                            <div class="info-value"><?= htmlspecialchars($data['nama']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-<?= $data['jekel'] == 'Laki-laki' ? 'mars' : 'venus'; ?>"></i> Jenis
                                Kelamin
                            </div>
                            <div class="info-value"><?= htmlspecialchars($data['jekel']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-graduation-cap"></i> Jurusan Sekolah
                            </div>
                            <div class="info-value"><?= htmlspecialchars($data['jurusan']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-calendar"></i> Tahun Lulus
                            </div>
                            <div class="info-value"><?= htmlspecialchars($data['tahun_lulus']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa fa-chart-line"></i> Status Setelah Lulus
                            </div>
                            <div class="info-value">
                                <span class="status-badge <?= $status_color; ?>">
                                    <i
                                        class="fa fa-<?= $data['status_setelah_lulus'] == 'Bekerja' ? 'briefcase' : ($data['status_setelah_lulus'] == 'Studi' ? 'graduation-cap' : 'clock'); ?>"></i>
                                    <?= htmlspecialchars($data['status_setelah_lulus']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ✅ DATA PROFIL SISWA LENGKAP -->
                <?php if ($data_siswa): ?>
                    <div class="content-section">
                        <h3 class="section-title">
                            <i class="fa fa-address-card"></i>
                            Data Profil Siswa
                        </h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-id-badge"></i> NIK
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['nik'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-map-marker-alt"></i> Tempat Lahir
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['tempat_lahir'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-calendar"></i> Tanggal Lahir
                                </div>
                                <div class="info-value">
                                    <?= $data_siswa['tanggal_lahir'] ? date('d F Y', strtotime($data_siswa['tanggal_lahir'])) : '-'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-mars-venus"></i> Status Perkawinan
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['status_perkawinan'] ?? '-'); ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-praying-hands"></i> Agama
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['agama'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-globe"></i> Kewarganegaraan
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['kewarganegaraan'] ?? '-'); ?>
                                </div>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <div class="info-label">
                                    <i class="fa fa-home"></i> Alamat
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['alamat'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-phone"></i> No. HP
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['no_hp'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-envelope"></i> Email
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data_siswa['email'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-ruler-vertical"></i> Tinggi Badan
                                </div>
                                <div class="info-value">
                                    <?= $data_siswa['tinggi_badan'] ? $data_siswa['tinggi_badan'] . ' cm' : '-'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa fa-weight"></i> Berat Badan
                                </div>
                                <div class="info-value">
                                    <?= $data_siswa['berat_badan'] ? $data_siswa['berat_badan'] . ' kg' : '-'; ?>
                                </div>
                            </div>
                            <?php if ($data_siswa['deskripsi']): ?>
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <div class="info-label">
                                        <i class="fa fa-align-left"></i> Deskripsi
                                    </div>
                                    <div class="info-value"><?= nl2br(htmlspecialchars($data_siswa['deskripsi'])); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($data_siswa['prestasi']): ?>
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <div class="info-label">
                                        <i class="fa fa-trophy"></i> Prestasi
                                    </div>
                                    <div class="info-value"><?= nl2br(htmlspecialchars($data_siswa['prestasi'])); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ✅ DATA KELUARGA -->
                <?php if (!empty($data_keluarga)): ?>
                    <div class="content-section">
                        <h3 class="section-title">
                            <i class="fa fa-users"></i>
                            Data Keluarga
                        </h3>
                        <?php foreach ($data_keluarga as $keluarga): ?>
                            <div class="info-grid"
                                style="margin-bottom: 20px; border: 2px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-user"></i> Nama Lengkap
                                    </div>
                                    <div class="info-value"><?= htmlspecialchars($keluarga['nama_lengkap'] ?? '-'); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-briefcase"></i> Pekerjaan
                                    </div>
                                    <div class="info-value"><?= htmlspecialchars($keluarga['pekerjaan'] ?? '-'); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-info-circle"></i> Status
                                    </div>
                                    <div class="info-value"><?= htmlspecialchars($keluarga['status'] ?? '-'); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- ✅ DATA SOSIAL MEDIA -->
                <?php if (!empty($data_sosmed)): ?>
                    <!-- ✅ DATA SOSIAL MEDIA - SELALU TAMPIL -->
                    <div class="content-section">
                        <h3 class="section-title">
                            <i class="fa fa-share-alt"></i>
                            Sosial Media
                        </h3>
                        <?php if (!empty($data_sosmed)): ?>
                            <div class="info-grid">
                                <?php foreach ($data_sosmed as $sosmed): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-<?=
                                                $sosmed['nama_platform'] == 'instagram' ? 'instagram' :
                                                ($sosmed['nama_platform'] == 'linkedin' ? 'linkedin' :
                                                    ($sosmed['nama_platform'] == 'facebook' ? 'facebook' :
                                                        ($sosmed['nama_platform'] == 'twitter' ? 'twitter' :
                                                            ($sosmed['nama_platform'] == 'github' ? 'github' :
                                                                ($sosmed['nama_platform'] == 'whatsapp' ? 'whatsapp' : 'link')))))
                                                ?>"></i>
                                            <?= htmlspecialchars(ucfirst($sosmed['nama_platform'] ?? '-')); ?>
                                        </div>
                                        <div class="info-value">
                                            <?php if (!empty($sosmed['link'])): ?>
                                                <a href="<?= htmlspecialchars($sosmed['link']); ?>" target="_blank"
                                                    style="color: #667eea; text-decoration: none;">
                                                    <?= htmlspecialchars($sosmed['link']); ?>
                                                </a>
                                            <?php else: ?>
                                                <span style="color: #94a3b8;">-</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state-message">
                                <i class="fa fa-share-alt"></i>
                                <p><strong>Data sosial media belum diisi</strong></p>
                                <p>Siswa belum menambahkan informasi sosial media.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- ✅ DATA DOKUMEN -->
                <?php if ($data_dokumen): ?>
                    <div class="content-section">
                        <h3 class="section-title">
                            <i class="fa fa-file-alt"></i>
                            Dokumen
                        </h3>
                        <div class="info-grid">
                            <?php if ($data_dokumen['ijazah']): ?>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-certificate"></i> Ijazah
                                    </div>
                                    <div class="info-value">
                                        <a href="peserta/file/<?= htmlspecialchars($data_dokumen['ijazah']); ?>" target="_blank"
                                            style="color: #667eea;">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($data_dokumen['ktp_file']): ?>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-id-card"></i> KTP
                                    </div>
                                    <div class="info-value">
                                        <a href="peserta/file/<?= htmlspecialchars($data_dokumen['ktp_file']); ?>"
                                            target="_blank" style="color: #667eea;">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($data_dokumen['transkrip']): ?>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-file-alt"></i> Transkrip
                                    </div>
                                    <div class="info-value">
                                        <a href="peserta/file/<?= htmlspecialchars($data_dokumen['transkrip']); ?>"
                                            target="_blank" style="color: #667eea;">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($data_dokumen['dokumen_lain']): ?>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-folder-open"></i> Dokumen Lain
                                    </div>
                                    <div class="info-value">
                                        <a href="peserta/file/<?= htmlspecialchars($data_dokumen['dokumen_lain']); ?>"
                                            target="_blank" style="color: #667eea;">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ✅ DATA RIWAYAT PENDIDIKAN -->
                <?php if (!empty($data_pendidikan)): ?>
                    <div class="content-section">
                        <h3 class="section-title">
                            <i class="fa fa-graduation-cap"></i>
                            Riwayat Pendidikan
                        </h3>
                        <?php foreach ($data_pendidikan as $pendidikan): ?>
                            <div class="info-grid"
                                style="margin-bottom: 20px; border: 2px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-layer-group"></i> Tingkat
                                    </div>
                                    <div class="info-value"><?= htmlspecialchars($pendidikan['tingkat'] ?? '-'); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-school"></i> Sekolah
                                    </div>
                                    <div class="info-value"><?= htmlspecialchars($pendidikan['sekolah'] ?? '-'); ?></div>
                                </div>
                                <?php if ($pendidikan['jurusan']): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-book"></i> Jurusan
                                        </div>
                                        <div class="info-value"><?= htmlspecialchars($pendidikan['jurusan']); ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pendidikan['ipk']): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-star"></i> IPK
                                        </div>
                                        <div class="info-value"><?= htmlspecialchars($pendidikan['ipk']); ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pendidikan['akreditasi']): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-certificate"></i> Akreditasi
                                        </div>
                                        <div class="info-value"><?= htmlspecialchars($pendidikan['akreditasi']); ?></div>
                                    </div>
                                <?php endif; ?>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa fa-calendar-alt"></i> Periode
                                    </div>
                                    <div class="info-value">
                                        <?= $pendidikan['tgl_mulai'] ?? '-' ?> - <?= $pendidikan['tgl_selesai'] ?? '-' ?>
                                    </div>
                                </div>
                                <?php if ($pendidikan['negara']): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-globe"></i> Negara
                                        </div>
                                        <div class="info-value"><?= htmlspecialchars($pendidikan['negara']); ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pendidikan['provinsi']): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-map-marker-alt"></i> Provinsi
                                        </div>
                                        <div class="info-value"><?= htmlspecialchars($pendidikan['provinsi']); ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pendidikan['kota']): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fa fa-city"></i> Kota
                                        </div>
                                        <div class="info-value"><?= htmlspecialchars($pendidikan['kota']); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Status-Specific Information -->
                <?php if ($data['status_setelah_lulus'] == 'Bekerja'): ?>
                    <div class="content-section"
                        style="background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%); border-radius: 15px; margin: 0 30px 30px 30px;">
                        <h3 class="section-title" style="border-bottom-color: #38a169;">
                            <i class="fa fa-briefcase" style="color: #38a169;"></i>
                            Informasi Pekerjaan
                        </h3>
                        <div class="info-grid">
                            <div class="info-item" style="border-left-color: #38a169;">
                                <div class="info-label">
                                    <i class="fa fa-building"></i> Nama Instansi
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data['nama_instansi'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item" style="border-left-color: #38a169;">
                                <div class="info-label">
                                    <i class="fa fa-briefcase"></i> Posisi / Jabatan
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data['posisi'] ?? '-'); ?></div>
                            </div>
                            <!--    <div class="info-item" style="border-left-color: #38a169;">
                                <div class="info-label">
                                    <i class="fa fa-calendar-check"></i> Tahun Mulai
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data['tahun_mulai'] ?? '-'); ?></div>
                            </div> -->
                        </div>
                    </div>
                <?php elseif ($data['status_setelah_lulus'] == 'Studi'): ?>
                    <div class="content-section"
                        style="background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%); border-radius: 15px; margin: 0 30px 30px 30px;">
                        <h3 class="section-title" style="border-bottom-color: #319795;">
                            <i class="fa fa-graduation-cap" style="color: #319795;"></i>
                            Informasi Studi Lanjut
                        </h3>
                        <div class="info-grid">
                            <div class="info-item" style="border-left-color: #319795;">
                                <div class="info-label">
                                    <i class="fa fa-university"></i> Nama Kampus
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data['nama_kampus'] ?? '-'); ?></div>
                            </div>
                            <div class="info-item" style="border-left-color: #319795;">
                                <div class="info-label">
                                    <i class="fa fa-book"></i> Jurusan
                                </div>
                                <div class="info-value"><?= htmlspecialchars($data['jurusan'] ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($data['status_setelah_lulus'] == 'Belum Bekerja'): ?>
                    <div class="content-section"
                        style="background: linear-gradient(135deg, #fffaf0 0%, #feebc8 100%); border-radius: 15px; margin: 0 30px 30px 30px;">
                        <h3 class="section-title" style="border-bottom-color: #dd6b20;">
                            <i class="fa fa-clock" style="color: #dd6b20;"></i>
                            Aktivitas Saat Ini
                        </h3>
                        <div class="info-item" style="border-left-color: #dd6b20;">
                            <div class="info-label">
                                <i class="fa fa-tasks"></i> Deskripsi Aktivitas
                            </div>
                            <div class="info-value"><?= htmlspecialchars($data['aktivitas'] ?? '-'); ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <!--    <a href="?halaman=tracer_ubah&kode=<?= $data['id_tracer']; ?>" class="btn-action btn-edit">
                        <i class="fa fa-edit"></i>
                        <span>Edit Data</span>
                    </a> -->
                    <a href="javascript:history.back()" class="btn-action btn-close">
                        <i class="fa fa-times"></i>
                        <span>Tutup</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all info items
        document.querySelectorAll('.info-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = `all 0.5s ease ${index * 0.1}s`;
            observer.observe(item);
        });
    </script>
</body>

</html>
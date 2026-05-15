<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("koneksi.php");

// ✅ Validasi parameter NISN
$nisn = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

if (empty($nisn)) {
    echo "<script>alert('NISN tidak valid!'); window.history.back();</script>";
    exit;
}

// ✅ QUERY DATA SISWA dari tb_siswa (TANPA tb_sekolah)
$sql = "SELECT * FROM tb_siswa WHERE nisn = '$nisn' LIMIT 1";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data siswa tidak ditemukan!'); window.history.back();</script>";
    exit;
}

$data = mysqli_fetch_assoc($result);

// ✅ AMBIL ID SISWA
$id_siswa = $data['id_siswa'] ?? 0;

// ✅ QUERY DATA KELUARGA
$data_keluarga = [];
$sql_keluarga = "SELECT * FROM tb_keluarga WHERE id_siswa = '$id_siswa'";
$result_keluarga = mysqli_query($con, $sql_keluarga);
if ($result_keluarga) {
    while ($row = mysqli_fetch_assoc($result_keluarga)) {
        $data_keluarga[] = $row;
    }
}

// ✅ QUERY DATA SOSIAL MEDIA (gunakan id_user dari tb_siswa)
$data_sosmed = [];
$id_user = $data['id_user'] ?? 0;
if ($id_user) {
    $sql_sosmed = "SELECT * FROM tb_sosial_media WHERE id_user = '$id_user'";
    $result_sosmed = mysqli_query($con, $sql_sosmed);
    if ($result_sosmed) {
        while ($row = mysqli_fetch_assoc($result_sosmed)) {
            $data_sosmed[] = $row;
        }
    }
}

// ✅ QUERY DATA DOKUMEN
$data_dokumen = null;
$sql_dokumen = "SELECT * FROM tb_dokumen WHERE id_siswa = '$id_siswa' LIMIT 1";
$result_dokumen = mysqli_query($con, $sql_dokumen);
if ($result_dokumen && mysqli_num_rows($result_dokumen) > 0) {
    $data_dokumen = mysqli_fetch_assoc($result_dokumen);
}

// ✅ QUERY DATA PENDIDIKAN
$data_pendidikan = [];
$sql_pendidikan = "SELECT * FROM tb_pendidikan WHERE id_siswa = '$id_siswa' ORDER BY tgl_selesai DESC";
$result_pendidikan = mysqli_query($con, $sql_pendidikan);
if ($result_pendidikan) {
    while ($row = mysqli_fetch_assoc($result_pendidikan)) {
        $data_pendidikan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - <?= htmlspecialchars($data['nama'] ?? 'Siswa'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ✅ FIX: Reset untuk mencegah konflik dengan portal */
        .profile-standalone-wrapper {
            all: initial;
            display: block;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-standalone-wrapper * { box-sizing: border-box; }
        .profile-standalone-wrapper .container {
            max-width: 1200px;
            margin: 0 auto !important;
            padding: 20px !important;
            position: relative !important;
            z-index: 1 !important;
        }
        .profile-standalone-wrapper body {
            margin: 0 !important;
            padding: 0 !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            min-height: 100vh !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }
        .profile-standalone-wrapper .main-sidebar,
        .profile-standalone-wrapper .main-header,
        .profile-standalone-wrapper .content-wrapper > *:not(.container) {
            display: none !important;
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            margin-top: -30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .page-title i { font-size: 32px; color: #667eea; }
        .page-title h1 {
            font-size: 28px;
            color: #2d3748;
            font-weight: 700;
            margin: 0;
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
            box-shadow: 0 5px 20px rgba(102,126,234,0.4);
        }

        /* Main Card */
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            margin-bottom: 25px;
        }

        /* Profile Header */
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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 60px;
            border: 5px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .profile-avatar i { transition: opacity 0.3s; }
        .profile-avatar[style*="background-image"] i { opacity: 0; }
        .profile-name {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 10px 0;
            position: relative;
            z-index: 1;
        }
        .profile-nisn {
            font-size: 16px;
            opacity: 0.9;
            margin: 0 0 15px 0;
        }

        /* Content Sections */
        .content-section {
            padding: 30px;
        }
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            margin: 0 0 25px 0;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i { color: #667eea; }

        /* Info Grid */
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
            box-shadow: 0 5px 20px rgba(102,126,234,0.2);
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
        .info-label i { color: #667eea; font-size: 16px; }
        .info-value {
            font-size: 16px;
            color: #2d3748;
            font-weight: 600;
            word-break: break-word;
        }

        /* Empty State */
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

        /* Family Card */
        .family-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .family-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .family-badge {
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Education Card */
        .education-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .education-badge {
            background: #3b82f6;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Social Media Item */
        .sosmed-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .sosmed-platform {
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sosmed-link a {
            color: #667eea;
            text-decoration: none;
        }
        .sosmed-link a:hover { text-decoration: underline; }

        /* Document Link */
        .doc-link {
            color: #667eea;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }
        .doc-link:hover { text-decoration: underline; }

        /* Action Buttons */
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
        .btn-close {
            background: linear-gradient(135deg, #434343 0%, #000000 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .btn-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header { flex-direction: column; text-align: center; }
            .page-title h1 { font-size: 24px; }
            .profile-header { padding: 30px 20px; }
            .profile-name { font-size: 24px; }
            .content-section { padding: 20px; }
            .info-grid { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .btn-action { width: 100%; justify-content: center; }
            .sosmed-item { flex-direction: column; align-items: flex-start; gap: 10px; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .main-card { animation: fadeIn 0.6s ease-out; }
    </style>
</head>
<body>
    <div class="profile-standalone-wrapper">
        <div class="container">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <i class="fa fa-user-graduate"></i>
                    <h1>Profil Siswa</h1>
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
                         style="background-image: url('<?= !empty($data['foto']) ? 'peserta/foto/' . htmlspecialchars($data['foto']) : 'dist/img/pegawai.png'; ?>');">
                        <?php if (empty($data['foto'])): ?>
                            <i class="fa fa-user"></i>
                        <?php endif; ?>
                    </div>
                    <h2 class="profile-name"><?= htmlspecialchars($data['nama'] ?? '-'); ?></h2>
                    <p class="profile-nisn">
                        <i class="fa fa-id-card"></i> NISN: <?= htmlspecialchars($data['nisn'] ?? '-'); ?>
                    </p>
                </div>

                <!-- Personal Information -->
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-user-circle"></i>
                        Informasi Pribadi
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-id-card"></i> NISN</div>
                            <div class="info-value"><?= htmlspecialchars($data['nisn'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-user"></i> Nama Lengkap</div>
                            <div class="info-value"><?= htmlspecialchars($data['nama'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-<?= ($data['jekel'] ?? '') == 'Pria' ? 'mars' : 'venus'; ?>"></i> Jenis Kelamin</div>
                            <div class="info-value"><?= htmlspecialchars($data['jekel'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-map-marker-alt"></i> Tempat Lahir</div>
                            <div class="info-value"><?= htmlspecialchars($data['tempat_lahir'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-calendar"></i> Tanggal Lahir</div>
                            <div class="info-value">
                                <?= !empty($data['tanggal_lahir']) ? date('d F Y', strtotime($data['tanggal_lahir'])) : '-'; ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-id-badge"></i> NIK</div>
                            <div class="info-value"><?= htmlspecialchars($data['nik'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label"><i class="fa fa-home"></i> Alamat</div>
                            <div class="info-value"><?= htmlspecialchars($data['alamat'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-phone"></i> No. HP</div>
                            <div class="info-value"><?= htmlspecialchars($data['no_hp'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-envelope"></i> Email</div>
                            <div class="info-value"><?= htmlspecialchars($data['email'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-praying-hands"></i> Agama</div>
                            <div class="info-value"><?= htmlspecialchars($data['agama'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-globe"></i> Kewarganegaraan</div>
                            <div class="info-value"><?= htmlspecialchars($data['kewarganegaraan'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-heart"></i> Status Perkawinan</div>
                            <div class="info-value"><?= htmlspecialchars($data['status_perkawinan'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-ruler-vertical"></i> Tinggi Badan</div>
                            <div class="info-value"><?= !empty($data['tinggi_badan']) ? $data['tinggi_badan'] . ' cm' : '-'; ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-weight"></i> Berat Badan</div>
                            <div class="info-value"><?= !empty($data['berat_badan']) ? $data['berat_badan'] . ' kg' : '-'; ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-book"></i> Jurusan</div>
                            <div class="info-value"><?= htmlspecialchars($data['jurusan'] ?? '-'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-calendar-check"></i> Tahun Lulus</div>
                            <div class="info-value"><?= htmlspecialchars($data['tahun_lulus'] ?? '-'); ?></div>
                        </div>
                        <?php if (!empty($data['deskripsi'])): ?>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label"><i class="fa fa-align-left"></i> Deskripsi Diri</div>
                            <div class="info-value"><?= nl2br(htmlspecialchars($data['deskripsi'])); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($data['prestasi'])): ?>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label"><i class="fa fa-trophy"></i> Prestasi</div>
                            <div class="info-value"><?= nl2br(htmlspecialchars($data['prestasi'])); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ✅ DATA KELUARGA 
                <?php if (!empty($data_keluarga)): ?>
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-users"></i>
                        Data Keluarga
                    </h3>
                    <?php foreach ($data_keluarga as $keluarga): ?>
                    <div class="family-card">
                        <div class="family-header">
                            <strong><?= htmlspecialchars($keluarga['nama_lengkap'] ?? '-'); ?></strong>
                            <span class="family-badge"><?= htmlspecialchars($keluarga['status'] ?? '-'); ?></span>
                        </div>
                        <div class="info-grid" style="margin-bottom: 0;">
                            <div class="info-item">
                                <div class="info-label"><i class="fa fa-briefcase"></i> Pekerjaan</div>
                                <div class="info-value"><?= htmlspecialchars($keluarga['pekerjaan'] ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-users"></i>
                        Data Keluarga
                    </h3>
                    <div class="empty-state-message">
                        <i class="fa fa-users"></i>
                        <p><strong>Data keluarga belum diisi</strong></p>
                    </div>
                </div> 
                <?php endif; ?> -->

                <!-- ✅ DATA SOSIAL MEDIA -->
                <?php if (!empty($data_sosmed)): ?>
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-share-alt"></i>
                        Sosial Media
                    </h3>
                    <?php foreach ($data_sosmed as $sosmed): ?>
                    <div class="sosmed-item">
                        <div class="sosmed-platform">
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
                        <div class="sosmed-link">
                            <?php if (!empty($sosmed['link'])): ?>
                                <a href="<?= htmlspecialchars($sosmed['link']); ?>" target="_blank">
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
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-share-alt"></i>
                        Sosial Media
                    </h3>
                    <div class="empty-state-message">
                        <i class="fa fa-share-alt"></i>
                        <p><strong>Data sosial media belum diisi</strong></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ✅ DATA DOKUMEN -->
                <?php if ($data_dokumen && ($data_dokumen['ijazah'] || $data_dokumen['ktp_file'] || $data_dokumen['transkrip'] || $data_dokumen['dokumen_lain'])): ?>
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-file-alt"></i>
                        Dokumen
                    </h3>
                    <div class="info-grid">
                        <?php if (!empty($data_dokumen['ijazah'])): ?>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-certificate"></i> Ijazah</div>
                            <div class="info-value">
                                <a href="peserta/file/<?= htmlspecialchars($data_dokumen['ijazah']); ?>" 
                                   target="_blank" class="doc-link">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($data_dokumen['ktp_file'])): ?>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-id-card"></i> KTP</div>
                            <div class="info-value">
                                <a href="peserta/file/<?= htmlspecialchars($data_dokumen['ktp_file']); ?>" 
                                   target="_blank" class="doc-link">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($data_dokumen['transkrip'])): ?>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-file-alt"></i> Transkrip</div>
                            <div class="info-value">
                                <a href="peserta/file/<?= htmlspecialchars($data_dokumen['transkrip']); ?>" 
                                   target="_blank" class="doc-link">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($data_dokumen['dokumen_lain'])): ?>
                        <div class="info-item">
                            <div class="info-label"><i class="fa fa-folder-open"></i> Dokumen Lain</div>
                            <div class="info-value">
                                <a href="peserta/file/<?= htmlspecialchars($data_dokumen['dokumen_lain']); ?>" 
                                   target="_blank" class="doc-link">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-file-alt"></i>
                        Dokumen
                    </h3>
                    <div class="empty-state-message">
                        <i class="fa fa-file-alt"></i>
                        <p><strong>Data dokumen belum diisi</strong></p>
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
                    <div class="education-card">
                        <span class="education-badge"><?= htmlspecialchars($pendidikan['tingkat'] ?? '-'); ?></span>
                        <div class="info-grid" style="margin-bottom: 0;">
                            <div class="info-item">
                                <div class="info-label"><i class="fa fa-school"></i> Sekolah</div>
                                <div class="info-value"><?= htmlspecialchars($pendidikan['sekolah'] ?? '-'); ?></div>
                            </div>
                            <?php if (!empty($pendidikan['jurusan'])): ?>
                            <div class="info-item">
                                <div class="info-label"><i class="fa fa-book"></i> Jurusan</div>
                                <div class="info-value"><?= htmlspecialchars($pendidikan['jurusan']); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($pendidikan['ipk'])): ?>
                            <div class="info-item">
                                <div class="info-label"><i class="fa fa-star"></i> IPK/Nilai</div>
                                <div class="info-value"><?= htmlspecialchars($pendidikan['ipk']); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($pendidikan['akreditasi'])): ?>
                            <div class="info-item">
                                <div class="info-label"><i class="fa fa-certificate"></i> Akreditasi</div>
                                <div class="info-value"><?= htmlspecialchars($pendidikan['akreditasi']); ?></div>
                            </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <div class="info-label"><i class="fa fa-calendar-alt"></i> Periode</div>
                                <div class="info-value">
                                    <?= !empty($pendidikan['tgl_mulai']) ? date('M Y', strtotime($pendidikan['tgl_mulai'])) : '-' ?> 
                                    - 
                                    <?= !empty($pendidikan['tgl_selesai']) ? date('M Y', strtotime($pendidikan['tgl_selesai'])) : 'Sekarang' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="content-section">
                    <h3 class="section-title">
                        <i class="fa fa-graduation-cap"></i>
                        Riwayat Pendidikan
                    </h3>
                    <div class="empty-state-message">
                        <i class="fa fa-graduation-cap"></i>
                        <p><strong>Data riwayat pendidikan belum diisi</strong></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="javascript:history.back()" class="btn-action btn-close">
                        <i class="fa fa-times"></i>
                        <span>Tutup</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Fade-in animation on scroll
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.info-item, .family-card, .education-card, .sosmed-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = `all 0.5s ease ${index * 0.1}s`;
            observer.observe(item);
        });
    </script>
</body>
</html>
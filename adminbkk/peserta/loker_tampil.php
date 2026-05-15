<?php
// ✅ Tidak ada pengecekan login - halaman publik
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("../koneksi.php");

// ✅ Query lowongan untuk publik: tampilkan yang aktif dan belum expired
$sql_loker = mysqli_query($con, "
    SELECT l.*, p.nama_perusahaan, p.alamat, p.kota, p.logo
    FROM tb_lowongan l
    JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan
    WHERE l.status = 'aktif' 
    AND (l.batas_lamaran IS NULL OR l.batas_lamaran >= CURDATE())
    ORDER BY l.tanggal_posting DESC
");

// Handle query error
if (!$sql_loker) {
    die("Query Error: " . mysqli_error($con));
}

$selected_id = isset($_GET['id']) ? trim($_GET['id']) : "";
$selected_id = mysqli_real_escape_string($con, $selected_id);

$data_detail = null;
$data_perusahaan = null;

if ($selected_id != "") {
    // Query detail lowongan
    $sql_detail = mysqli_query($con, "
        SELECT 
            l.id_lowongan,
            l.judul_lowongan,
            l.jekel,
            l.posisi,
            l.deskripsi,
            l.kualifikasi,
            l.lokasi,
            l.jenis_pekerjaan,
            l.gaji,
            l.tanggal_posting,
            l.batas_lamaran,
            l.status,
            p.nama_perusahaan,
            p.alamat,
            p.kota,
            p.logo,
            p.bidang_usaha,
            p.jumlah_karyawan,
            p.deskripsi as deskripsi_perusahaan,
            p.manfaat,
            p.id_user,
            u.email
        FROM tb_lowongan l
        JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan
        JOIN tb_user u ON p.id_user = u.id_user
        WHERE l.id_lowongan = '$selected_id'
    ");

    if ($sql_detail) {
        $data_detail = mysqli_fetch_array($sql_detail, MYSQLI_BOTH);
        if ($data_detail) {
            $data_perusahaan = $data_detail;

            // ✅ QUERY SOSIAL MEDIA PERUSAHAAN (DITAMBAHKAN)
            if (!empty($data_perusahaan['id_user'])) {
                $id_user_perusahaan = mysqli_real_escape_string($con, $data_perusahaan['id_user']);
                $sql_sosmed = mysqli_query($con, "
                    SELECT * FROM tb_sosial_media 
                    WHERE id_user = '$id_user_perusahaan'
                    ORDER BY nama_platform ASC
                ");
            }
        }
    }
}
?>

<style>
    /* Hilangkan scrollbar utama */
    html,
    body {
        height: 100%;
        overflow: hidden !important;
        margin: 0;
        padding: 0;
    }

    /* === MODERN ENHANCED STYLES === */
    .job-container {
        display: flex;
        gap: 25px;
        height: calc(100vh - 180px);
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 20px;
        border-radius: 20px;
    }

    .job-list {
        width: 35%;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 25px;
        overflow-y: auto;
        max-height: calc(121vh - 250px);
        border: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }

    .job-detail {
        width: 65%;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 35px;
        overflow-y: auto;
        border: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }

    .job-item.active .job-title,
    .job-item.active .job-company,
    .job-item.active .job-info,
    .job-item.active .job-date {
        color: #ffffff !important;
    }

    .job-item {
        border: 2px solid #e8ecf1;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 18px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        position: relative;
        overflow: hidden;
    }

    .job-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .job-item:hover {
        background: linear-gradient(135deg, #0c1c64 0%, #8b82d5 100%);
        border-color: transparent;
        transform: translateX(8px);
        box-shadow: 0 8px 24px rgba(240, 147, 251, 0.3);
        color: white;
    }

    .job-item:hover::before {
        opacity: 1;
    }

    .job-item:hover .job-title,
    .job-item:hover .job-company,
    .job-item:hover .job-info,
    .job-item:hover .job-date {
        color: #ffffff !important;
    }

    .job-item.active {
        background: linear-gradient(135deg, #0c1c64 0%, #8b82d5 100%);
        border: 2px solid transparent;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .job-item.active::before {
        opacity: 1;
    }

    .job-title {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 8px;
        transition: color 0.3s ease;
    }

    .job-company {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .job-info {
        font-size: 13px;
        color: #666;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .job-date {
        font-size: 12px;
        color: #888;
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.3s ease;
    }

    .company-profile {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        border: 2px solid #e8ecf1;
        border-radius: 20px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .company-profile:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .box.box-primary {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .box-header.with-border {
        background: linear-gradient(135deg, #2d4edf 0%, #22063e 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 16px 16px 0 0;
        border: none !important;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .box-header h3 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .box-body {
        background: transparent;
        padding: 0;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .job-list::-webkit-scrollbar,
    .job-detail::-webkit-scrollbar {
        width: 8px;
    }

    .job-list::-webkit-scrollbar-track,
    .job-detail::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .job-list::-webkit-scrollbar-thumb,
    .job-detail::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    @media (max-width: 991px) {
        .job-container {
            flex-direction: column;
            height: auto;
        }

        .job-list,
        .job-detail {
            width: 100%;
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

    .job-item {
        animation: fadeIn 0.5s ease forwards;
    }

    .job-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .job-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .job-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #888;
    }

    .empty-state img {
        opacity: 0.6;
        margin-bottom: 25px;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    .empty-state h3 {
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 22px;
    }

    .section-header {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin: 30px 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 3px solid #667eea;
        display: inline-block;
    }

    .section-content {
        font-size: 14px;
        line-height: 1.8;
        color: #555;
        text-align: justify;
    }

    .detail-header {
        display: flex;
        gap: 25px;
        align-items: flex-start;
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 3px solid #e8ecf1;
    }

    .detail-logo {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 16px;
        border: 3px solid white;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .detail-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .detail-company {
        font-size: 18px;
        color: #555;
        font-weight: 600;
    }

    .detail-meta {
        margin-top: 15px;
        font-size: 14px;
        color: #666;
    }

    .detail-meta-item {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-meta-item i {
        color: #667eea;
        width: 20px;
    }

    .company-logo {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .company-name {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
    }

    .company-meta p {
        margin: 8px 0;
        font-size: 14px;
        color: #555;
    }

    .company-meta i {
        color: #667eea;
        margin-right: 8px;
        width: 20px;
    }

    .company-benefit ul {
        margin: 10px 0;
        padding-left: 20px;
    }

    .company-benefit li {
        margin: 5px 0;
        font-size: 14px;
        color: #555;
    }

    /* ✅ SOSIAL MEDIA STYLES (DITAMBAHKAN) */
    .sosmed-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .sosmed-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        border: 2px solid;
    }

    .sosmed-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .sosmed-facebook {
        color: #1877f2;
        border-color: #1877f2;
    }

    .sosmed-facebook:hover {
        background: #1877f2;
        color: white;
    }

    .sosmed-instagram {
        color: #e4405f;
        border-color: #e4405f;
    }

    .sosmed-instagram:hover {
        background: #e4405f;
        color: white;
    }

    .sosmed-twitter {
        color: #1da1f2;
        border-color: #1da1f2;
    }

    .sosmed-twitter:hover {
        background: #1da1f2;
        color: white;
    }

    .sosmed-linkedin {
        color: #0077b5;
        border-color: #0077b5;
    }

    .sosmed-linkedin:hover {
        background: #0077b5;
        color: white;
    }

    .sosmed-youtube {
        color: #ff0000;
        border-color: #ff0000;
    }

    .sosmed-youtube:hover {
        background: #ff0000;
        color: white;
    }

    .sosmed-tiktok {
        color: #000000;
        border-color: #000000;
    }

    .sosmed-tiktok:hover {
        background: #000000;
        color: white;
    }

    .sosmed-whatsapp {
        color: #25d366;
        border-color: #25d366;
    }

    .sosmed-whatsapp:hover {
        background: #25d366;
        color: white;
    }

    .sosmed-default {
        color: #667eea;
        border-color: #667eea;
    }

    .sosmed-default:hover {
        background: #667eea;
        color: white;
    }

    /* ================= MOBILE RESPONSIVE ================= */
    @media (max-width: 768px) {

        html,
        body {
            overflow-y: auto !important;
            height: auto !important;
        }

        .content {
            padding: 20px !important;
        }

        .box.box-primary {
            height: auto !important;
        }

        .box-header.with-border {
            padding: 18px 15px;
            border-radius: 14px 14px 0 0;
        }

        .box-header h3 {
            font-size: 18px;
        }

        .pull-right {
            float: none !important;
            display: block;
            margin-top: 8px;
            font-size: 12px;
        }

        .box-body {
            overflow: visible !important;
        }

        .job-container {
            flex-direction: column;
            height: auto !important;
            padding: 12px;
            gap: 15px;
            border-radius: 15px;
        }

        .job-list,
        .job-detail {
            width: 100% !important;
            max-height: none !important;
            overflow: visible !important;
            padding: 15px;
            border-radius: 15px;
        }

        .job-item {
            padding: 15px;
            margin-bottom: 14px;
            border-radius: 14px;
        }

        .job-title {
            font-size: 15px;
            line-height: 1.4;
        }

        .job-company {
            font-size: 13px;
        }

        .job-info,
        .job-date {
            font-size: 12px;
            line-height: 1.5;
            word-break: break-word;
        }

        /* ================= FULL WIDTH MOBILE ================= */
        @media (max-width: 768px) {

            .content {
                padding: 0px !important;
                margin: 0 !important;
            }

            .box.box-primary {
                margin-top: 20px !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                border-radius: 0 !important;
            }

            .box-body {
                padding: 0 !important;
            }

            .job-container {
                padding: 0px !important;
                gap: 10px;
                border-radius: 0;
                width: 100%;
            }

            .job-list,
            .job-detail {
                width: 100% !important;
                padding: 12px !important;
                border-radius: 14px;
                margin: 0;
            }

            .job-item {
                width: 100%;
                margin: 0 0 12px 0;
            }

            .company-profile {
                width: 100%;
                padding: 15px;
            }

            .detail-header,
            .company-header {
                width: 100%;
            }

            .detail-meta {
                width: 100%;
            }

        }

        /* ================= DETAIL PERUSAHAAN MOBILE ================= */

        .detail-header {
            flex-direction: column;
            align-items: flex-start !important;
            text-align: left !important;
            gap: 15px;
            padding-bottom: 18px;
        }

        .detail-header>div {
            width: 100%;
        }

        .detail-logo {
            width: 75px;
            height: 75px;
            margin: 0 auto 10px auto;
            display: block;
        }

        .detail-title {
            font-size: 24px;
            line-height: 1.4;
            margin-bottom: 8px;
            text-align: left;
        }

        .detail-company {
            font-size: 16px;
            line-height: 1.5;
            text-align: left;
        }

        .detail-meta {
            margin-top: 15px;
            width: 100%;
        }

        .detail-meta-item {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start !important;
            gap: 10px;
            font-size: 13px;
            line-height: 1.7;
            text-align: left !important;
            margin-bottom: 12px;
            word-break: break-word;
        }

        .detail-meta-item i {
            min-width: 18px;
            margin-top: 3px;
            font-size: 14px;
        }

        .company-profile {
            padding: 18px;
            border-radius: 16px;
        }

        .company-header {
            text-align: left !important;
        }

        .company-logo {
            width: 70px;
            height: 70px;
            margin-bottom: 12px;
        }

        .company-name {
            font-size: 18px;
            line-height: 1.5;
            text-align: left;
        }

        .company-meta p {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 10px;
            text-align: left;
        }

        .company-desc {
            font-size: 13px;
            line-height: 1.8;
            text-align: left;
            word-break: break-word;
        }

        .company-benefit li {
            font-size: 13px;
            line-height: 1.7;
            text-align: left;
        }

        .sosmed-container {
            gap: 8px;
        }

        .sosmed-link {
            width: 100%;
            justify-content: center;
            font-size: 12px;
            padding: 10px;
        }

        .empty-state {
            padding: 40px 15px;
        }

        .empty-state img {
            width: 100px !important;
        }

        .empty-state h3 {
            font-size: 18px;
        }
    }
</style>

<section class="content" style="min-height: calc(100vh - 80px); padding: 0;">
    <div class="box box-primary"
        style="height: calc(105vh - 140px); margin-bottom: 0; display: flex; flex-direction: column;">
        <div class="box-header with-border">
            <h3 class="box-title"><b>💼 Lowongan Kerja</b></h3>
            <span class="pull-right text-muted" style="color: #ffffff;">
                <i class="fa fa-globe"></i> Lowongan Publik
            </span>
        </div>

        <div class="box-body" style="flex: 1; height: calc(100% - 55px); overflow: hidden; padding: 0;">
            <div class="job-container">

                <!-- ================= LEFT: LIST LOWONGAN ================= -->
                <div class="job-list">
                    <h4 style="margin:0 0 5px 0; font-size:18px; color:#2d3748;"><b>📋 Lowongan Kerja Terbaru</b></h4>
                    <p style="margin:0 0 20px 0; font-size:13px; color:#777;">
                        Silahkan pilih lowongan kerja yang sesuai dengan minat Anda.
                    </p>
                    <hr style="margin:15px 0; border:none; border-top:2px solid #e8ecf1;">

                    <?php if (mysqli_num_rows($sql_loker) == 0): ?>
                        <div class="empty-state">
                            <img src="../dist/img/job.png" width="120" alt="No jobs">
                            <p style="font-size:14px;">Saat ini belum ada lowongan tersedia.</p>
                        </div>
                    <?php else: ?>
                        <?php while ($data = mysqli_fetch_array($sql_loker, MYSQLI_BOTH)) { ?>
                            <a href="?halaman=loker&id=<?php echo $data['id_lowongan']; ?>"
                                style="text-decoration:none; color:inherit; display:block;">
                                <div class="job-item <?php echo ($selected_id == $data['id_lowongan']) ? 'active' : ''; ?>">
                                    <div class="job-title"><?php echo htmlspecialchars($data['judul_lowongan']); ?></div>
                                    <div class="job-company"><?php echo htmlspecialchars($data['nama_perusahaan']); ?></div>
                                    <div class="job-info">
                                        <i class="fa fa-map-marker"></i>
                                        <?php
                                        echo !empty($data['kota']) ? htmlspecialchars($data['kota']) :
                                            (!empty($data['alamat']) ? htmlspecialchars(substr($data['alamat'], 0, 40)) . '...' : "Lokasi tidak tersedia");
                                        ?>
                                    </div>
                                    <div class="job-info">
                                        <i class="fa fa-user"></i>
                                        <?php echo htmlspecialchars($data['jekel']); ?>
                                    </div>
                                    <div class="job-date">
                                        <i class="fa fa-calendar"></i>
                                        Batas:
                                        <?php echo $data['batas_lamaran'] ? date('d F Y', strtotime($data['batas_lamaran'])) : '-'; ?>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    <?php endif; ?>
                </div>

                <!-- ================= RIGHT: DETAIL LOWONGAN ================= -->
                <div class="job-detail">

                    <?php if (!$data_detail) { ?>

                        <div class="empty-state">
                            <img src="../dist/img/job.png" width="180" alt="Select job">
                            <h3 style="color:#2d3748; margin-bottom:10px;">Pilih lowongan kerja</h3>
                            <p style="font-size:14px; max-width:400px; margin:0 auto; color:#777;">
                                Klik salah satu lowongan di sebelah kiri untuk melihat detail informasi dan cara melamar.
                            </p>
                        </div>

                    <?php } else { ?>

                        <?php
                        // Ambil logo perusahaan dengan pengecekan file
                        $logo = "../dist/img/pegawai.png"; // Default
                        if (!empty($data_perusahaan['logo'])) {
                            $logo_path = "../dist/img/foto_perusahaan/" . $data_perusahaan['logo'];
                            if (file_exists($logo_path)) {
                                $logo = $logo_path;
                            }
                        }
                        ?>

                        <!-- Header Detail Lowongan -->
                        <div class="detail-header">
                            <div>
                                <img src="<?php echo $logo; ?>" alt="Logo" class="detail-logo">
                            </div>

                            <div style="flex:1;">
                                <h2 class="detail-title">
                                    <?php echo htmlspecialchars($data_detail['judul_lowongan']); ?>
                                </h2>

                                <div class="detail-company">
                                    <b><?php echo htmlspecialchars($data_perusahaan['nama_perusahaan']); ?></b>
                                    <i class="fa fa-check-circle" style="color:#28a745; margin-left:8px;"
                                        title="Terverifikasi"></i>
                                </div>

                                <div class="detail-meta">
                                    <div class="detail-meta-item">
                                        <i class="fa fa-map-marker"></i>
                                        <?php echo htmlspecialchars($data_perusahaan['alamat'] ?? 'Alamat tidak tersedia'); ?>
                                    </div>
                                    <div class="detail-meta-item">
                                        <i class="fa fa-user"></i>
                                        <?php echo htmlspecialchars($data_detail['jekel']); ?>
                                    </div>
                                    <div class="detail-meta-item">
                                        <i class="fa fa-calendar"></i>
                                        Batas lamaran:
                                        <b><?php echo $data_detail['batas_lamaran'] ? date('d F Y', strtotime($data_detail['batas_lamaran'])) : '-'; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tentang Posisi -->
                        <h4 class="section-header">📌 Tentang Posisi</h4>
                        <div class="section-content">
                            <?php
                            $ket = isset($data_detail['posisi']) && !empty($data_detail['posisi']) ? $data_detail['posisi'] : "Tidak ada informasi posisi";
                            $ket = preg_replace('/(\d+\.)/', "<br>$1", htmlspecialchars($ket));
                            echo nl2br($ket);
                            ?>
                        </div>

                        <!-- Deskripsi Pekerjaan -->
                        <?php if (!empty($data_detail['deskripsi'])) { ?>
                            <h4 class="section-header">📝 Deskripsi Pekerjaan</h4>
                            <div class="section-content">
                                <?php echo nl2br(htmlspecialchars($data_detail['deskripsi'])); ?>
                            </div>
                        <?php } ?>

                        <!-- Kualifikasi -->
                        <?php if (!empty($data_detail['kualifikasi'])) { ?>
                            <h4 class="section-header">✅ Kualifikasi</h4>
                            <div class="section-content">
                                <?php echo nl2br(htmlspecialchars($data_detail['kualifikasi'])); ?>
                            </div>
                        <?php } ?>

                        <!-- ================= PROFIL PERUSAHAAN ================= -->
                        <h4 class="section-header">🏢 Profil Perusahaan</h4>

                        <?php
                        $logo_profile = "../dist/img/pegawai.png";
                        if (!empty($data_perusahaan['logo'])) {
                            $logo_profile_path = "../dist/img/foto_perusahaan/" . $data_perusahaan['logo'];
                            if (file_exists($logo_profile_path)) {
                                $logo_profile = $logo_profile_path;
                            }
                        }
                        ?>

                        <div class="company-profile">
                            <div class="company-header">
                                <img src="<?php echo $logo_profile; ?>" class="company-logo" alt="Logo Perusahaan">

                                <div>
                                    <div class="company-name">
                                        <?php echo htmlspecialchars($data_perusahaan['nama_perusahaan']); ?>
                                        <i class="fa fa-check-circle" style="color:#28a745; margin-left:8px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="company-meta">
                                <?php if (!empty($data_perusahaan['bidang_usaha'])) { ?>
                                    <p><i class="fa fa-building"></i> <b>Bidang Usaha:</b>
                                        <?php echo htmlspecialchars($data_perusahaan['bidang_usaha']); ?></p>
                                <?php } ?>
                                <?php if (!empty($data_perusahaan['jumlah_karyawan'])) { ?>
                                    <p><i class="fa fa-users"></i> <b>Jumlah Karyawan:</b>
                                        <?php echo htmlspecialchars($data_perusahaan['jumlah_karyawan']); ?></p>
                                <?php } ?>
                            </div>

                            <div class="company-desc">
                                <?php
                                if (!empty($data_perusahaan['deskripsi_perusahaan'])) {
                                    echo nl2br(htmlspecialchars($data_perusahaan['deskripsi_perusahaan']));
                                } else {
                                    echo "<em style='color:#999;'>Deskripsi perusahaan belum tersedia.</em>";
                                }
                                ?>
                                <br><br>
                                <div
                                    style="background:linear-gradient(135deg, #f8f9ff 0%, #e8ecf1 100%); padding:15px 20px; border-radius:12px; border:2px solid #e8ecf1;">
                                    <b>📧 Email:</b>
                                    <?php echo !empty($data_perusahaan['email']) ? htmlspecialchars($data_perusahaan['email']) : '-'; ?><br>
                                    <b>📍 Alamat:</b>
                                    <?php echo !empty($data_perusahaan['alamat']) ? htmlspecialchars($data_perusahaan['alamat']) : '-'; ?>

                                    <!-- ✅ SOSIAL MEDIA (DITAMBAHKAN DI SINI) -->
                                    <?php if (isset($sql_sosmed) && $sql_sosmed && mysqli_num_rows($sql_sosmed) > 0): ?>
                                        <hr style="margin:15px 0; border:none; border-top:2px solid #e8ecf1;">
                                        <b style="display:block; margin-bottom:10px; color:#667eea;">🌐 Sosial Media:</b>
                                        <div class="sosmed-container">
                                            <?php while ($sosmed = mysqli_fetch_assoc($sql_sosmed)): ?>
                                                <?php
                                                // Tentukan class berdasarkan platform
                                                $platform = strtolower($sosmed['nama_platform']);
                                                $sosmed_class = 'sosmed-default';
                                                $icon = 'fa-link';

                                                if (strpos($platform, 'facebook') !== false) {
                                                    $sosmed_class = 'sosmed-facebook';
                                                    $icon = 'fa-facebook';
                                                } elseif (strpos($platform, 'instagram') !== false) {
                                                    $sosmed_class = 'sosmed-instagram';
                                                    $icon = 'fa-instagram';
                                                } elseif (strpos($platform, 'twitter') !== false || strpos($platform, 'x.com') !== false) {
                                                    $sosmed_class = 'sosmed-twitter';
                                                    $icon = 'fa-twitter';
                                                } elseif (strpos($platform, 'linkedin') !== false) {
                                                    $sosmed_class = 'sosmed-linkedin';
                                                    $icon = 'fa-linkedin';
                                                } elseif (strpos($platform, 'youtube') !== false) {
                                                    $sosmed_class = 'sosmed-youtube';
                                                    $icon = 'fa-youtube';
                                                } elseif (strpos($platform, 'tiktok') !== false) {
                                                    $sosmed_class = 'sosmed-tiktok';
                                                    $icon = 'fa-music';
                                                } elseif (strpos($platform, 'whatsapp') !== false) {
                                                    $sosmed_class = 'sosmed-whatsapp';
                                                    $icon = 'fa-whatsapp';
                                                }
                                                ?>
                                                <a href="<?php echo htmlspecialchars($sosmed['link']); ?>" target="_blank"
                                                    class="sosmed-link <?php echo $sosmed_class; ?>">
                                                    <i class="fa <?php echo $icon; ?>"></i>
                                                    <span><?php echo htmlspecialchars($sosmed['nama_platform']); ?></span>
                                                </a>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- ✅ AKHIR SOSIAL MEDIA -->

                                </div>
                            </div>
                            <br>

                            <div class="company-benefit">
                                <h5 style="margin:0 0 10px 0; font-size:16px; color:#2d3748;">
                                    <b><i class="fa fa-gift" style="color:#e91e63;"></i> Manfaat dan Keuntungan</b>
                                </h5>
                                <?php
                                if (!empty($data_perusahaan['manfaat'])) {
                                    $manfaat = explode(",", $data_perusahaan['manfaat']);
                                    echo "<ul>";
                                    foreach ($manfaat as $m) {
                                        echo "<li>" . htmlspecialchars(trim($m)) . "</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p style='color:#999; font-size:13px; margin:0;'>Belum ada informasi manfaat.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- TOMBOL DAFTAR -->
                        <div style="margin-top:30px; padding-top:25px; border-top:3px solid #e8ecf1;">
                            <a href="?halaman=daftar&kode=<?php echo $data_detail['id_lowongan']; ?>"
                                class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> DAFTAR SEKARANG
                            </a>
                            <p style="font-size:13px; color:#888; margin-top:12px;">
                                <i class="fa fa-info-circle"></i> Klik tombol di atas untuk mengirim lamaran
                            </p>
                        </div> 

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Auto-scroll ke item yang aktif
    document.addEventListener('DOMContentLoaded', function () {
        var activeItem = document.querySelector('.job-item.active');
        if (activeItem) {
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
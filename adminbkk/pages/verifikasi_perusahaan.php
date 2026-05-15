<?php
require_once "koneksi.php";

/* ===========================
   STATISTIK
=========================== */
$total = mysqli_num_rows(mysqli_query($con, "
    SELECT * FROM tb_user WHERE role='perusahaan'
"));

$belum = mysqli_num_rows(mysqli_query($con, "
    SELECT * FROM tb_perusahaan WHERE status_verifikasi='Belum Diverifikasi'
"));

$verif = mysqli_num_rows(mysqli_query($con, "
    SELECT * FROM tb_perusahaan WHERE status_verifikasi='Terverifikasi'
"));

$ajukan = mysqli_num_rows(mysqli_query($con, "
    SELECT p.id_perusahaan
    FROM tb_perusahaan p
    INNER JOIN tb_dokumen_perusahaan d ON p.id_perusahaan = d.id_perusahaan
    WHERE p.status_verifikasi = 'Belum Diverifikasi'
    AND d.file_nib IS NOT NULL AND d.file_nib != ''
    AND d.file_npwp IS NOT NULL AND d.file_npwp != ''
    AND d.file_mou IS NOT NULL AND d.file_mou != ''
"));

/* ===========================
   QUERY FIX SESUAI DATABASE
=========================== */
$query = mysqli_query($con, "
SELECT 
    u.username,

    p.id_perusahaan,
    p.id_user,
    p.nama_perusahaan,
    p.email,
    p.alamat,
    p.bidang_usaha,
    p.jumlah_karyawan,
    p.deskripsi,
    p.manfaat,
    p.logo,
    p.status_verifikasi,

    d.nib,
    d.npwp,
    d.mou,
    d.file_nib,
    d.file_npwp,
    d.file_mou,

    MAX(CASE WHEN sm.nama_platform='instagram' THEN sm.link END) as instagram,
    MAX(CASE WHEN sm.nama_platform='linkedin' THEN sm.link END) as linkedin,
    MAX(CASE WHEN sm.nama_platform='facebook' THEN sm.link END) as facebook,
    MAX(CASE WHEN sm.nama_platform='website' THEN sm.link END) as website

FROM tb_user u
JOIN tb_perusahaan p ON u.id_user = p.id_user
LEFT JOIN tb_dokumen_perusahaan d ON p.id_perusahaan = d.id_perusahaan
LEFT JOIN tb_sosial_media sm ON sm.id_user = u.id_user

WHERE u.role='perusahaan'

GROUP BY 
    u.username,
    p.id_perusahaan,
    p.id_user,
    p.nama_perusahaan,
    p.email,
    p.alamat,
    p.bidang_usaha,
    p.jumlah_karyawan,
    p.deskripsi,
    p.manfaat,
    p.logo,
    p.status_verifikasi,

    d.nib,
    d.npwp,
    d.mou,
    d.file_nib,
    d.file_npwp,
    d.file_mou
");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* ===== GLOBAL ===== */
    body {
        background: #f4f7fb;
        font-family: 'Segoe UI', sans-serif;
    }

    /* ===== DASHBOARD CARD ===== */
    .dashboard {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .stat {
        flex: 1;
        min-width: 220px;
        padding: 25px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
    }

    .stat:hover {
        transform: translateY(-3px);
    }

    .stat.total {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .stat.belum {
        background: linear-gradient(135deg, #f7971e, #ffd200);
    }

    .stat.verif {
        background: linear-gradient(135deg, #43e97b, #38f9d7);
    }

    .stat h2 {
        margin-top: 10px;
        font-size: 28px;
    }

    /* ===== SEARCH FILTER ===== */
    .search-filter {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-box input {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        outline: none;
        width: 220px;
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: #2196f3;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.15);
    }

    .filter select {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    /* ===== LAYOUT ===== */
    .verifikasi-layout {
        display: flex;
        gap: 25px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    /* ===== COMPANY LIST ===== */
    .company-list {
        flex: 1;
        min-width: 320px;
        max-height: 700px;
        overflow-y: auto;
        padding-right: 5px;
    }

    /* ===== COMPANY CARD ===== */
    .company-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: 0.25s;
        border-left: 4px solid #2196f3;
    }

    .company-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .company-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .company-header h4 {
        font-size: 15px;
        margin: 0;
    }

    .company-info {
        font-size: 13px;
        color: #666;
    }

    .company-info i {
        margin-right: 5px;
        color: #999;
    }

    /* ===== BADGE ===== */
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }

    .badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .badge.success {
        background: #d4edda;
        color: #155724;
    }

    .badge.danger {
        background: #f8d7da;
        color: #721c24;
    }

    /* ===== DETAIL PANEL ===== */
    .perusahaan-detail {
        flex: 1;
        min-width: 350px;
    }

    .detail-card {
        background: white;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        position: relative;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .detail-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-title i {
        font-size: 22px;
        color: #2196f3;
    }

    .detail-title h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    /* ===== ACTION BUTTON ===== */
    .btn-action {
        padding: 8px 14px;
        border-radius: 7px;
        font-size: 13px;
        color: white;
        text-decoration: none;
        font-weight: 500;
    }

    .btn-action.verif {
        background: #4caf50;
    }

    .btn-action.tolak {
        background: #f44336;
    }

    /* ===== PROFILE GRID ===== */
    .profile-grid {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 10px 20px;
        margin-top: 10px;
    }

    .label {
        font-weight: 600;
        color: #666;
        font-size: 13px;
    }

    .value {
        color: #333;
        font-size: 14px;
    }

    /* ===== DOCUMENT SECTION ===== */
    .doc-section {
        border-top: 1px solid #eee;
        margin-top: 20px;
        padding-top: 15px;
    }

    .doc-grid {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 12px;
    }

    .doc-card {
        flex: 1;
        min-width: 120px;
        background: #f9fafc;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        border: 1px solid #eee;
        transition: 0.25s;
    }

    .doc-card:hover {
        background: #f0f6ff;
    }

    .doc-icon {
        font-size: 26px;
        color: #2196f3;
        margin-bottom: 6px;
    }

    .doc-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .doc-btn {
        display: inline-block;
        padding: 6px 10px;
        background: #2196f3;
        color: white;
        border-radius: 6px;
        font-size: 12px;
        text-decoration: none;
    }

    /* ===== SCROLLBAR ===== */
    .company-list::-webkit-scrollbar {
        width: 6px;
    }

    .company-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    /* ===== RESPONSIVE ===== */
    @media(max-width:900px) {

        .verifikasi-layout {
            flex-direction: column;
        }

        .company-list {
            max-height: 400px;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

    }

    /* EMPTY STATE PANEL */
    .empty-state {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-radius: 14px;
        z-index: 5;
        color: #777;
        pointer-events: none;
    }

    .empty-state i {
        font-size: 60px;
        color: #2196f3;
        margin-bottom: 15px;
    }

    .empty-state h3 {
        margin-bottom: 10px;
        font-weight: 600;
    }

    .perusahaan-detail {
        position: relative;
    }

    /* PROFILE DETAIL MODERN */
    .profile-grid {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 10px 10px;
        margin-top: 12px;
        align-items: center;
    }

    .profile-grid .label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #444;
    }

    .profile-grid .label i {
        color: #2196f3;
        width: 18px;
    }

    .profile-grid .value {
        color: #555;
        font-size: 14px;
    }

    .profile-grid .value:empty::after {
        content: "-";
        color: #bbb;
    }

    .company-logo {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #f1f1f1;
        background: #fff;
    }

    .detail-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .deskripsi-box {
        background: #f8fafc;
        border-left: 4px solid #2196f3;
        padding: 12px 15px;
        border-radius: 8px;
        line-height: 1.6;
        color: #555;
    }

    .empty-company {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin: 120px auto;
    }

    .empty-company i {
        font-size: 70px;
        color: #2d8cff;
        margin-bottom: 15px;
    }

    .empty-company h3 {
        font-size: 26px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .empty-company p {
        color: #777;
        font-size: 15px;
    }

    .stat.ajukan {
        background: linear-gradient(135deg, #ff7e5f, #ffb347);
    }

    /* ========================================
   📱 RESPONSIVE MOBILE - VERIFIKASI PERUSAHAAN
   ======================================== */
    /* Base mobile settings */
    @media (max-width: 991px) {

        /* Prevent horizontal scroll */
        html,
        body {
            overflow-x: hidden !important;
            width: 100% !important;
        }

        /* Dashboard Cards - Stack */
        .dashboard {
            flex-direction: column !important;
            gap: 15px !important;
        }

        .stat {
            width: 100% !important;
            min-width: auto !important;
            padding: 20px !important;
            text-align: center !important;
        }

        .stat h2 {
            font-size: 32px !important;
            margin-top: 8px !important;
        }

        .stat i {
            font-size: 24px !important;
            display: block !important;
            margin-bottom: 8px !important;
        }

        /* Search & Filter */
        .search-filter {
            flex-direction: column !important;
            gap: 12px !important;
        }

        .search-box input {
            width: 100% !important;
            max-width: none !important;
        }

        .filter select {
            width: 100% !important;
        }

        /* Main Layout */
        .verifikasi-layout {
            flex-direction: column !important;
            gap: 20px !important;
        }

        .company-list {
            width: 100% !important;
            min-width: auto !important;
            max-height: 350px !important;
            padding-right: 0 !important;
        }

        .perusahaan-detail {
            width: 100% !important;
            min-width: auto !important;
        }

        /* Company Card */
        .company-card {
            padding: 14px !important;
            margin-bottom: 10px !important;
        }

        .company-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
        }

        .company-header h4 {
            font-size: 16px !important;
        }

        .company-header>div:last-child {
            align-items: flex-start !important;
            width: 100% !important;
        }

        .badge {
            padding: 3px 8px !important;
            font-size: 10px !important;
        }

        .company-info {
            font-size: 13px !important;
        }

        /* Detail Panel */
        .detail-card {
            padding: 20px !important;
        }

        .detail-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 15px !important;
            margin-bottom: 15px !important;
        }

        .detail-title {
            gap: 10px !important;
        }

        .detail-title h3 {
            font-size: 18px !important;
        }

        .company-logo {
            width: 40px !important;
            height: 40px !important;
        }

        .detail-action {
            display: flex !important;
            gap: 10px !important;
            width: 100% !important;
        }

        .btn-action {
            flex: 1 !important;
            text-align: center !important;
            padding: 10px 12px !important;
            font-size: 13px !important;
        }

        /* Profile Grid */
        .profile-grid {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }

        .profile-grid .label {
            padding: 8px 0 !important;
            border-bottom: 1px solid #f1f1f1 !important;
        }

        .profile-grid .value {
            padding: 8px 0 !important;
            border-bottom: 1px solid #f1f1f1 !important;
        }

        /* Documents */
        .doc-grid {
            flex-direction: column !important;
            gap: 10px !important;
        }

        .doc-card {
            min-width: auto !important;
            padding: 12px !important;
        }

        .doc-icon {
            font-size: 22px !important;
        }

        .doc-title {
            font-size: 13px !important;
        }

        .doc-btn {
            padding: 5px 12px !important;
            font-size: 11px !important;
        }

        /* Empty States */
        .empty-company {
            margin: 60px auto !important;
            padding: 0 20px !important;
        }

        .empty-company i {
            font-size: 50px !important;
        }

        .empty-company h3 {
            font-size: 20px !important;
        }

        .empty-company p {
            font-size: 14px !important;
        }

        .empty-state {
            padding: 40px 20px !important;
        }

        .empty-state i {
            font-size: 45px !important;
        }

        .empty-state h3 {
            font-size: 18px !important;
        }

        .empty-state p {
            font-size: 13px !important;
        }

        /* Scrollbar mobile */
        .company-list::-webkit-scrollbar {
            width: 4px !important;
        }
    }


    /* Touch Device Optimizations */
    @media (hover: none) and (pointer: coarse) {

        /* Larger touch targets */
        .company-card,
        .btn-action,
        .doc-btn,
        .search-box input,
        .filter select {
            min-height: 44px !important;
        }

        /* Prevent zoom on input focus */
        input,
        select,
        textarea {
            font-size: 16px !important;
        }

        /* Remove hover effects on touch */
        .stat:hover,
        .company-card:hover,
        .doc-card:hover {
            transform: none !important;
        }

        /* Add active state feedback */
        .company-card:active,
        .btn-action:active,
        .doc-btn:active {
            opacity: 0.85 !important;
        }

        /* Ensure clickable areas */
        a,
        button {
            -webkit-tap-highlight-color: transparent;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        body {
            background: #0f172a !important;
            color: #f1f5f9 !important;
        }

        .stat {
            color: #fff !important;
        }

        .search-box input,
        .filter select {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }

        .search-box input::placeholder {
            color: #64748b !important;
        }

        .company-card,
        .detail-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        .company-header h4,
        .detail-title h3,
        .profile-grid .value {
            color: #f1f5f9 !important;
        }

        .company-info,
        .profile-grid .label,
        #dBidangHeader {
            color: #94a3b8 !important;
        }

        .doc-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        .empty-state,
        .empty-company {
            background: #1e293b !important;
            color: #cbd5e1 !important;
        }

        .badge.pending {
            background: #78350f !important;
            color: #fbbf24 !important;
        }

        .badge.success {
            background: #065f46 !important;
            color: #6ee7b7 !important;
        }

        .badge.danger {
            background: #7f1d1d !important;
            color: #fca5a5 !important;
        }
    }

    /* Reduced Motion Preference */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        .stat:hover,
        .company-card:hover,
        .doc-card:hover {
            transform: none !important;
        }
    }

    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .company-card {
            border-width: 3px !important;
        }

        .badge {
            border: 2px solid currentColor !important;
        }

        .btn-action {
            border: 2px solid currentColor !important;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background: #fff !important;
            color: #000 !important;
        }

        .search-filter,
        .btn-action,
        .doc-btn {
            display: none !important;
        }

        .company-list {
            max-height: none !important;
            overflow: visible !important;
        }

        .company-card,
        .detail-card {
            break-inside: avoid !important;
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .stat {
            break-inside: avoid !important;
            color: #000 !important;
        }
    }

    /* Accessibility: Focus Visible */
    @media (prefers-reduced-motion: no-preference) {

        .search-box input:focus,
        .filter select:focus,
        .btn-action:focus,
        .doc-btn:focus {
            outline: 2px solid #2196f3 !important;
            outline-offset: 2px !important;
        }
    }

    /* Prevent text overflow on small screens */
    @media (max-width: 480px) {

        .company-header h4,
        .detail-title h3,
        .profile-grid .value,
        .doc-title {
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            hyphens: auto !important;
        }

        .company-info p {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: 100% !important;
        }
    }

    /* Fix for iOS Safari viewport height */
    @supports (-webkit-touch-callout: none) {
        @media (max-width: 767px) {
            .company-list {
                max-height: calc(100vh - 300px) !important;
            }
        }
    }
</style>

<div class="dashboard">

    <div class="stat total">
        <i class="fa fa-building"></i> Total Perusahaan<br>
        <h2><?= isset($total) ? $total : 0; ?></h2>
    </div>

    <div class="stat belum">
        <i class="fa fa-clock"></i> Belum Diverifikasi<br>
        <h2><?= isset($belum) ? $belum : 0; ?></h2>
    </div>

    <div class="stat ajukan">
        <i class="fa fa-paper-plane"></i> Mengajukan Verifikasi<br>
        <h2><?= isset($ajukan) ? $ajukan : 0; ?></h2>
    </div>

    <div class="stat verif">
        <i class="fa fa-check-circle"></i> Terverifikasi<br>
        <h2><?= isset($verif) ? $verif : 0; ?></h2>
    </div>

</div>


<div class="search-filter">

    <div class="search-box">
        <input type="text" id="search" placeholder="Cari perusahaan..." value="">
    </div>

    <div class="filter">
        <select id="filterStatus">
            <option value="">Semua Status</option>
            <option value="Belum Diverifikasi">Belum Diverifikasi</option>
            <option value="Terverifikasi">Terverifikasi</option>
            <option value="Ditolak">Ditolak</option>
            <option value="ajukan">Sudah Mengajukan Verifikasi</option>
            <option value="lengkap">Profil Lengkap</option>
        </select>
    </div>

</div>


<div id="emptyCompany" class="empty-company" style="display:none;">

    <i class="fa fa-building"></i>

    <h3>Belum ada perusahaan</h3>

    <p id="emptyText">
        Data perusahaan dengan status ini belum tersedia.
    </p>

</div>

<!-- KIRI : LIST PERUSAHAAN -->
<div class="verifikasi-layout">

    <!-- KIRI : LIST PERUSAHAAN -->
    <div class="company-list" id="companyList">

        <?php
        $no = 1;
        while ($d = mysqli_fetch_assoc($query)) {

            // AMANKAN DATA (ANTI ERROR)
            $nama_perusahaan = $d['nama_perusahaan'] ?? '';
            $email = $d['email'] ?? '';
            $alamat = $d['alamat'] ?? '';
            $bidang_usaha = $d['bidang_usaha'] ?? '';
            $jumlah_karyawan = $d['jumlah_karyawan'] ?? '';
            $deskripsi = $d['deskripsi'] ?? '';
            $manfaat = $d['manfaat'] ?? '';

            $website = $d['website'] ?? '';
            $instagram = $d['instagram'] ?? '';
            $linkedin = $d['linkedin'] ?? '';
            $facebook = $d['facebook'] ?? '';

            $nib = $d['nib'] ?? '';
            $npwp = $d['npwp'] ?? '';
            $mou = $d['mou'] ?? '';

            $file_nib = $d['file_nib'] ?? '';
            $file_npwp = $d['file_npwp'] ?? '';
            $file_mou = $d['file_mou'] ?? '';

            $logo = $d['logo'] ?? '';
            $status_verifikasi = $d['status_verifikasi'] ?? '';

            // CEK PROFIL
            $profil_lengkap = true;

            if (
                empty($nama_perusahaan) ||
                empty($email) ||
                empty($alamat) ||
                empty($bidang_usaha) ||
                empty($jumlah_karyawan) ||
                empty($deskripsi) ||
                empty($manfaat) ||
                empty($file_nib) ||
                empty($file_npwp) ||
                empty($file_mou)
            ) {
                $profil_lengkap = false;
            }

            $status_ajukan = ($profil_lengkap && $status_verifikasi == "Belum Diverifikasi") ? "ya" : "tidak";
            $lengkap = $profil_lengkap ? "ya" : "tidak";
            ?>

            <div class="company-card" data-nama="<?= strtolower($nama_perusahaan); ?>"
                data-email="<?= strtolower($email); ?>" data-status="<?= strtolower($status_verifikasi); ?>"
                data-ajukan="<?= $status_ajukan; ?>" data-lengkap="<?= $lengkap; ?>" onclick='showDetail(
<?= json_encode($d["username"] ?? "") ?>,
<?= json_encode($nama_perusahaan) ?>,
<?= json_encode($email) ?>,
<?= json_encode($alamat) ?>,
<?= json_encode($bidang_usaha) ?>,
<?= json_encode($jumlah_karyawan) ?>,
<?= json_encode($deskripsi) ?>,
<?= json_encode($manfaat) ?>,
<?= json_encode($website) ?>,
<?= json_encode($instagram) ?>,
<?= json_encode($linkedin) ?>,
<?= json_encode($facebook) ?>,
<?= json_encode($nib) ?>,
<?= json_encode($npwp) ?>,
<?= json_encode($mou) ?>,
<?= json_encode($file_nib) ?>,
<?= json_encode($file_npwp) ?>,
<?= json_encode($file_mou) ?>,
<?= json_encode($logo) ?>
)'>

                <div class="company-header">

                    <h4><?= $nama_perusahaan; ?></h4>

                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;">

                        <?php
                        if ($status_verifikasi == "Terverifikasi") {
                            echo "<span class='badge success'>✔ Terverifikasi</span>";
                        } elseif ($status_verifikasi == "Ditolak") {
                            echo "<span class='badge danger'>✖ Ditolak</span>";
                        } else {
                            echo "<span class='badge pending'>⏳ Belum Diverifikasi</span>";
                        }
                        ?>

                        <?php
                        if ($profil_lengkap) {
                            echo "<span class='badge success'>✔ Profil Lengkap</span>";
                        }

                        if ($profil_lengkap && $status_verifikasi == "Belum Diverifikasi") {
                            echo "<span class='badge pending'>📩 Telah Mengajukan Verifikasi</span>";
                        }
                        ?>

                    </div>

                </div>

                <div class="company-info">

                    <p><i class="fa fa-envelope"></i> <?= $email; ?></p>
                    <p><i class="fa fa-map-marker"></i> <?= $alamat; ?></p>

                </div>

            </div>

        <?php } ?>

    </div>


    <!-- KANAN : PROFIL PERUSAHAAN -->
    <div class="perusahaan-detail">

        <div class="detail-card" id="detailPanel">
            <div id="emptyState" class="empty-state">
                <i class="fa fa-building"></i>
                <h3>Pilih Perusahaan</h3>
                <p>Klik perusahaan di sebelah kiri untuk melihat detail profil perusahaan</p>
            </div>

            <div class="detail-header">

                <div class="detail-title">

                    <img id="logoPerusahaan" src="dist/img/company.png" class="company-logo" alt="Logo Perusahaan">

                    <div>
                        <h3 id="dNama">Pilih Perusahaan</h3>
                        <small id="dBidangHeader" style="color:#777;">-</small>
                    </div>

                </div>

                <div class="detail-action">

                    <a id="btnVerif" class="btn-action verif" href="#">
                        <i class="fa fa-check"></i> Verifikasi
                    </a>

                    <a id="btnTolak" class="btn-action tolak" href="#">
                        <i class="fa fa-times"></i> Tolak
                    </a>

                </div>

            </div>


            <div class="detail-content">

                <div class="profile-grid">

                    <div class="label">Username</div>
                    <div class="value" id="dUsername">-</div>

                    <div class="label">Email</div>
                    <div class="value" id="dEmail">-</div>

                    <div class="label">Alamat</div>
                    <div class="value" id="dAlamat">-</div>

                    <div class="label">Bidang Perusahaan</div>
                    <div class="value" id="dBidang">-</div>

                    <div class="label">Jumlah Karyawan</div>
                    <div class="value" id="dKaryawan">-</div>

                    <div class="label">Deskripsi</div>
                    <div class="value" id="dDeskripsi">-</div>

                    <div class="label">Manfaat</div>
                    <div class="value" id="dManfaat">-</div>

                </div>

            </div>


            <hr>

            <h4><i class="fa fa-share-alt"></i> Sosial Media</h4>

            <div class="profile-grid">

                <div class="label">Website</div>
                <div class="value" id="dWebsite">-</div>

                <div class="label">Instagram</div>
                <div class="value" id="dInstagram">-</div>

                <div class="label">LinkedIn</div>
                <div class="value" id="dLinkedin">-</div>

                <div class="label">Facebook</div>
                <div class="value" id="dFacebook">-</div>

            </div>


            <div class="doc-section">

                <h4>
                    <i class="fa fa-file"></i> Dokumen Perusahaan
                </h4>

                <div class="doc-grid">

                    <div class="doc-card">

                        <div class="doc-icon">
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="doc-title">
                            NIB / SIUP
                        </div>

                        <a id="dNIB" target="_blank" class="doc-btn" href="#">
                            Lihat Dokumen
                        </a>
                        <div id="msgNIB" style="font-size:12px;color:red;margin-top:5px;"></div>

                    </div>


                    <div class="doc-card">

                        <div class="doc-icon">
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="doc-title">
                            NPWP
                        </div>

                        <a id="dNPWP" target="_blank" class="doc-btn" href="#">
                            Lihat Dokumen
                        </a>
                        <div id="msgNPWP" style="font-size:12px;color:red;margin-top:5px;"></div>

                    </div>

                    <div class="doc-card">

                        <div class="doc-icon">
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="doc-title">
                            MOU
                        </div>

                        <a id="dMOU" target="_blank" class="doc-btn" href="#">
                            Lihat Dokumen
                        </a>

                        <div id="msgMOU" style="font-size:12px;color:red;margin-top:5px;"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
<script>

    function showDetail(
        username, nama_perusahaan, email, alamat, bidang_usaha, karyawan, deskripsi, manfaat,
        website, instagram, linkedin, facebook,
        nib, npwp, mou,
        file_nib, file_npwp, file_mou,
        logo
    ) {

        // ========================
        // HILANGKAN EMPTY STATE
        // ========================
        let empty = document.getElementById("emptyState");
        if (empty) empty.style.display = "none";

        // ========================
        // LOGO
        // ========================
        let logoEl = document.getElementById("logoPerusahaan");
        if (logoEl) {
            if (logo && logo !== "") {
                logoEl.src = "dist/img/foto_perusahaan/" + logo;
            } else {
                logoEl.src = "dist/img/company.png";
            }
        }

        // ========================
        // HEADER
        // ========================
        let bidangHeader = document.getElementById("dBidangHeader");
        if (bidangHeader) bidangHeader.innerText = bidang_usaha || "-";

        // ========================
        // DATA UTAMA
        // ========================
        setText("dNama", nama_perusahaan);
        setText("dUsername", username);
        setText("dEmail", email);
        setText("dAlamat", alamat);
        setText("dBidang", bidang_usaha);
        setText("dKaryawan", karyawan);
        setText("dDeskripsi", deskripsi);
        setText("dManfaat", manfaat);

        // ========================
        // SOSIAL MEDIA (FIX NULL)
        // ========================
        setText("dWebsite", website || "-");
        setText("dInstagram", instagram || "-");
        setText("dLinkedin", linkedin || "-");
        setText("dFacebook", facebook || "-");

        // ========================
        // DOKUMEN LINK
        // ========================
        setupFile("dNIB", file_nib, "msgNIB", "Dokumen NIB belum diupload");
        setupFile("dNPWP", file_npwp, "msgNPWP", "Dokumen NPWP belum diupload");
        setupFile("dMOU", file_mou, "msgMOU", "Dokumen MOU belum diupload");

        // ========================
        // BUTTON AKSI (AMAN)
        // ========================
        let btnVerif = document.getElementById("btnVerif");
        let btnTolak = document.getElementById("btnTolak");

        if (btnVerif) {
            btnVerif.href = "?halaman=proses_verifikasi&username=" + encodeURIComponent(username) + "&aksi=verifikasi";
        }

        if (btnTolak) {
            btnTolak.href = "?halaman=proses_verifikasi&username=" + encodeURIComponent(username) + "&aksi=tolak";
        }

    }


    // ========================
    // HELPER SET TEXT (ANTI ERROR)
    // ========================
    function setText(id, value) {
        let el = document.getElementById(id);
        if (el) {
            el.innerText = (value !== undefined && value !== null && value !== "") ? value : "-";
        }
    }


    // ========================
    // HELPER FILE (LEBIH AMAN)
    // ========================
    function setupFile(id, file, msgId, pesan) {

        let btn = document.getElementById(id);
        let msg = document.getElementById(msgId);

        if (!btn) return;

        if (msg) msg.innerText = "";

        if (file && file !== "" && file !== "null") {

            btn.href = "dokumen/" + file;
            btn.onclick = null;

        } else {

            btn.href = "#";

            btn.onclick = function (e) {
                e.preventDefault();
                if (msg) msg.innerText = pesan;
            };

        }
    }


    // ========================
    // SEARCH (ANTI ERROR NULL)
    // ========================
    let searchEl = document.getElementById("search");

    if (searchEl) {
        searchEl.addEventListener("keyup", function () {

            let keyword = this.value.toLowerCase();
            let cards = document.querySelectorAll(".company-card");

            cards.forEach(function (card) {

                let name = card.dataset.nama || "";
                let email = card.dataset.email || "";

                card.style.display = (name.includes(keyword) || email.includes(keyword)) ? "block" : "none";

            });

        });
    }


    // ========================
    // FILTER (FIX CASE SENSITIVITY)
    // ========================
    let filterEl = document.getElementById("filterStatus");

    if (filterEl) {
        filterEl.addEventListener("change", function () {

            let status = this.value.toLowerCase();
            let cards = document.querySelectorAll(".company-card");

            let emptyBox = document.getElementById("emptyCompany");
            let detailPanel = document.querySelector(".perusahaan-detail");

            let visibleCount = 0;

            cards.forEach(function (card) {

                let cardStatus = (card.dataset.status || "").toLowerCase();
                let ajukan = card.dataset.ajukan || "";
                let lengkap = card.dataset.lengkap || "";

                if (status === "") {
                    card.style.display = "block";
                    visibleCount++;
                }

                else if (status === "ajukan") {
                    if (ajukan === "ya") {
                        card.style.display = "block";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                }

                else if (status === "lengkap") {
                    if (lengkap === "ya") {
                        card.style.display = "block";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                }

                else {
                    if (cardStatus === status) {
                        card.style.display = "block";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                }

            });

            if (emptyBox && detailPanel) {
                if (visibleCount === 0) {
                    emptyBox.style.display = "block";
                    detailPanel.style.display = "none";
                } else {
                    emptyBox.style.display = "none";
                    detailPanel.style.display = "block";
                }
            }

        });
    }


    // ========================
    // ICON LABEL (ANTI DOUBLE ICON)
    // ========================
    document.querySelectorAll(".label").forEach(function (label) {

        if (label.querySelector("i")) return; // cegah dobel icon

        let text = label.innerText.toLowerCase();
        let icon = "";

        if (text.includes("username")) icon = "fa-user";
        else if (text.includes("email")) icon = "fa-envelope";
        else if (text.includes("alamat")) icon = "fa-location-dot";
        else if (text.includes("bidang")) icon = "fa-briefcase";
        else if (text.includes("karyawan")) icon = "fa-users";
        else if (text.includes("deskripsi")) icon = "fa-file-lines";
        else if (text.includes("website")) icon = "fa-globe";
        else if (text.includes("instagram")) icon = "fa-instagram";
        else if (text.includes("linkedin")) icon = "fa-linkedin";
        else if (text.includes("facebook")) icon = "fa-facebook";

        if (icon !== "") {
            label.innerHTML = '<i class="fa ' + icon + '"></i> ' + label.innerText;
        }

    });

</script>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("koneksi.php");

// Validasi parameter
$id_perusahaan = isset($_GET['id']) ? mysqli_real_escape_string($con, $_GET['id']) : '';

if (empty($id_perusahaan)) {
    echo "<script>alert('ID perusahaan tidak valid!'); window.history.back();</script>";
    exit;
}

// Ambil data perusahaan + user
$sql = "SELECT 
            p.*,
            u.username,
            u.email as email_user,
            u.nama as nama_user,
            u.status
        FROM tb_perusahaan p
        INNER JOIN tb_user u ON p.id_user = u.id_user
        WHERE p.id_perusahaan = '$id_perusahaan'
        LIMIT 1";

$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data perusahaan tidak ditemukan!'); window.history.back();</script>";
    exit;
}

$data = mysqli_fetch_assoc($result);
$id_user = $data['id_user'];

// Ambil data sosial media
$sosial = mysqli_query($con, "
    SELECT * FROM tb_sosial_media 
    WHERE id_user = '$id_user'
    ORDER BY id_sosial_media ASC
");

// Ambil data dokumen
$dokumen = mysqli_fetch_assoc(mysqli_query($con, "
    SELECT * FROM tb_dokumen_perusahaan 
    WHERE id_perusahaan = '$id_perusahaan'
"));
?>

<style>
    /* Page Header */
    .page-header-detail {
        background: white;
        padding: 20px 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title-detail {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-title-detail i {
        font-size: 32px;
        color: #667eea;
    }

    .page-title-detail h1 {
        font-size: 28px;
        color: #2d3748;
        font-weight: 700;
        margin: 0;
    }

    .btn-back-detail {
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

    .btn-back-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Main Card */
    .main-card-detail {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
        margin-bottom: 25px;
    }

    /* Company Header */
    .company-header-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .company-header-detail::before {
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

    .company-logo-detail {
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
    }

    .company-name-detail {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .company-status-detail {
        display: inline-block;
        padding: 8px 25px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 1;
    }

    .status-active-detail {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .status-inactive-detail {
        background: rgba(239, 68, 68, 0.9);
        color: white;
    }

    /* Content Sections */
    .content-section-detail {
        padding: 30px;
    }

    .section-title-detail {
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

    .section-title-detail i {
        color: #667eea;
    }

    /* Info Grid */
    .info-grid-detail {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item-detail {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid #667eea;
    }

    .info-item-detail:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
    }

    .info-label-detail {
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

    .info-label-detail i {
        color: #667eea;
        font-size: 16px;
    }

    .info-value-detail {
        font-size: 16px;
        color: #2d3748;
        font-weight: 600;
        word-break: break-word;
    }

    /* Social Media List */
    .sosmed-list-detail {
        display: grid;
        gap: 15px;
    }

    .sosmed-item-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .sosmed-item-detail:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .sosmed-platform-detail {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        font-size: 15px;
    }

    .sosmed-platform-detail i {
        font-size: 24px;
        color: #667eea;
    }

    .sosmed-link-detail a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .sosmed-link-detail a:hover {
        text-decoration: underline;
    }

    /* Document List */
    .doc-list-detail {
        display: grid;
        gap: 15px;
    }

    .doc-item-detail {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border-left: 4px solid #10b981;
        transition: all 0.3s ease;
    }

    .doc-item-detail:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .doc-info-detail {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .doc-info-detail i {
        font-size: 24px;
        color: #10b981;
    }

    .doc-name-detail {
        font-weight: 600;
        font-size: 15px;
    }

    .doc-download-detail a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .doc-download-detail a:hover {
        text-decoration: underline;
    }

    .empty-state-detail {
        text-align: center;
        padding: 40px;
        color: #9ca3af;
    }

    .empty-state-detail i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header-detail {
            flex-direction: column;
            text-align: center;
        }

        .company-header-detail {
            padding: 30px 20px;
        }

        .company-name-detail {
            font-size: 24px;
        }

        .content-section-detail {
            padding: 20px;
        }

        .info-grid-detail {
            grid-template-columns: 1fr;
        }

        .sosmed-item-detail,
        .doc-item-detail {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }

    @keyframes fadeInDetail {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .main-card-detail {
        animation: fadeInDetail 0.6s ease-out;
    }

    .logo-perusahaan-img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:50%;
}
</style>

<div class="page-header-detail">
    <div class="page-title-detail">
        <i class="fa fa-building"></i>
        <h1>Detail Perusahaan</h1>
    </div>
    <a href="javascript:history.back()" class="btn-back-detail">
        <i class="fa fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<!-- Main Card -->
<div class="main-card-detail">
    
    <!-- Company Header -->
    <div class="company-header-detail">
        <div class="company-logo-detail">

<?php if (!empty($data['logo']) && file_exists("dist/img/foto_perusahaan/" . $data['logo'])): ?>

    <img src="dist/img/foto_perusahaan/<?= htmlspecialchars($data['logo'] ?? '') ?>" 
         alt="Logo Perusahaan"
         class="logo-perusahaan-img">

<?php else: ?>

    <i class="fa fa-building"></i>

<?php endif; ?>

</div>
        <h2 class="company-name-detail"><?= htmlspecialchars($data['nama_perusahaan']); ?></h2>
        <span class="company-status-detail <?= $data['status'] == 'aktif' ? 'status-active-detail' : 'status-inactive-detail'; ?>">
            <i class="fa fa-<?= $data['status'] == 'aktif' ? 'check-circle' : 'times-circle'; ?>"></i>
            <?= ucfirst($data['status']); ?>
        </span>
    </div>

    <!-- Company Profile -->
    <div class="content-section-detail">
        <h3 class="section-title-detail">
            <i class="fa fa-building"></i>
            Profil Perusahaan
        </h3>
        <div class="info-grid-detail">
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-user"></i> Username
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['username']); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-user-circle"></i> Nama User
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['nama_user'] ?? '-'); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-envelope"></i> Email
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['email'] ?? $data['email_user'] ?? '-'); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-briefcase"></i> Bidang Usaha
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['bidang_usaha'] ?? '-'); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-users"></i> Jumlah Karyawan
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['jumlah_karyawan'] ?? '-'); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-map-marker-alt"></i> Kota
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['kota'] ?? '-'); ?></div>
            </div>
            <div class="info-item-detail" style="grid-column: 1 / -1;">
                <div class="info-label-detail">
                    <i class="fa fa-home"></i> Alamat Lengkap
                </div>
                <div class="info-value-detail"><?= nl2br(htmlspecialchars($data['alamat'] ?? '-')); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-phone"></i> No. HP
                </div>
                <div class="info-value-detail"><?= htmlspecialchars($data['no_hp'] ?? '-'); ?></div>
            </div>
            <div class="info-item-detail">
                <div class="info-label-detail">
                    <i class="fa fa-globe"></i> Website
                </div>
                <div class="info-value-detail">
                    <?php if (!empty($data['website'])): ?>
                        <a href="<?= htmlspecialchars($data['website']); ?>" target="_blank" style="color: #667eea;">
                            <?= htmlspecialchars($data['website']); ?>
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-item-detail" style="grid-column: 1 / -1;">
                <div class="info-label-detail">
                    <i class="fa fa-align-left"></i> Deskripsi
                </div>
                <div class="info-value-detail"><?= nl2br(htmlspecialchars($data['deskripsi'] ?? '-')); ?></div>
            </div>
            <div class="info-item-detail" style="grid-column: 1 / -1;">
                <div class="info-label-detail">
                    <i class="fa fa-gift"></i> Manfaat
                </div>
                <div class="info-value-detail"><?= nl2br(htmlspecialchars($data['manfaat'] ?? '-')); ?></div>
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div class="content-section-detail">
        <h3 class="section-title-detail">
            <i class="fa fa-share-alt"></i>
            Sosial Media
        </h3>
        <?php if (mysqli_num_rows($sosial) > 0): ?>
        <div class="sosmed-list-detail">
            <?php while ($row = mysqli_fetch_assoc($sosial)): ?>
            <div class="sosmed-item-detail">
                <div class="sosmed-platform-detail">
                    <i class="fa fa-<?= 
                        $row['nama_platform'] == 'instagram' ? 'instagram' :
                        ($row['nama_platform'] == 'linkedin' ? 'linkedin' :
                        ($row['nama_platform'] == 'facebook' ? 'facebook' :
                        ($row['nama_platform'] == 'twitter' ? 'twitter' :
                        ($row['nama_platform'] == 'github' ? 'github' :
                        ($row['nama_platform'] == 'whatsapp' ? 'whatsapp' : 'link')))))
                    ?>"></i>
                    <?= ucfirst(htmlspecialchars($row['nama_platform'])); ?>
                </div>
                <div class="sosmed-link-detail">
                    <?php if (!empty($row['link'])): ?>
                        <a href="<?= htmlspecialchars($row['link']); ?>" target="_blank">
                            <?= htmlspecialchars($row['link']); ?>
                        </a>
                    <?php else: ?>
                        <span style="color: #9ca3af;">-</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty-state-detail">
            <i class="fa fa-share-alt"></i>
            <p>Belum ada sosial media yang ditambahkan</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Dokumen -->
    <div class="content-section-detail">
        <h3 class="section-title-detail">
            <i class="fa fa-file-alt"></i>
            Dokumen Perusahaan
        </h3>
        <?php if ($dokumen && (!empty($dokumen['file_nib']) || !empty($dokumen['file_npwp']) || !empty($dokumen['file_mou']))): ?>
        <div class="doc-list-detail">
            <?php if (!empty($dokumen['file_nib'])): ?>
            <div class="doc-item-detail">
                <div class="doc-info-detail">
                    <i class="fa fa-file-pdf"></i>
                    <div>
                        <div class="doc-name-detail">NIB (Nomor Induk Berusaha)</div>
                        <small style="color: #6b7280;"><?= htmlspecialchars($dokumen['nib'] ?? 'NIB'); ?></small>
                    </div>
                </div>
                <div class="doc-download-detail">
                    <a href="dokumen/<?= htmlspecialchars($dokumen['file_nib']); ?>" target="_blank">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($dokumen['file_npwp'])): ?>
            <div class="doc-item-detail">
                <div class="doc-info-detail">
                    <i class="fa fa-file-pdf"></i>
                    <div>
                        <div class="doc-name-detail">NPWP</div>
                        <small style="color: #6b7280;"><?= htmlspecialchars($dokumen['npwp'] ?? 'NPWP'); ?></small>
                    </div>
                </div>
                <div class="doc-download-detail">
                    <a href="dokumen/<?= htmlspecialchars($dokumen['file_npwp']); ?>" target="_blank">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($dokumen['file_mou'])): ?>
            <div class="doc-item-detail">
                <div class="doc-info-detail">
                    <i class="fa fa-file-pdf"></i>
                    <div>
                        <div class="doc-name-detail">MoU (Memorandum of Understanding)</div>
                        <small style="color: #6b7280;"><?= htmlspecialchars($dokumen['mou'] ?? 'MoU'); ?></small>
                    </div>
                </div>
                <div class="doc-download-detail">
                    <a href="dokumen/<?= htmlspecialchars($dokumen['file_mou']); ?>" target="_blank">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="empty-state-detail">
            <i class="fa fa-file-alt"></i>
            <p>Belum ada dokumen yang diunggah</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<script>
    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.info-item-detail, .sosmed-item-detail, .doc-item-detail').forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = `all 0.5s ease ${index * 0.1}s`;
        observer.observe(item);
    });
</script>
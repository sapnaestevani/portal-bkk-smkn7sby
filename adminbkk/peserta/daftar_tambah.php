<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("koneksi.php");

if (!isset($_SESSION['ses_nisn'])) {
    die("Session tidak ditemukan. Silakan login ulang.");
}
// ✅ Ambil parameter halaman
$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';

$nisn = $_SESSION['ses_nisn'];

// ✅ Ambil ID lowongan dari GET atau POST (pakai variabel yang BENAR)
$id_lowongan = '';
if (isset($_GET['kode']) && !empty($_GET['kode'])) {
    $id_lowongan = mysqli_real_escape_string($con, $_GET['kode']);
} elseif (isset($_POST['id_lowongan']) && !empty($_POST['id_lowongan'])) {
    $id_lowongan = mysqli_real_escape_string($con, $_POST['id_lowongan']);
}

// ✅ Ambil data siswa DULUAN
$sql_profil = mysqli_query($con, "SELECT * FROM tb_siswa WHERE nisn='$nisn'");
$profil = mysqli_fetch_assoc($sql_profil);

if (!$profil) {
    die("Data profil tidak ditemukan!");
}

$id_siswa = $profil['id_siswa'];

// ✅ CEK SUDAH MELAMAR - Langsung cek SEBELUM validasi lain
if (!empty($id_lowongan)) {
    $cek_lamaran = mysqli_query($con, "SELECT * FROM tb_lamaran WHERE id_siswa='$id_siswa' AND id_lowongan='$id_lowongan'");
    if (mysqli_num_rows($cek_lamaran) > 0) {
        echo "<script>
            alert('ℹ️ Anda sudah melamar lowongan ini!');
            window.location='index_pst.php?halaman=pendaftar';
        </script>";
        exit; // ✅ PENTING: exit agar kode bawah tidak jalan
    }
}

// ✅ Skip validasi ID jika halaman=pendaftar (riwayat lamaran)
if (empty($id_lowongan) && !isset($_POST['btnLamar']) && $halaman != 'pendaftar') {
    echo "<script>alert('ID Lowongan tidak ditemukan!'); window.location='index_pst.php?halaman=loker';</script>";
    exit;
}

// Cek tracer
$sql_tracer = mysqli_query($con, "SELECT * FROM tb_tracer WHERE id_siswa='$id_siswa'");
$tracer = mysqli_fetch_assoc($sql_tracer);

// Hitung persentase
$persen = 0;
if (!empty($profil['nik'])) $persen += 10;
if (!empty($profil['nama'])) $persen += 10;
if (!empty($profil['alamat'])) $persen += 10;
if (!empty($profil['no_hp'])) $persen += 10;
if (!empty($profil['deskripsi'])) $persen += 10;
if (!empty($profil['email'])) $persen += 10;
if (!empty($profil['status_perkawinan'])) $persen += 10;
if (!empty($profil['foto'])) $persen += 10;
if ($tracer && !empty($tracer['id_tracer'])) $persen += 20;

// ✅ PROSES UPLOAD & SIMPAN LAMARAN
if (isset($_POST['btnLamar'])) {
    
    // Validasi profil
    if ($persen < 100) {
        echo "<script>
            alert('⚠️ Profil belum lengkap (" . $persen . "%). Lengkapi profil terlebih dahulu!');
            window.location='index_pst.php?halaman=profile_peserta';
        </script>";
        exit;
    }
    
    // ✅ CEK SUDAH MELAMAR (lagi untuk keamanan)
    $id_lowongan_post = mysqli_real_escape_string($con, $_POST['id_lowongan']);
    $cek_duplikat = mysqli_query($con, "SELECT * FROM tb_lamaran WHERE id_siswa='$id_siswa' AND id_lowongan='$id_lowongan_post'");
    if (mysqli_num_rows($cek_duplikat) > 0) {
        echo "<script>
            alert('ℹ️ Anda sudah melamar lowongan ini!');
            window.location='index_pst.php?halaman=pendaftar';
        </script>";
        exit;
    }
    
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        
        $allowed = ['pdf', 'doc', 'docx'];
        $ext = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Format file tidak diperbolehkan! Gunakan PDF, DOC, atau DOCX'); window.history.back();</script>";
            exit;
        }
        
        if ($_FILES['cv']['size'] > 5 * 1024 * 1024) {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 5MB'); window.history.back();</script>";
            exit;
        }
        
        $namaFile = time() . "_" . $nisn . "_" . $_FILES['cv']['name'];
        $dirUpload = "../pages/pendaftar/upload/";
        
        if (!is_dir($dirUpload)) {
            mkdir($dirUpload, 0777, true);
        }
        
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $dirUpload . $namaFile)) {
            
            $tanggal = date('Y-m-d');
            $id_lowongan_post = mysqli_real_escape_string($con, $_POST['id_lowongan']);
            
            $sql_insert = "INSERT INTO tb_lamaran 
                (id_lowongan, id_siswa, cv, status, tanggal_lamaran, created_at) 
                VALUES 
                ('$id_lowongan_post', '$id_siswa', '$namaFile', 'Diproses', '$tanggal', NOW())";
            
            if (mysqli_query($con, $sql_insert)) {
                echo "<script>
                    alert('✅ Lamaran berhasil dikirim!');
                    window.location='index_pst.php?halaman=pendaftar';
                </script>";
                exit;
            } else {
                echo "<script>alert('❌ Gagal simpan: " . mysqli_error($con) . "'); window.history.back();</script>";
                exit;
            }
            
        } else {
            echo "<script>alert('❌ Gagal upload file!'); window.history.back();</script>";
            exit;
        }
        
    } else {
        echo "<script>alert('⚠️ Pilih file CV terlebih dahulu!'); window.history.back();</script>";
        exit;
    }
}

// ✅ Ambil info lowongan (pakai variabel yang BENAR: $id_lowongan)
$loker = null;
if (!empty($id_lowongan) && !isset($_POST['btnLamar'])) {
    $sql_loker = mysqli_query($con, "SELECT * FROM tb_lowongan WHERE id_lowongan='$id_lowongan'");
    $loker = mysqli_fetch_assoc($sql_loker);
    
    if (!$loker) {
        echo "<script>alert('Lowongan tidak ditemukan!'); window.location='index_pst.php?halaman=loker';</script>";
        exit;
    }
}

// Jika profil belum lengkap
if ($persen < 100 && !isset($_POST['btnLamar'])) {
    echo "<script>
        alert('⚠️ Profil belum lengkap (" . $persen . "%). Lengkapi profil terlebih dahulu!');
        window.location='index_pst.php?halaman=profile_peserta';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Lamaran - <?php echo isset($loker['judul_lowongan']) ? htmlspecialchars($loker['judul_lowongan']) : ''; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .confirm-card {
            max-width: 700px;
            margin: 0 auto;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .info-row {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            color: #212529;
            font-weight: 500;
        }
        .btn-container {
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
        }
        .btn-lamar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 50px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            transition: all 0.3s;
        }
        .btn-lamar:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .alert-info {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card confirm-card">
        <div class="card-header">
            <h3><i class="fas fa-paper-plane"></i> Konfirmasi Lamaran</h3>
            <p class="mb-0">Pastikan data sudah benar sebelum mengirim</p>
        </div>
        
        <div class="card-body">
            <div class="alert-info">
                <i class="fas fa-info-circle"></i> 
                <strong>Info:</strong> File CV akan diupload di bawah ini
            </div>
            
            <div class="info-row">
                <div class="info-label">Posisi Lowongan</div>
                <div class="info-value"><?php echo isset($loker['judul_lowongan']) ? htmlspecialchars($loker['judul_lowongan']) : ''; ?></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Nama Perusahaan</div>
                <div class="info-value">
                    <?php 
                    if ($loker && !empty($loker['id_perusahaan'])) {
                        $id_perusahaan = mysqli_real_escape_string($con, $loker['id_perusahaan']);
                        $sql_perus = mysqli_query($con, "SELECT nama_perusahaan FROM tb_perusahaan WHERE id_perusahaan='$id_perusahaan'");
                        $perus = mysqli_fetch_assoc($sql_perus);
                        echo isset($perus['nama_perusahaan']) ? htmlspecialchars($perus['nama_perusahaan']) : '-';
                    } else {
                        echo '-';
                    }
                    ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Nama Pelamar</div>
                <div class="info-value"><?php echo isset($profil['nama']) ? htmlspecialchars($profil['nama']) : ''; ?></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">NISN</div>
                <div class="info-value"><?php echo htmlspecialchars($nisn); ?></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Status Profil</div>
                <div class="info-value">
                    <span class="badge badge-success">Lengkap (100%)</span>
                </div>
            </div>
        </div>
        
        <div class="btn-container">
            <form method="POST" action="" enctype="multipart/form-data">
                <!-- ✅ PERBAIKAN: Pakai $id_lowongan yang benar -->
                <input type="hidden" name="id_lowongan" value="<?php echo htmlspecialchars($id_lowongan); ?>">
                
                <div class="form-group">
                    <label><strong>Upload CV / Surat Lamaran (PDF/DOC/DOCX)</strong></label>
                    <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx" required>
                    <small class="text-muted">Maksimal 5MB</small>
                </div>
                
                <button type="submit" name="btnLamar" class="btn btn-lamar" onclick="return confirm('Yakin ingin mengirim lamaran ini?')">
                    <i class="fas fa-paper-plane"></i> Kirim Lamaran
                </button>
                <a href="index_pst.php?halaman=loker" class="btn btn-secondary btn-lg ml-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $('input[type="file"]').on('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB');
            $(this).val('');
        }
    });
</script>

</body>
</html>
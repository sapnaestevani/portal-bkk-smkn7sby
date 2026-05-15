<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../../koneksi.php");

// Validasi parameter
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

if (empty($kode)) {
    echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
    exit;
}

// Proses update jika form disubmit
if (isset($_POST['btnUpdate'])) {
    $status = mysqli_real_escape_string($con, $_POST['status_setelah_lulus']);
    $nama_instansi = mysqli_real_escape_string($con, $_POST['nama_instansi'] ?? '');
    $posisi = mysqli_real_escape_string($con, $_POST['posisi'] ?? '');
    $tahun_mulai = mysqli_real_escape_string($con, $_POST['tahun_mulai'] ?? '');
    $nama_kampus = mysqli_real_escape_string($con, $_POST['nama_kampus'] ?? '');
    $jurusan_kampus = mysqli_real_escape_string($con, $_POST['jurusan_kampus'] ?? '');
    $aktivitas = mysqli_real_escape_string($con, $_POST['aktivitas'] ?? '');
    
    $sql_update = "UPDATE tb_tracer SET 
                    status_setelah_lulus = '$status',
                    nama_instansi = '$nama_instansi',
                    posisi = '$posisi',
                    tahun_mulai = '$tahun_mulai',
                    nama_kampus = '$nama_kampus',
                    jurusan_kampus = '$jurusan_kampus',
                    aktivitas = '$aktivitas',
                    tanggal_update = NOW()
                   WHERE id_tracer = '$kode'";
    
    if (mysqli_query($con, $sql_update)) {
        echo "<script>alert('✅ Data berhasil diperbarui!'); window.location.href='?halaman=tracerb';</script>";
    } else {
        echo "<script>alert('❌ Gagal: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
    exit;
}

// Query data tracer + siswa untuk form
$sql = "SELECT 
            t.*,
            s.nama,
            s.nisn,
            s.jurusan,
            s.tahun_lulus
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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Alumni - <?= htmlspecialchars($data['nama']); ?></title>
    <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <style>
        .edit-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px auto;
            max-width: 700px;
        }
        .form-group { margin-bottom: 20px; }
        .form-control { border-radius: 5px; }
        .btn-back { margin-bottom: 20px; }
        .section-title {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            margin: 25px 0 15px 0;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="content-wrapper" style="margin-left: 0; padding: 20px;">
        
        <a href="javascript:history.back()" class="btn btn-default btn-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        
        <div class="edit-card">
            <h3 style="margin-top: 0; color: #667eea;">
                <i class="fa fa-edit"></i> Edit Data Alumni
            </h3>
            
            <form method="post" action="">
                <!-- Info Alumni (Read Only) -->
                <h5 class="section-title">Informasi Alumni</h5>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['nisn']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Jurusan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['jurusan']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['tahun_lulus']); ?>" disabled>
                </div>
                
                <!-- Edit Status & Detail -->
                <h5 class="section-title">Update Tracer Study</h5>
                <div class="form-group">
                    <label>Status Setelah Lulus *</label>
                    <select class="form-control" name="status_setelah_lulus" required onchange="toggleFields()">
                        <option value="">- Pilih Status -</option>
                        <option value="Bekerja" <?= $data['status_setelah_lulus'] == 'Bekerja' ? 'selected' : ''; ?>>Bekerja</option>
                        <option value="Studi" <?= $data['status_setelah_lulus'] == 'Studi' ? 'selected' : ''; ?>>Studi Lanjut</option>
                        <option value="Belum Bekerja" <?= $data['status_setelah_lulus'] == 'Belum Bekerja' ? 'selected' : ''; ?>>Belum Bekerja</option>
                    </select>
                </div>
                
                <!-- Field Bekerja -->
                <div id="field-bekerja" style="display: <?= $data['status_setelah_lulus'] == 'Bekerja' ? 'block' : 'none'; ?>;">
                    <div class="form-group">
                        <label>Nama Instansi / Perusahaan</label>
                        <input type="text" class="form-control" name="nama_instansi" value="<?= htmlspecialchars($data['nama_instansi'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Posisi / Jabatan</label>
                        <input type="text" class="form-control" name="posisi" value="<?= htmlspecialchars($data['posisi'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Tahun Mulai Bekerja</label>
                        <input type="number" class="form-control" name="tahun_mulai" value="<?= htmlspecialchars($data['tahun_mulai'] ?? ''); ?>" min="2017" max="<?= date('Y'); ?>">
                    </div>
                </div>
                
                <!-- Field Studi -->
                <div id="field-studi" style="display: <?= $data['status_setelah_lulus'] == 'Studi' ? 'block' : 'none'; ?>;">
                    <div class="form-group">
                        <label>Nama Kampus / Universitas</label>
                        <input type="text" class="form-control" name="nama_kampus" value="<?= htmlspecialchars($data['nama_kampus'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Jurusan di Kampus</label>
                        <input type="text" class="form-control" name="jurusan_kampus" value="<?= htmlspecialchars($data['jurusan_kampus'] ?? ''); ?>">
                    </div>
                </div>
                
                <!-- Field Belum Bekerja -->
                <div id="field-belum" style="display: <?= $data['status_setelah_lulus'] == 'Belum Bekerja' ? 'block' : 'none'; ?>;">
                    <div class="form-group">
                        <label>Aktivitas Saat Ini</label>
                        <textarea class="form-control" name="aktivitas" rows="3"><?= htmlspecialchars($data['aktivitas'] ?? ''); ?></textarea>
                    </div>
                </div>
                
                <hr>
                <button type="submit" name="btnUpdate" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
                <a href="javascript:history.back()" class="btn btn-default">
                    <i class="fa fa-times"></i> Batal
                </a>
            </form>
        </div>
        
    </div>
    
    <script>
        function toggleFields() {
            const status = document.querySelector('select[name="status_setelah_lulus"]').value;
            document.getElementById('field-bekerja').style.display = (status === 'Bekerja') ? 'block' : 'none';
            document.getElementById('field-studi').style.display = (status === 'Studi') ? 'block' : 'none';
            document.getElementById('field-belum').style.display = (status === 'Belum Bekerja') ? 'block' : 'none';
        }
    </script>
</body>
</html>
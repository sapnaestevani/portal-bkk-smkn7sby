<?php
/**
 * File: hasil_tambah_per.php
 * Fungsi: Memproses upload hasil kelulusan untuk perusahaan
 */

// Pastikan koneksi tersedia
if (!isset($con)) {
    include_once("koneksi.php");
}

// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek akses - HANYA perusahaan
if (!isset($_SESSION['ses_username']) || ($_SESSION['ses_level'] ?? '') !== 'perusahaan') {
    echo "<script>alert('❌ Akses ditolak!');window.location.href='../login.php';</script>";
    exit;
}

// Validasi ID perusahaan
$id_perusahaan = isset($_SESSION['ses_id_perusahaan']) ? intval($_SESSION['ses_id_perusahaan']) : 0;
if ($id_perusahaan <= 0) {
    echo "<script>alert('❌ Data perusahaan tidak ditemukan!');window.location.href='../login.php';</script>";
    exit;
}

// Proses jika form disubmit
if (isset($_POST['btnSimpan'])) {
    
    // Sanitasi input
    $id_lowongan_raw = $_POST['txtlowongan'] ?? '';
    $id_lowongan = is_numeric($id_lowongan_raw) ? intval($id_lowongan_raw) : 0;
    $keterangan = isset($_POST['keterangan']) ? mysqli_real_escape_string($con, trim($_POST['keterangan'])) : '';
    $tanggal_pengumuman = isset($_POST['tanggal_pengumuman']) && !empty($_POST['tanggal_pengumuman']) 
        ? mysqli_real_escape_string($con, $_POST['tanggal_pengumuman']) 
        : date('Y-m-d');
    
    // Validasi field wajib
    $errors = [];
    if ($id_lowongan <= 0) {
        $errors[] = "Lowongan belum dipilih";
    }
    if (empty($tanggal_pengumuman)) {
        $errors[] = "Tanggal pengumuman belum diisi";
    }
    
    if (!empty($errors)) {
        echo "<script>alert('❌ Error:\n• " . implode("\n• ", $errors) . "'); window.history.back();</script>";
        exit;
    }
    
    // Validasi lowongan milik perusahaan
    $cek_loker = mysqli_query($con, "
        SELECT id_lowongan FROM tb_lowongan 
        WHERE id_lowongan = '$id_lowongan' 
        AND id_perusahaan = '$id_perusahaan'
        AND status = 'aktif'
        LIMIT 1
    ");
    
    if (!$cek_loker || mysqli_num_rows($cek_loker) === 0) {
        echo "<script>alert('❌ Lowongan tidak valid!'); window.history.back();</script>";
        exit;
    }
    
    // Proses upload file
    if (!isset($_FILES['berkas']) || $_FILES['berkas']['error'] !== UPLOAD_ERR_OK) {
        $msg = $_FILES['berkas']['error'] ?? 'File tidak dipilih';
        echo "<script>alert('❌ Upload gagal: $msg'); window.history.back();</script>";
        exit;
    }
    
    $namaFileOriginal = basename($_FILES['berkas']['name']);
    $ext = strtolower(pathinfo($namaFileOriginal, PATHINFO_EXTENSION));
    $allowedExt = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    
    if (!in_array($ext, $allowedExt)) {
        echo "<script>alert('❌ Format tidak diizinkan!'); window.history.back();</script>";
        exit;
    }
    
    if ($_FILES['berkas']['size'] > 5 * 1024 * 1024) {
        echo "<script>alert('❌ File terlalu besar! Max 5MB'); window.history.back();</script>";
        exit;
    }
    
    // Generate nama file unik
    $namaFile = 'kel_' . uniqid() . '_' . time() . '.' . $ext;
    $dirUpload = "pages/kelulusan/terupload/";
    
    if (!is_dir($dirUpload)) {
        mkdir($dirUpload, 0755, true);
    }
    
    $targetPath = $dirUpload . $namaFile;
    if (!move_uploaded_file($_FILES['berkas']['tmp_name'], $targetPath)) {
        echo "<script>alert('❌ Gagal simpan file!'); window.history.back();</script>";
        exit;
    }
    
    // Insert ke database dengan NULL untuk id_siswa
    $sql_insert = "INSERT INTO tb_kelulusan (
        id_lowongan,
        id_siswa,
        berkas,
        keterangan,
        tanggal_pengumuman
    ) VALUES (
        '$id_lowongan',
        NULL,
        '$namaFile',
        '$keterangan',
        '$tanggal_pengumuman'
    )";
    
    if (mysqli_query($con, $sql_insert)) {
        echo "<script>alert('✅ Berhasil disimpan!'); window.location.href='?halaman=hasil_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal: " . addslashes(mysqli_error($con)) . "'); window.history.back();</script>";
    }
    exit;
}

// Redirect jika diakses langsung
echo "<script>window.location.href='?halaman=hasil_tampil';</script>";
exit;
?>
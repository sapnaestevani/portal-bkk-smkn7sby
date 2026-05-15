<?php
// ✅ FIX 1: Pastikan koneksi tersedia
if (!isset($con)) {
    include_once("koneksi.php");
}

// ✅ FIX 2: Session handling
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// ✅ FIX 3: Cek akses - hanya perusahaan yang bisa akses
if (!isset($_SESSION['ses_username']) || ($_SESSION['ses_level'] ?? '') != 'perusahaan') {
    echo "<script>alert('❌ Akses ditolak!');window.history.back();</script>";
    exit;
}

// ✅ FIX 4: Hanya proses jika form disubmit
if (isset($_POST['btnSimpan'])) {
    
    // ✅ FIX 5: Ambil dan sanitasi input dengan validasi ketat
    $id_lowongan = isset($_POST['txtlowongan']) ? mysqli_real_escape_string($con, trim($_POST['txtlowongan'])) : '';
    $keterangan = isset($_POST['keterangan']) ? mysqli_real_escape_string($con, trim($_POST['keterangan'])) : '';
    $tanggal_pengumuman = isset($_POST['tanggal_pengumuman']) ? mysqli_real_escape_string($con, $_POST['tanggal_pengumuman']) : date('Y-m-d');
    $id_perusahaan = isset($_SESSION['ses_id_perusahaan']) ? intval($_SESSION['ses_id_perusahaan']) : 0;
    
    // ✅ FIX 6: Validasi field wajib dengan pesan spesifik
    $errors = [];
    if (empty($id_lowongan) || !is_numeric($id_lowongan) || intval($id_lowongan) <= 0) {
        $errors[] = "Lowongan belum dipilih atau tidak valid";
    }
    if (empty($tanggal_pengumuman)) {
        $errors[] = "Tanggal pengumuman belum diisi";
    }
    if ($id_perusahaan <= 0) {
        $errors[] = "ID Perusahaan tidak valid (silakan login ulang)";
    }
    
    if (!empty($errors)) {
        $error_msg = "❌ Field wajib belum diisi:\n• " . implode("\n• ", $errors);
        echo "<script>alert(" . json_encode($error_msg) . ");window.history.back();</script>";
        exit;
    }
    
    // ✅ FIX 7: Validasi lowongan benar-benar milik perusahaan ini
    $cek_loker = mysqli_query($con, "
        SELECT id_lowongan FROM tb_lowongan 
        WHERE id_lowongan = '$id_lowongan' 
        AND id_perusahaan = '$id_perusahaan'
        AND status = 'aktif'
        LIMIT 1
    ");
    if (!$cek_loker || mysqli_num_rows($cek_loker) == 0) {
        echo "<script>alert('❌ Lowongan tidak valid atau bukan milik perusahaan Anda!');window.history.back();</script>";
        exit;
    }
    
    // ✅ FIX 8: Proses upload file dengan validasi lengkap
    if (!isset($_FILES['berkas']) || !is_array($_FILES['berkas'])) {
        echo "<script>alert('❌ File belum dipilih!');window.history.back();</script>";
        exit;
    }
    
    $upload_error = $_FILES['berkas']['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($upload_error !== UPLOAD_ERR_OK) {
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => 'File terlalu besar (limit server)',
            UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (limit form)',
            UPLOAD_ERR_PARTIAL => 'Upload tidak lengkap',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang dipilih',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke server',
            UPLOAD_ERR_EXTENSION => 'Upload diblokir oleh extension PHP'
        ];
        $msg = $upload_errors[$upload_error] ?? "Error upload (kode: $upload_error)";
        echo "<script>alert('❌ Upload gagal: $msg');window.history.back();</script>";
        exit;
    }
    
    $namaFileOriginal = basename($_FILES['berkas']['name']);
    $namaSementara = $_FILES['berkas']['tmp_name'];
    $ukuranFile = intval($_FILES['berkas']['size']);
    $ext = strtolower(pathinfo($namaFileOriginal, PATHINFO_EXTENSION));
    
    // Validasi ekstensi
    $allowedExt = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowedExt)) {
        echo "<script>alert('❌ Format file tidak diizinkan!\nHanya: PDF, DOC, DOCX, JPG, PNG');window.history.back();</script>";
        exit;
    }
    
    // Validasi ukuran (max 5MB)
    if ($ukuranFile > 5 * 1024 * 1024) {
        echo "<script>alert('❌ Ukuran file terlalu besar!\nMaksimal: 5MB');window.history.back();</script>";
        exit;
    }
    
    // Generate nama file unik yang aman
    $uniqueId = uniqid('kel_', false) . '_' . time();
    $namaFile = 'kelulusan_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $uniqueId) . '.' . $ext;
    $dirUpload = "pages/kelulusan/terupload/";
    
    // Buat folder jika belum ada
    if (!is_dir($dirUpload)) {
        if (!mkdir($dirUpload, 0755, true)) {
            echo "<script>alert('❌ Gagal membuat folder upload!');window.history.back();</script>";
            exit;
        }
    }
    
    // Pindahkan file
    $targetPath = rtrim($dirUpload, '/') . '/' . $namaFile;
    if (!move_uploaded_file($namaSementara, $targetPath)) {
        echo "<script>alert('❌ Gagal menyimpan file upload!');window.history.back();</script>";
        exit;
    }
    
    // ✅ FIX 9: Insert ke database
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
        echo "<script>alert('✅ Data hasil kelulusan berhasil disimpan!');window.location.href='?halaman=hasil_tampil';</script>";
    } else {
        $error_msg = mysqli_error($con);
        if (strpos(strtolower($error_msg), 'foreign key') !== false) {
            echo "<script>alert('❌ Gagal: Data referensi tidak valid.');window.history.back();</script>";
        } else {
            echo "<script>alert('❌ Gagal menyimpan: " . addslashes($error_msg) . "');window.history.back();</script>";
        }
    }
    exit;
}

// ✅ FIX 10: Redirect jika diakses langsung
echo "<script>window.location.href='?halaman=hasil_tampil';</script>";
exit;
?>
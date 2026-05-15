<?php
// ============================================================================
// 📁 HASIL_AKSI.PHP - Handler CRUD (PATH DIPERBAIKI)
// ============================================================================

if (!isset($con)) {
    include_once("koneksi.php");
}

if (!isset($con) || !$con) {
    die("<script>alert('❌ Koneksi database gagal!'); window.history.back();</script>");
}

// ✅ PERBAIKAN PATH: Karena file ini sudah di pages/kelulusan/, cukup tambah /terupload/
$upload_dir = __DIR__ . "/terupload/";  // ✅ Benar: C:\...\adminbkk\pages\kelulusan\terupload\

// Pastikan folder upload ada
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        die("<script>alert('❌ Gagal membuat folder upload!'); window.history.back();</script>");
    }
}

// ============================================================================
// 📤 FUNGSI UPLOAD FILE
// ============================================================================
if (!function_exists('prosesUpload')) {
    function prosesUpload($fileInputName, $uploadDir, $allowedExt = ['pdf','doc','docx','jpg','jpeg','png'], $maxSize = 5242880) {
        
        if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'File tidak valid'];
        }
        
        $originalName = basename($_FILES[$fileInputName]['name']);
        $tmpName = $_FILES[$fileInputName]['tmp_name'];
        $fileSize = $_FILES[$fileInputName]['size'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowedExt)) {
            return ['success' => false, 'error' => 'Format file tidak diizinkan'];
        }
        
        if ($fileSize > $maxSize) {
            return ['success' => false, 'error' => 'File terlalu besar (max 5MB)'];
        }
        
        // Generate nama file unik
        $newFileName = 'kelulusan_' . uniqid('', true) . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetPath = rtrim($uploadDir, '/') . '/' . $newFileName;
        
        if (move_uploaded_file($tmpName, $targetPath)) {
            return ['success' => true, 'filename' => $newFileName];
        }
        
        return ['success' => false, 'error' => 'Gagal menyimpan file'];
    }
}

// ============================================================================
// ✏️ PROSES UPDATE
// ============================================================================
if (isset($_POST['btnUBAH'])) {
    
    $id_kelulusan = isset($_POST['txtkode_hasil']) ? intval($_POST['txtkode_hasil']) : 0;
    $keterangan   = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';
    $tanggal      = isset($_POST['tanggal_pengumuman']) ? $_POST['tanggal_pengumuman'] : '';
    
    if ($id_kelulusan <= 0 || empty($tanggal)) {
        echo "<script>alert('❌ Field wajib belum lengkap!'); window.history.back();</script>";
        exit;
    }
    
    $adaFileBaru = (isset($_FILES['berkas']) && !empty($_FILES['berkas']['name']));
    
    if ($adaFileBaru) {
        $uploadResult = prosesUpload('berkas', $upload_dir);
        
        if (!$uploadResult['success']) {
            echo "<script>alert('❌ Upload gagal: " . addslashes($uploadResult['error']) . "'); window.history.back();</script>";
            exit;
        }
        
        $namaFile = $uploadResult['filename'];
        $keterangan_esc = mysqli_real_escape_string($con, $keterangan);
        
        // ✅ UPDATE tanpa kolom 'url'
        $sql = "UPDATE tb_kelulusan SET 
                keterangan = '$keterangan_esc',
                tanggal_pengumuman = '$tanggal',
                berkas = '$namaFile'
                WHERE id_kelulusan = $id_kelulusan";
                
    } else {
        $keterangan_esc = mysqli_real_escape_string($con, $keterangan);
        $sql = "UPDATE tb_kelulusan SET 
                keterangan = '$keterangan_esc',
                tanggal_pengumuman = '$tanggal'
                WHERE id_kelulusan = $id_kelulusan";
    }
    
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('✅ Update Berhasil!'); window.location.href='index.php?halaman=hasil_tampil';</script>";
    } else {
        echo "<script>alert('❌ Update Gagal: " . addslashes(mysqli_error($con)) . "'); window.history.back();</script>";
    }
    exit;
}

// ============================================================================
// ➕ PROSES TAMBAH
// ============================================================================
elseif (isset($_POST['btnSimpan'])) {
    
    $id_lowongan = isset($_POST['txtlowongan']) ? intval($_POST['txtlowongan']) : 0;
    $keterangan  = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';
    $tanggal     = isset($_POST['tanggal_pengumuman']) ? $_POST['tanggal_pengumuman'] : '';
    
    if ($id_lowongan <= 0 || empty($tanggal)) {
        echo "<script>alert('❌ Harap lengkapi field wajib!'); window.history.back();</script>";
        exit;
    }
    
    $uploadResult = prosesUpload('berkas', $upload_dir);
    
    if (!$uploadResult['success']) {
        echo "<script>alert('❌ Upload gagal: " . addslashes($uploadResult['error']) . "'); window.history.back();</script>";
        exit;
    }
    
    $namaFile = $uploadResult['filename'];
    $keterangan_esc = mysqli_real_escape_string($con, $keterangan);
    
    // ✅ INSERT tanpa kolom 'url'
    $sql = "INSERT INTO tb_kelulusan (id_lowongan, keterangan, tanggal_pengumuman, berkas) 
            VALUES ($id_lowongan, '$keterangan_esc', '$tanggal', '$namaFile')";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('✅ Pengumuman Berhasil Ditambahkan!'); window.location.href='index.php?halaman=hasil_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal: " . addslashes(mysqli_error($con)) . "'); window.history.back();</script>";
    }
    exit;
}

// ============================================================================
// 🗑️ PROSES HAPUS
// ============================================================================
elseif (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus' && isset($_GET['kode'])) {
    
    $id_kelulusan = intval($_GET['kode']);
    
    if ($id_kelulusan > 0) {
        $cek = mysqli_query($con, "SELECT berkas FROM tb_kelulusan WHERE id_kelulusan = $id_kelulusan LIMIT 1");
        
        if ($cek && $row = mysqli_fetch_assoc($cek)) {
            if (!empty($row['berkas'])) {
                $fileLama = $upload_dir . $row['berkas'];
                if (file_exists($fileLama)) {
                    @unlink($fileLama);
                }
            }
        }
        
        $sql = "DELETE FROM tb_kelulusan WHERE id_kelulusan = $id_kelulusan";
        
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('🗑️ Data Berhasil Dihapus!'); window.location.href='index.php?halaman=hasil_tampil';</script>";
        } else {
            echo "<script>alert('❌ Gagal Hapus: " . addslashes(mysqli_error($con)) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('❌ ID tidak valid!'); window.location.href='index.php?halaman=hasil_tampil';</script>";
    }
    exit;
}

// ============================================================================
// 🔄 DEFAULT
// ============================================================================
else {
    if (!headers_sent()) {
        header("Location: index.php?halaman=hasil_tampil_per");
    } else {
        echo "<script>window.location.href='index.php?halaman=hasil_tampil_per';</script>";
    }
    exit;
}
?>
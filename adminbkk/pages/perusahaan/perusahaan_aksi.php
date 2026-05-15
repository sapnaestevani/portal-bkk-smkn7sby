<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================================================
// 🔧 MULTI-PATH INCLUDE UNTUK koneksi.php (Robust)
// ============================================================================
$koneksi_paths = [
    // Path relatif dari adminbkk/pages/perusahaan/
    __DIR__ . '/../../koneksi.php',              // ✅ adminbkk/pages/perusahaan -> adminbkk
    
    // Fallback jika struktur berbeda
    __DIR__ . '/../koneksi.php',                 // adminbkk/pages/perusahaan -> adminbkk/pages
    __DIR__ . '/koneksi.php',                    // Same folder
    __DIR__ . '/../../../koneksi.php',           // One level higher
    
    // Path absolut dari DOCUMENT_ROOT
    $_SERVER['DOCUMENT_ROOT'] . '/bkk/SistemBKK_smkn7/adminbkk/koneksi.php',
];

$con = null;
foreach ($koneksi_paths as $path) {
    if (file_exists($path)) {
        include_once($path);
        break;
    }
}

// Jika koneksi masih null, tampilkan error informatif
if (!$con) {
    die("
    <div style='background:#fee; color:#c00; padding:20px; border:2px solid #fcc; border-radius:8px; font-family:monospace; max-width:800px; margin:50px auto;'>
        <h3>❌ ERROR: Koneksi Database Gagal!</h3>
        <p><strong>File:</strong> " . basename(__FILE__) . "</p>
        <p><strong>Lokasi saat ini:</strong> " . __DIR__ . "</p>
        <p><strong>Path koneksi.php yang dicoba:</strong></p>
        <pre style='background:#fff; padding:10px; border-radius:4px; overflow-x:auto; font-size:12px;'>" 
        . implode("\n", array_map('htmlspecialchars', $koneksi_paths)) . 
        "</pre>
        <p><strong>Solusi:</strong></p>
        <ol>
            <li>Pastikan file <code>koneksi.php</code> ada di folder <code>adminbkk/</code></li>
            <li>Cek nama file (harus persis: koneksi.php)</li>
            <li>Cek permission file (harus bisa dibaca)</li>
        </ol>
    </div>");
}

// ============================================================================
// 🔧 LANJUTAN: LOGIKA AKSI PERUSAHAAN
// ============================================================================

// ✅ Sanitasi dan validasi input
$aksi = isset($_GET['aksi']) ? mysqli_real_escape_string($con, $_GET['aksi']) : '';
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

// ✅ Validasi parameter
if (empty($aksi) || empty($kode)) {
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    if (strpos($referer, 'perusahaan_aksi.php') === false) {
        echo "<script>
            alert('❌ Data tidak lengkap!');
            window.history.back();
        </script>";
    }
    exit; 
}

// ✅ Validasi aksi yang diizinkan
$allowed_actions = ['aktif', 'nonaktif'];
if (!in_array($aksi, $allowed_actions)) {
    echo "<script>
        alert('❌ Aksi tidak valid!');
        window.history.back();
    </script>";
    exit; 
}

// ✅ Cek apakah user/perusahaan ada
// ✅ PERBAIKAN: Ganti 'user' menjadi 'tb_user'
$check = mysqli_query($con, "SELECT * FROM tb_user WHERE username='$kode' LIMIT 1");
if (mysqli_num_rows($check) == 0) {
    echo "<script>
        alert('❌ Perusahaan tidak ditemukan!');
        window.history.back();
    </script>";
    exit; 
}

// ✅ Tentukan status baru berdasarkan aksi
$status_baru = ($aksi == 'aktif') ? 'Aktif' : 'Nonaktif';

// ✅ Update status dengan error handling
$query = "UPDATE tb_user SET status='$status_baru' WHERE username='$kode'";
$result = mysqli_query($con, $query);

if ($result) {
    // ✅ Berhasil
    $pesan = ($aksi == 'aktif') ? 'diaktifkan' : 'dinonaktifkan';
    echo "<script>
        alert('✅ Status perusahaan berhasil $pesan!');
        window.location.href = '../../index.php?halaman=perusahaan_tampil';
    </script>";
    exit; 
} else {
    // ✅ Gagal
    $error = mysqli_error($con);
    echo "<script>
        alert('❌ Gagal mengubah status.\\n\\nError: " . addslashes($error) . "');
        window.history.back();
    </script>";
    exit; 
}
?>
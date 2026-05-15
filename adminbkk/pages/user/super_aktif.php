<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================================================
// 🔧 MULTI-PATH INCLUDE UNTUK koneksi.php
// ============================================================================
$koneksi_paths = [
    __DIR__ . '/../../koneksi.php',              // ✅ adminbkk/pages/user -> adminbkk
    __DIR__ . '/../koneksi.php',
    __DIR__ . '/koneksi.php',
    __DIR__ . '/../../../koneksi.php',
    $_SERVER['DOCUMENT_ROOT'] . '/adminbkk/koneksi.php',
];

$con = null;
foreach ($koneksi_paths as $path) {
    if (file_exists($path)) {
        include_once($path);
        break;
    }
}

if (!$con) {
    die("❌ Koneksi database gagal!");
}

// ============================================================================
// 🔧 LOGIKA AKTIFKAN USER
// ============================================================================

// ✅ Sanitasi input
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

// ✅ Validasi parameter
if (empty($kode)) {
    echo "<script>
        alert('❌ Data tidak lengkap!');
        window.history.back();
    </script>";
    exit;
}

// ✅ Cek apakah user ada
$check = mysqli_query($con, "SELECT * FROM tb_user WHERE username='$kode' LIMIT 1");
if (mysqli_num_rows($check) == 0) {
    echo "<script>
        alert('❌ User tidak ditemukan!');
        window.history.back();
    </script>";
    exit;
}

// ✅ Update status ke Aktif
// ✅ PERBAIKAN: Ganti 'user' menjadi 'tb_user'
$sql_aktif = "UPDATE tb_user SET status = 'Aktif' WHERE username='$kode'";
$query_aktif = mysqli_query($con, $sql_aktif);

if ($query_aktif) {
    // ✅ Berhasil
    echo "<script>
        alert('✅ User berhasil diaktifkan!');
        window.location.href = '../../index.php?halaman=super_tampil';
    </script>";
} else {
    // ✅ Gagal
    $error = mysqli_error($con);
    echo "<script>
        alert('❌ Gagal mengaktifkan user.\\n\\nError: " . addslashes($error) . "');
        window.history.back();
    </script>";
}

exit;
?>
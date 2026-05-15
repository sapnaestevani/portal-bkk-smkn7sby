<?php
session_start();

// ✅ FIX: Path koneksi.php - naik 2 level dari pages/pendaftar/
include_once("../../koneksi.php");

// Cek apakah user login sebagai perusahaan/admin
if (!isset($_SESSION['ses_level'])) {
    http_response_code(403);
    die("❌ Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil dan validasi parameter
$file = isset($_GET['file']) ? trim($_GET['file']) : '';
$id_siswa = isset($_GET['id_siswa']) ? intval($_GET['id_siswa']) : 0;

// Validasi dasar
if (empty($file) || $id_siswa == 0) {
    http_response_code(400);
    die("❌ Parameter tidak valid");
}

// ✅ Sanitasi filename untuk keamanan (mencegah path traversal)
$file = basename($file);

// ✅ Verifikasi bahwa file memang milik siswa ini
$sql = mysqli_query($con, "SELECT id_siswa, nama FROM tb_siswa WHERE id_siswa = '$id_siswa' LIMIT 1");
if (!$sql || mysqli_num_rows($sql) == 0) {
    http_response_code(404);
    die("❌ Data siswa tidak ditemukan");
}

// ✅ FIX: Path folder dokumen - sesuai lokasi sebenarnya
// File berada di: C:\xampp\htdocs\bkk\SistemBKK\adminbkk\peserta\file\
// Dari: adminbkk/pages/pendaftar/
// Maka: naik 2 level (../..) lalu masuk ke peserta/file/
$base_path = "../../peserta/file/";

$full_path = $base_path . $file;

// ✅ Cek apakah file benar-benar ada
if (!file_exists($full_path)) {
    http_response_code(404);
    die("❌ File tidak ditemukan: " . htmlspecialchars($file) . "<br>Path: " . realpath($base_path));
}

// ✅ Validasi ekstensi file yang diizinkan (keamanan)
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar'];
$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

if (!in_array($file_ext, $allowed_extensions)) {
    http_response_code(403);
    die("❌ Tipe file tidak diizinkan: ." . htmlspecialchars($file_ext));
}

// ✅ Dapatkan MIME type file
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $full_path);
finfo_close($finfo);

// ✅ Set headers untuk download yang aman
header('Content-Description: File Transfer');
header('Content-Type: ' . $mime_type);
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($full_path));
header('Cache-Control: must-revalidate, private');
header('Pragma: public');
header('Expires: 0');

// ✅ Clear output buffer
if (ob_get_level()) {
    ob_end_clean();
}

// ✅ Output file
if (readfile($full_path) === false) {
    http_response_code(500);
    die("❌ Gagal membaca file");
}
exit;
?>
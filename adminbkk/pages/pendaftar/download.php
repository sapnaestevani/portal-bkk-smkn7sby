<?php
// ==========================================
// ✅ FILE: download.php
// Lokasi: adminbkk/pages/pendaftar/download.php
// ==========================================

session_start();
include_once("../../koneksi.php");

// ✅ 1. Cek login
if (!isset($_SESSION['ses_level'])) {
    die("❌ Akses ditolak! Silakan login.");
}

// ✅ 2. Cek parameter filename
if (!isset($_GET['filename']) || empty($_GET['filename'])) {
    $_SESSION['pesan'] = "⚠️ File tidak ditemukan!";
    header("Location: ../../index.php?halaman=pendaftar_tampil");
    exit;
}

// ✅ 3. Sanitasi nama file
$filename = basename(trim($_GET['filename']));

// ✅ 4. Tentukan folder file (SESUAI lokasi baru)
// File ada di: adminbkk/pages/pendaftar/upload/
$upload_dir = __DIR__ . '/upload/';

// ✅ 5. Path lengkap file
$file_path = $upload_dir . $filename;

// ✅ 6. Cek file ada dan bisa dibaca
if (!file_exists($file_path) || !is_readable($file_path)) {
    $_SESSION['pesan'] = "❌ File '$filename' tidak ditemukan di server!";
    error_log("Download failed: $file_path tidak ada");
    header("Location: ../../index.php?halaman=pendaftar_tampil");
    exit;
}

// ✅ 7. Dapatkan info file
$file_size = filesize($file_path);
$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// ✅ 8. Mapping MIME type
$mime_types = [
    'pdf'  => 'application/pdf',
    'doc'  => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
];
$content_type = $mime_types[$file_ext] ?? 'application/octet-stream';

// ✅ 9. Bersihkan output buffer
while (ob_get_level()) {
    ob_end_clean();
}

// ✅ 10. Kirim header download
header('Content-Description: File Transfer');
header('Content-Type: ' . $content_type);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $file_size);
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// ✅ 11. Flush dan kirim file
flush();
readfile($file_path);
exit;
?>
<?php
// ==========================================
// ✅ FILE: adminbkk/download.php
// ==========================================

session_start();
include_once("koneksi.php");

// ✅ 1. Cek login
if (!isset($_SESSION['ses_level'])) {
    die("❌ Akses ditolak! Silakan login.");
}

// ✅ 2. Cek parameter
if (!isset($_GET['filename']) || empty($_GET['filename'])) {
    $_SESSION['pesan'] = "⚠️ File tidak ditemukan!";
    header("Location: index.php?halaman=pendaftar_tampil");
    exit;
}

// ✅ 3. Sanitasi
$filename = basename(trim($_GET['filename']));

// ✅ 4. Folder file (SESUAI struktur baru)
// File ada di: adminbkk/pages/pendaftar/upload/
$upload_dir = __DIR__ . '/pages/pendaftar/upload/';

// ✅ 5. Path lengkap
$file_path = $upload_dir . $filename;

// ✅ 6. Cek file
if (!file_exists($file_path) || !is_readable($file_path)) {
    $_SESSION['pesan'] = "❌ File '$filename' tidak ditemukan!";
    error_log("Download failed: $file_path tidak ada");
    header("Location: index.php?halaman=pendaftar_tampil");
    exit;
}

// ✅ 7. Info file
$file_size = filesize($file_path);
$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// ✅ 8. MIME type
$mime_types = [
    'pdf'  => 'application/pdf',
    'doc'  => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
];
$content_type = $mime_types[$file_ext] ?? 'application/octet-stream';

// ✅ 9. Bersihkan buffer
while (ob_get_level()) {
    ob_end_clean();
}

// ✅ 10. Header download
header('Content-Description: File Transfer');
header('Content-Type: ' . $content_type);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $file_size);
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// ✅ 11. Kirim file
flush();
readfile($file_path);
exit;
?>
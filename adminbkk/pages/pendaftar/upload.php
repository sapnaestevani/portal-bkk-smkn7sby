<?php 
session_start(); 
include_once("../../koneksi.php"); 

// ================= CEK FILE ================= 
if (!isset($_FILES['cv']) || $_FILES['cv']['error'] != 0) { 
    die("❌ File tidak valid atau tidak diupload!"); 
} 

// ================= DATA FILE ================= 
$nama_file = $_FILES['cv']['name']; 
$tmp = $_FILES['cv']['tmp_name']; 
$size = $_FILES['cv']['size']; 

// ================= VALIDASI ================= 
$allowed = ['pdf','doc','docx','jpg','jpeg','png']; 
$ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION)); 
if (!in_array($ext, $allowed)) { 
    die("❌ Format file tidak diizinkan! Hanya PDF, DOC, DOCX, JPG, PNG"); 
} 

// max 5MB 
if ($size > 5 * 1024 * 1024) { 
    die("❌ Ukuran file terlalu besar! Maksimal 5MB"); 
} 

// ================= BUAT NAMA UNIK ================= 
$nama_baru = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $nama_file); 

// ================= ✅ FOLDER TUJUAN (BARU) ================= 
// File akan disimpan di: adminbkk/pages/pendaftar/upload/
$folder = __DIR__ . "/upload/"; 

// buat folder jika belum ada 
if (!is_dir($folder)) { 
    mkdir($folder, 0755, true); 
} 

// ================= PINDAHKAN FILE ================= 
$path_simpan = $folder . $nama_baru; 
if (!move_uploaded_file($tmp, $path_simpan)) { 
    die("❌ Gagal menyimpan file! Cek permission folder."); 
} 

// ================= SIMPAN KE DATABASE ================= 
$id_siswa = $_POST['id_siswa'] ?? ''; 
$id_lowongan = $_POST['id_lowongan'] ?? ''; 

// Simpan HANYA nama file
$query = mysqli_query($con, " 
    INSERT INTO tb_lamaran (id_siswa, id_lowongan, cv, status, created_at) 
    VALUES ('$id_siswa', '$id_lowongan', '$nama_baru', 'Diproses', NOW()) 
"); 

if (!$query) { 
    unlink($path_simpan);
    die("❌ Gagal simpan database: " . mysqli_error($con)); 
} 

// ================= SUKSES ================= 
$_SESSION['pesan'] = "✅ Upload berhasil!"; 
header("Location: ../../index.php?halaman=pendaftar_tampil"); 
exit; 
?>
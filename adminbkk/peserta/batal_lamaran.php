<?php
// ==========================================
// ✅ FILE: batal_lamaran.php
// ==========================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../koneksi.php");

// ✅ 1. Cek login user
if (!isset($_SESSION['ses_nisn']) || empty($_SESSION['ses_nisn'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location='../peserta.php';
    </script>";
    exit;
}

// ✅ 2. Ambil parameter dengan fallback (support 'kode' atau 'id')
$kode = isset($_GET['kode']) ? trim($_GET['kode']) : (isset($_GET['id']) ? trim($_GET['id']) : '');

if (empty($kode)) {
    // Debug: tampilkan apa yang diterima
    error_log("batal_lamaran.php: GET params = " . print_r($_GET, true));
    
    echo "<script>
        alert('❌ Kode lamaran tidak ditemukan!');
        window.history.back();
    </script>";
    exit;
}

// ✅ 3. Sanitasi input
$kode = mysqli_real_escape_string($con, $kode);
$nisn = mysqli_real_escape_string($con, $_SESSION['ses_nisn']);

// ✅ 4. ✅ PALING PENTING: Dapatkan id_siswa dari nisn
$sql_siswa = mysqli_query($con, "SELECT id_siswa FROM tb_siswa WHERE nisn='$nisn'");
$data_siswa = mysqli_fetch_assoc($sql_siswa);

if (!$data_siswa || empty($data_siswa['id_siswa'])) {
    echo "<script>
        alert('❌ Data siswa tidak ditemukan!');
        window.history.back();
    </script>";
    exit;
}

$id_siswa = $data_siswa['id_siswa'];

// ✅ 5. ✅ QUERY DELETE YANG BENAR
// Hapus lamaran berdasarkan id_lamaran DAN pastikan milik siswa yang login
$query = "DELETE FROM tb_lamaran WHERE id_lamaran='$kode' AND id_siswa='$id_siswa'";

// Debug query (opsional, hapus setelah berhasil)
// error_log("Delete query: $query");

$result = mysqli_query($con, $query);

if (!$result) {
    error_log("Delete failed: " . mysqli_error($con));
    echo "<script>
        alert('❌ Gagal membatalkan lamaran!');
        window.history.back();
    </script>";
    exit;
}

// ✅ 6. Cek apakah ada data yang terhapus
if (mysqli_affected_rows($con) > 0) {
    echo "<script>
        alert('✅ Lamaran berhasil dibatalkan!');
        window.location='index_pst.php?halaman=pendaftar';
    </script>";
} else {
    echo "<script>
        alert('⚠️ Lamaran tidak ditemukan atau sudah dibatalkan.');
        window.location='index_pst.php?halaman=pendaftar';
    </script>";
}

exit;
?>
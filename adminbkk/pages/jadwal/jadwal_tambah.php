<?php
// ✅ FIX: Jangan panggil session_start() jika index.php sudah memulainya
// Path koneksi.php: sama dengan index.php (karena di-include oleh index.php)
include_once("koneksi.php");

// Cek akses
if (!isset($_SESSION['ses_username']) || ($_SESSION['ses_level'] ?? '') != 'perusahaan') {
    echo "<script>alert('❌ Akses ditolak!');window.history.back();</script>";
    exit;
}

if (isset($_POST['btnSimpan'])) {
    $id_lowongan = mysqli_real_escape_string($con, $_POST['txtlowongan'] ?? '');
    $id_perusahaan = intval($_SESSION['ses_id_perusahaan'] ?? 0);
    $tanggal = mysqli_real_escape_string($con, $_POST['tanggal'] ?? '');
    $waktu = mysqli_real_escape_string($con, $_POST['waktu'] ?? '');
    $lokasi = mysqli_real_escape_string($con, $_POST['lokasi'] ?? '');
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan'] ?? 'Jadwal Tes Seleksi');
    $status = 'dijadwalkan';
    
    // Validasi
    if (empty($id_lowongan) || empty($tanggal) || empty($waktu) || empty($lokasi)) {
        echo "<script>alert('❌ Semua field wajib diisi!');window.history.back();</script>";
        exit;
    }
    
    // Validasi lowongan milik perusahaan
    $cek = mysqli_query($con, "SELECT id_lowongan FROM tb_lowongan WHERE id_lowongan='$id_lowongan' AND id_perusahaan='$id_perusahaan'");
    if (!$cek || mysqli_num_rows($cek) == 0) {
        echo "<script>alert('❌ Lowongan tidak valid!');window.history.back();</script>";
        exit;
    }
    
    // Ambil semua pelamar dari lowongan
$q_lamaran = mysqli_query($con, "
    SELECT id_lamaran 
    FROM tb_lamaran 
    WHERE id_lowongan='$id_lowongan'
");

if (!$q_lamaran || mysqli_num_rows($q_lamaran) == 0) {
    echo "<script>alert('❌ Belum ada pelamar!');window.history.back();</script>";
    exit;
}

$berhasil = 0;

while ($d = mysqli_fetch_assoc($q_lamaran)) {

    $id_lamaran = $d['id_lamaran'];

    $sql = "INSERT INTO tb_jadwal (
        id_lamaran,
        id_lowongan,
        id_perusahaan,
        tanggal,
        waktu,
        lokasi,
        keterangan,
        status
    ) VALUES (
        '$id_lamaran',
        '$id_lowongan',
        '$id_perusahaan',
        '$tanggal',
        '$waktu',
        '$lokasi',
        '$keterangan',
        '$status'
    )";

    if (mysqli_query($con, $sql)) {
        $berhasil++;
    }
}

echo "<script>alert('✅ Jadwal berhasil ke $berhasil pelamar');window.location='?halaman=jadwal_tampil';</script>";
exit;
}

// Redirect jika diakses langsung
header("Location: ?halaman=jadwal_tampil");
exit;
?>
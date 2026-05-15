<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("koneksi.php");

/* =========================
CEK LOGIN
========================= */
if (!isset($_SESSION['ses_username'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location='login.php';
    </script>";
    exit;
}

/* =========================
AMBIL ID PERUSAHAAN DARI USER
========================= */
$username = $_SESSION['ses_username'];

$q_perusahaan = mysqli_query($con, "
    SELECT p.id_perusahaan 
    FROM tb_perusahaan p
    JOIN tb_user u ON p.id_user = u.id_user
    WHERE u.username='$username'
");

$data_perusahaan = mysqli_fetch_assoc($q_perusahaan);
$id_perusahaan = $data_perusahaan['id_perusahaan'] ?? 0;

/* =========================
CEK STATUS VERIFIKASI
========================= */
$q_verifikasi = mysqli_query($con, "
    SELECT status_verifikasi 
    FROM tb_perusahaan 
    WHERE id_perusahaan='$id_perusahaan'
");

$data_verifikasi = mysqli_fetch_assoc($q_verifikasi);

if (!$data_verifikasi || $data_verifikasi['status_verifikasi'] != "Terverifikasi") {

    echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Akun Belum Terverifikasi',
    html: '<b style=\"color:#e11d48\">Perusahaan belum diverifikasi Admin BKK</b><br><br>Silakan lengkapi profil terlebih dahulu.',
    confirmButtonText: 'OK',
    confirmButtonColor: '#2563eb',
    backdrop: 'rgba(0,0,0,0.6)'
}).then(() => {
    window.location='?halaman=profile#perusahaan';
});
</script>
";
    exit;
}

/* =========================
SIMPAN LOWONGAN
========================= */
if (isset($_POST['btnSimpan'])) {

    // ambil data dari form
    $judul       = mysqli_real_escape_string($con, $_POST['txtjudul_lowongan'] ?? '');
    $jekel       = mysqli_real_escape_string($con, $_POST['txtjekel'] ?? '');
    $posisi      = mysqli_real_escape_string($con, $_POST['txtposisi'] ?? '');
    $deskripsi   = mysqli_real_escape_string($con, $_POST['txtdeskripsi'] ?? '');
    $kualifikasi = mysqli_real_escape_string($con, $_POST['txtkualifikasi'] ?? '');
    $lokasi      = mysqli_real_escape_string($con, $_POST['txtlokasi'] ?? '-');
    $jenis       = mysqli_real_escape_string($con, $_POST['txtjenis_pekerjaan'] ?? '-');
    $gaji        = mysqli_real_escape_string($con, $_POST['txtgaji'] ?? '-');
    $tanggal     = mysqli_real_escape_string($con, $_POST['txttanggal_posting'] ?? '');
    $batas       = mysqli_real_escape_string($con, $_POST['txtbatas_lamaran'] ?? '');

    // validasi sederhana
    if ($judul == '' || $tanggal == '' || $batas == '') {
        echo "<script>alert('Data wajib belum lengkap!');window.history.back();</script>";
        exit;
    }

    // insert ke database
    $sql_insert = "INSERT INTO tb_lowongan 
    (id_perusahaan, judul_lowongan, jekel, posisi, deskripsi, kualifikasi, lokasi, jenis_pekerjaan, gaji, tanggal_posting, batas_lamaran, status) 
    VALUES 
    ('$id_perusahaan', '$judul', '$jekel', '$posisi', '$deskripsi', '$kualifikasi', '$lokasi', '$jenis', '$gaji', '$tanggal', '$batas', 'aktif')";

    $query_insert = mysqli_query($con, $sql_insert);

    if (!$query_insert) {
        die("Error MySQL: " . mysqli_error($con));
    }

    echo "<script>
        alert('Lowongan berhasil ditambahkan!');
        window.location='index.php?halaman=loker_tampil';
    </script>";
}
?>
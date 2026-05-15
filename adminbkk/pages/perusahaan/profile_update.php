<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . "/../../koneksi.php");

// ======================
// CEK LOGIN
// ======================
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('Session habis! Silakan login ulang');window.location='../login_fix.php';</script>";
    exit;
}

$username = mysqli_real_escape_string($con, $_SESSION['ses_username']);

// ======================
// AMBIL DATA PERUSAHAAN
// ======================
$get = mysqli_query($con, "
SELECT p.* FROM tb_perusahaan p
JOIN tb_user u ON p.id_user = u.id_user
WHERE u.username='$username'
") or die("Query error: " . mysqli_error($con));

$data = mysqli_fetch_assoc($get);

if (!$data) {
    echo "<script>alert('Data perusahaan tidak ditemukan!');window.location='?halaman=profile_perusahaan';</script>";
    exit;
}

$id_perusahaan = $data['id_perusahaan'];

// ======================
// PROSES UPDATE
// ======================
if (isset($_POST['btnUpdate'])) {

    $nama_perusahaan = mysqli_real_escape_string($con, $_POST['nama_perusahaan'] ?? '');
    $email           = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $alamat          = mysqli_real_escape_string($con, $_POST['alamat'] ?? '');
    $bidang_usaha    = mysqli_real_escape_string($con, $_POST['bidang_usaha'] ?? '');
    $jumlah_karyawan = mysqli_real_escape_string($con, $_POST['jumlah_karyawan'] ?? '');
    $deskripsi       = mysqli_real_escape_string($con, $_POST['deskripsi'] ?? '');
    $manfaat         = mysqli_real_escape_string($con, $_POST['manfaat'] ?? '');

    // ======================
    // HANDLE LOGO
    // ======================
    $logo_lama = $data['logo'] ?? '';
    $nama_file = $logo_lama;

    $folder = __DIR__ . "/../../dist/img/foto_perusahaan/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if (!empty($_FILES['logo']['name'])) {

        $tmp = $_FILES['logo']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $ext = preg_replace("/[^a-z0-9]/", "", $ext);

        $allowed = ["jpg", "jpeg", "png"];

        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Format logo harus JPG / PNG');window.location='?halaman=edit_profile_perusahaan';</script>";
            exit;
        }

        if ($_FILES['logo']['size'] > 2000000) {
            echo "<script>alert('Ukuran logo maksimal 2MB');window.location='?halaman=edit_profile_perusahaan';</script>";
            exit;
        }

        $nama_file = "logo_" . time() . "." . $ext;

        if (move_uploaded_file($tmp, $folder . $nama_file)) {

            if (!empty($logo_lama) && file_exists($folder . $logo_lama)) {
                unlink($folder . $logo_lama);
            }

        } else {
            echo "<script>alert('Upload logo gagal!');window.location='?halaman=edit_profile_perusahaan';</script>";
            exit;
        }
    }

    // ======================
    // UPDATE DATABASE
    // ======================
    $update = mysqli_query($con, "
    UPDATE tb_perusahaan SET
        nama_perusahaan='$nama_perusahaan',
        email='$email',
        alamat='$alamat',
        bidang_usaha='$bidang_usaha',
        jumlah_karyawan='$jumlah_karyawan',
        deskripsi='$deskripsi',
        manfaat='$manfaat',
        logo='$nama_file'
    WHERE id_perusahaan='$id_perusahaan'
    ");

    if ($update) {
        echo "<script>
        alert('Profil berhasil diperbarui!');
        window.location='?halaman=profile_perusahaan#perusahaan';
        </script>";
    } else {
        echo "<script>
        alert('Gagal update: " . mysqli_error($con) . "');
        window.location='?halaman=edit_profile_perusahaan';
        </script>";
    }
}
?>
<?php
// ✅ FIX: Path koneksi.php - sesuaikan dengan lokasi file ini
// Jika file ini di: adminbkk/pages/pendaftar/get_profile.php
// Maka: ../../koneksi.php = naik 2 level ke adminbkk/
include_once("../../koneksi.php");

// Set header JSON dan encoding
header('Content-Type: application/json; charset=utf-8');

// Validasi parameter id_siswa
if (!isset($_GET['id_siswa']) || empty($_GET['id_siswa'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Parameter id_siswa tidak valid',
        'data' => []
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$id_siswa = mysqli_real_escape_string($con, $_GET['id_siswa']);

$response = [
    'success' => false,
    'data' => [],
    'message' => ''
];

// ================= DATA SISWA =================
// ✅ FIX: Ambil field foto secara eksplisit untuk memastikan tersedia
$q_siswa = mysqli_query($con, "SELECT id_siswa, nama, nisn, jekel, tempat_lahir, tanggal_lahir, nik, agama, kewarganegaraan, status_perkawinan, alamat, no_hp, email, tinggi_badan, berat_badan, foto, id_user, prestasi, deskripsi FROM tb_siswa WHERE id_siswa='$id_siswa' LIMIT 1");

if (!$q_siswa) {
    echo json_encode([
        'success' => false,
        'message' => 'Query error: ' . mysqli_error($con),
        'data' => []
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$siswa = mysqli_fetch_assoc($q_siswa);

// ✅ FIX: Cek jika siswa tidak ditemukan
if (!$siswa) {
    echo json_encode([
        'success' => false,
        'message' => 'Data siswa tidak ditemukan',
        'data' => []
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$response['data']['siswa'] = $siswa;

// ================= PENDIDIKAN =================
$q_pendidikan = mysqli_query($con, "SELECT * FROM tb_pendidikan WHERE id_siswa='$id_siswa' ORDER BY FIELD(tingkat, 'SD', 'SMP', 'SMA/SMK', 'Lainnya')");
$response['data']['pendidikan'] = [];
if ($q_pendidikan) {
    while ($d = mysqli_fetch_assoc($q_pendidikan)) {
        $response['data']['pendidikan'][] = $d;
    }
}

// ================= PENGALAMAN =================
$q_pengalaman = mysqli_query($con, "SELECT * FROM tb_pengalaman WHERE id_siswa='$id_siswa' ORDER BY tanggal_mulai DESC");
$response['data']['pengalaman'] = [];
if ($q_pengalaman) {
    while ($d = mysqli_fetch_assoc($q_pengalaman)) {
        $response['data']['pengalaman'][] = $d;
    }
}

// ================= ORGANISASI =================
$q_org = mysqli_query($con, "SELECT * FROM tb_organisasi WHERE id_siswa='$id_siswa' ORDER BY tahun_mulai DESC");
$response['data']['organisasi'] = [];
if ($q_org) {
    while ($d = mysqli_fetch_assoc($q_org)) {
        $response['data']['organisasi'][] = $d;
    }
}

// ================= SERTIFIKASI =================
$q_sertifikat = mysqli_query($con, "SELECT * FROM tb_sertifikasi WHERE id_siswa='$id_siswa' ORDER BY tahun_sertifikat DESC");
$response['data']['sertifikasi'] = [];
if ($q_sertifikat) {
    while ($d = mysqli_fetch_assoc($q_sertifikat)) {
        $response['data']['sertifikasi'][] = $d;
    }
}

// ================= KELUARGA =================
$q_keluarga = mysqli_query($con, "SELECT * FROM tb_keluarga WHERE id_siswa='$id_siswa'");
$response['data']['keluarga'] = [];
if ($q_keluarga) {
    while ($d = mysqli_fetch_assoc($q_keluarga)) {
        $response['data']['keluarga'][] = $d;
    }
}

// ================= DOKUMEN =================
$q_dokumen = mysqli_query($con, "SELECT * FROM tb_dokumen WHERE id_siswa='$id_siswa' LIMIT 1");
$response['data']['dokumen'] = null;
if ($q_dokumen && mysqli_num_rows($q_dokumen) > 0) {
    $response['data']['dokumen'] = mysqli_fetch_assoc($q_dokumen);
}

// ================= SOSIAL MEDIA =================
$id_user = $response['data']['siswa']['id_user'] ?? '';
$response['data']['sosial_media'] = [];

if ($id_user && !empty($id_user)) {
    $q_sosmed = mysqli_query($con, "SELECT * FROM tb_sosial_media WHERE id_user='$id_user'");
    if ($q_sosmed) {
        while ($d = mysqli_fetch_assoc($q_sosmed)) {
            $response['data']['sosial_media'][] = $d;
        }
    }
}

// ✅ Set success dan kirim response
$response['success'] = true;
$response['message'] = 'Data berhasil diambil';

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
?>
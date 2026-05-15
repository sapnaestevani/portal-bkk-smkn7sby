<?php
// get_profile_data.php
// Endpoint AJAX untuk mengambil data profil siswa lengkap
// ⚠️ PENTING: Simpan file ini dengan encoding UTF-8 WITHOUT BOM

// 1. Matikan error display (agar tidak keluar HTML error yang merusak JSON)
error_reporting(0);
ini_set('display_errors', 0);

// 2. Bersihkan output buffer sebelum header
if (ob_get_level()) {
    ob_clean();
}

// 3. Set header JSON dengan charset UTF-8
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('X-Content-Type-Options: nosniff');

// 4. Start session jika diperlukan (opsional, sesuaikan dengan sistem Anda)
// if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 5. Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_bkk";

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    echo json_encode([
        'success' => false,
        'message' => 'Koneksi database gagal'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Set charset ke utf8mb4
mysqli_set_charset($con, 'utf8mb4');

// 6. Validasi input
if (!isset($_GET['id_siswa']) || empty($_GET['id_siswa'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID Siswa tidak ditemukan'
    ], JSON_UNESCAPED_UNICODE);
    mysqli_close($con);
    exit;
}

// Sanitasi input
$id_siswa = mysqli_real_escape_string($con, $_GET['id_siswa']);

// Inisialisasi response
$response = [
    'success' => false,
    'data' => [],
    'message' => ''
];

try {
    // ==================== 1. AMBIL DATA SISWA ====================
    $sql_siswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_siswa = '$id_siswa' LIMIT 1");
    
    if (!$sql_siswa) {
        throw new Exception('Query siswa gagal');
    }
    
    if (mysqli_num_rows($sql_siswa) == 0) {
        throw new Exception('Data siswa tidak ditemukan');
    }
    
    $response['data']['siswa'] = mysqli_fetch_assoc($sql_siswa);
    
    // ==================== 2. AMBIL DATA PENDIDIKAN ====================
    $sql_pendidikan = mysqli_query($con, "
        SELECT * FROM tb_pendidikan 
        WHERE id_siswa = '$id_siswa' 
        ORDER BY FIELD(tingkat, 'SD', 'SMP', 'SMA/SMK', 'Lainnya'), tgl_mulai ASC
    ");
    $response['data']['pendidikan'] = [];
    if ($sql_pendidikan) {
        while ($row = mysqli_fetch_assoc($sql_pendidikan)) {
            $response['data']['pendidikan'][] = $row;
        }
    }
    
    // ==================== 3. AMBIL DATA PENGALAMAN ====================
    $sql_pengalaman = mysqli_query($con, "
        SELECT * FROM tb_pengalaman 
        WHERE id_siswa = '$id_siswa' 
        ORDER BY tanggal_mulai DESC
    ");
    $response['data']['pengalaman'] = [];
    if ($sql_pengalaman) {
        while ($row = mysqli_fetch_assoc($sql_pengalaman)) {
            $response['data']['pengalaman'][] = $row;
        }
    }
    
    // ==================== 4. AMBIL DATA SERTIFIKASI ====================
    $sql_sertifikasi = mysqli_query($con, "
        SELECT * FROM tb_sertifikasi 
        WHERE id_siswa = '$id_siswa' 
        ORDER BY tahun_sertifikat DESC
    ");
    $response['data']['sertifikasi'] = [];
    if ($sql_sertifikasi) {
        while ($row = mysqli_fetch_assoc($sql_sertifikasi)) {
            $response['data']['sertifikasi'][] = $row;
        }
    }
    
    // ==================== 5. AMBIL DATA ORGANISASI ====================
    $sql_organisasi = mysqli_query($con, "
        SELECT * FROM tb_organisasi 
        WHERE id_siswa = '$id_siswa' 
        ORDER BY tahun_mulai DESC
    ");
    $response['data']['organisasi'] = [];
    if ($sql_organisasi) {
        while ($row = mysqli_fetch_assoc($sql_organisasi)) {
            $response['data']['organisasi'][] = $row;
        }
    }
    
    // ==================== 6. AMBIL DATA SOSIAL MEDIA ====================
    // tb_social_media menggunakan id_user, ambil dari data siswa
    $id_user = $response['data']['siswa']['id_user'] ?? null;
    $response['data']['sosial_media'] = [];
    
    if ($id_user && !empty($id_user)) {
        $id_user_esc = mysqli_real_escape_string($con, $id_user);
        $sql_sosmed = mysqli_query($con, "SELECT * FROM tb_social_media WHERE id_user = '$id_user_esc'");
        if ($sql_sosmed) {
            while ($row = mysqli_fetch_assoc($sql_sosmed)) {
                $response['data']['sosial_media'][] = $row;
            }
        }
    }
    
    // ==================== 7. AMBIL DATA KELUARGA ====================
    $sql_keluarga = mysqli_query($con, "SELECT * FROM tb_keluarga WHERE id_siswa = '$id_siswa'");
    $response['data']['keluarga'] = [];
    if ($sql_keluarga) {
        while ($row = mysqli_fetch_assoc($sql_keluarga)) {
            $response['data']['keluarga'][] = $row;
        }
    }
    
    // ==================== 8. AMBIL DATA DOKUMEN ====================
    $sql_dokumen = mysqli_query($con, "SELECT * FROM tb_dokumen WHERE id_siswa = '$id_siswa' LIMIT 1");
    $response['data']['dokumen'] = null;
    if ($sql_dokumen && mysqli_num_rows($sql_dokumen) > 0) {
        $response['data']['dokumen'] = mysqli_fetch_assoc($sql_dokumen);
    }
    
    // ==================== SUCCESS ====================
    $response['success'] = true;
    $response['message'] = 'Data berhasil diambil';
    
} catch (Exception $e) {
    // Log error ke server (tidak ditampilkan ke client)
    error_log('get_profile_data error: ' . $e->getMessage());
    
    $response['success'] = false;
    $response['message'] = 'Terjadi kesalahan pada server';
}

// Tutup koneksi
mysqli_close($con);

// Output JSON dan EXIT
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
?>
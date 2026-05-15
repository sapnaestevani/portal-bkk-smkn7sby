<?php
include_once("koneksi.php");

// Aktifkan strict mode agar error MySQL tertangkap dengan baik
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // ================== PROSES UBAH DATA ==================
    if (isset($_POST['btnUBAH'])) {
        
        // 1. Ambil & Bersihkan Input (Gunakan ?? untuk hindari Undefined Array Key)
        $nisn        = trim($_POST['txtnisn'] ?? '');
        $nama        = trim($_POST['txtnama'] ?? '');
        $jekel       = trim($_POST['rbjekel'] ?? '');
        $tempat_lahir = trim($_POST['txttempat_lahir'] ?? '');
        $tanggal_lahir = !empty($_POST['txttanggal_lahir']) ? $_POST['txttanggal_lahir'] : null;
        $no_hp       = trim($_POST['txtno_hp'] ?? '');
        $jurusan     = trim($_POST['txtjurusan'] ?? '');
        $tahun_lulus = !empty($_POST['txttahun']) ? intval($_POST['txttahun']) : null;
        $nik         = trim($_POST['txtnik'] ?? '');
        $agama       = trim($_POST['txtagama'] ?? '');
        $kewarganegaraan = trim($_POST['txtkewarganegaraan'] ?? '');
        $status_perkawinan = trim($_POST['rbstatus_perkawinan'] ?? '');
        $tinggi_badan = !empty($_POST['txttinggi']) ? intval($_POST['txttinggi']) : null;
        $berat_badan = !empty($_POST['txtberat']) ? intval($_POST['txtberat']) : null;
        $alamat      = trim($_POST['txtalamat'] ?? '');
        $email       = trim($_POST['txtemail'] ?? '');
        $deskripsi   = trim($_POST['txtdeskripsi'] ?? '');
        $prestasi    = trim($_POST['txtprestasi'] ?? '');

        // 2. Validasi Data Wajib
        if (empty($nisn) || empty($nama) || empty($jekel)) {
            throw new Exception("Data wajib (NISN, Nama, Jenis Kelamin) harus diisi!");
        }

        // 3. Escape String untuk Keamanan SQL Injection
        $nisn_esc       = mysqli_real_escape_string($con, $nisn);
        $nama_esc       = mysqli_real_escape_string($con, $nama);
        $jekel_esc      = mysqli_real_escape_string($con, $jekel);
        $tempat_lahir_esc = mysqli_real_escape_string($con, $tempat_lahir);
        $no_hp_esc      = mysqli_real_escape_string($con, $no_hp);
        $jurusan_esc    = mysqli_real_escape_string($con, $jurusan);
        $nik_esc        = mysqli_real_escape_string($con, $nik);
        $agama_esc      = mysqli_real_escape_string($con, $agama);
        $kewarganegaraan_esc = mysqli_real_escape_string($con, $kewarganegaraan);
        $alamat_esc     = mysqli_real_escape_string($con, $alamat);
        $email_esc      = mysqli_real_escape_string($con, $email);
        $deskripsi_esc  = mysqli_real_escape_string($con, $deskripsi);
        $prestasi_esc   = mysqli_real_escape_string($con, $prestasi);

        // 4. Bangun Query UPDATE (Sesuai Struktur tb_siswa)
        $sql_ubah = "UPDATE tb_siswa SET
            nama = '$nama_esc',
            jekel = '$jekel_esc',
            tempat_lahir = '$tempat_lahir_esc',
            tanggal_lahir = " . ($tanggal_lahir ? "'$tanggal_lahir'" : "NULL") . ",
            nik = '$nik_esc',
            agama = '$agama_esc',
            kewarganegaraan = '$kewarganegaraan_esc',
            status_perkawinan = '$status_perkawinan',
            alamat = '$alamat_esc',
            no_hp = '$no_hp_esc',
            email = '$email_esc',
            jurusan = '$jurusan_esc',
            tahun_lulus = " . ($tahun_lulus !== null ? "'$tahun_lulus'" : "NULL") . ",
            tinggi_badan = " . ($tinggi_badan !== null ? "'$tinggi_badan'" : "NULL") . ",
            berat_badan = " . ($berat_badan !== null ? "'$berat_badan'" : "NULL") . ",
            deskripsi = '$deskripsi_esc',
            prestasi = '$prestasi_esc'
            WHERE nisn = '$nisn_esc'";

        // 5. Eksekusi Query
        mysqli_query($con, $sql_ubah);
        
        echo "<script>alert('✅ Data Peserta Berhasil Diubah!'); window.location.href='?halaman=siswa_tampil';</script>";
        exit;
    }

    // ================== PROSES HAPUS DATA ==================
    elseif (isset($_GET['kode'])) {
        $nisn_hapus = mysqli_real_escape_string($con, $_GET['kode']);

        // ✅ STEP 1: Ambil id_siswa dan id_user untuk hapus data relasi
        $cek = mysqli_query($con, "SELECT id_siswa, id_user FROM tb_siswa WHERE nisn='$nisn_hapus' LIMIT 1");
        if ($row = mysqli_fetch_assoc($cek)) {
            $id_siswa = $row['id_siswa'];
            $id_user = $row['id_user'] ?? null;
            
            // ✅ STEP 2: Hapus data child tables dulu (hindari foreign key error)
            // Hapus dari tb_lamaran
            mysqli_query($con, "DELETE FROM tb_lamaran WHERE id_siswa='$id_siswa'");
            
            // Hapus dari tb_keluarga
            mysqli_query($con, "DELETE FROM tb_keluarga WHERE id_siswa='$id_siswa'");
            
            // Hapus dari tb_sosial_media (via id_user)
            if ($id_user) {
                mysqli_query($con, "DELETE FROM tb_sosial_media WHERE id_user='$id_user'");
            }
            
            // Hapus dari tb_dokumen
            mysqli_query($con, "DELETE FROM tb_dokumen WHERE id_siswa='$id_siswa'");
            
            // Hapus dari tb_pendidikan
            mysqli_query($con, "DELETE FROM tb_pendidikan WHERE id_siswa='$id_siswa'");
            
            // Hapus dari tb_sertifikasi
            mysqli_query($con, "DELETE FROM tb_sertifikasi WHERE id_siswa='$id_siswa'");
            
            // Hapus dari tb_organisasi
            mysqli_query($con, "DELETE FROM tb_organisasi WHERE id_siswa='$id_siswa'");
            
            // Hapus dari tb_pengalaman
            mysqli_query($con, "DELETE FROM tb_pengalaman WHERE id_siswa='$id_siswa'");
            
            // ✅ STEP 3: HAPUS JUGA DARI tb_user (agar tidak muncul di super_tampil)
            if ($id_user) {
                mysqli_query($con, "DELETE FROM tb_user WHERE id_user='$id_user'");
            }
        }

        // ✅ STEP 4: Hapus data siswa utama
        mysqli_query($con, "DELETE FROM tb_siswa WHERE nisn='$nisn_hapus'");
        
        echo "<script>alert('✅ Data Peserta Berhasil Dihapus!'); window.location.href='?halaman=siswa_tampil';</script>";
        exit;
    } else {
        header("Location: ?halaman=siswa_tampil");
        exit;
    }

} catch (mysqli_sql_exception $e) {
    // Tangani error database agar tidak crash (Fatal Error)
    $error_msg = $e->getMessage();
    
    echo "<script>alert('❌ Gagal: " . addslashes($error_msg) . "'); window.history.back();</script>";
    exit;
} catch (Exception $e) {
    echo "<script>alert('❌ Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    exit;
}
?>
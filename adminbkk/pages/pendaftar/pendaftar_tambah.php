<?php
include_once("koneksi.php");

// ✅ 1. Cek session untuk keamanan
session_start();
if (!isset($_SESSION['ses_level'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='../../login_perusahaan.php';</script>";
    exit;
}

// ✅ 2. Validasi file upload
if (!isset($_FILES['berkas']) || $_FILES['berkas']['error'] !== UPLOAD_ERR_OK) {
    echo "<script>alert('File tidak ditemukan atau upload gagal!'); window.history.back();</script>";
    exit;
}

// ✅ 3. Ambil dan sanitasi data file
$namaFile = $_FILES['berkas']['name'];
$namaSementara = $_FILES['berkas']['tmp_name'];
$ukuranFile = $_FILES['berkas']['size'];
$extFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

// ✅ 4. Validasi ekstensi file (hanya PDF, DOC, DOCX)
$allowedExt = ['pdf', 'doc', 'docx'];
if (!in_array($extFile, $allowedExt)) {
    echo "<script>alert('Format file tidak diperbolehkan! Gunakan PDF, DOC, atau DOCX.'); window.history.back();</script>";
    exit;
}

// ✅ 5. Validasi ukuran file (maksimal 5MB)
if ($ukuranFile > 5 * 1024 * 1024) {
    echo "<script>alert('Ukuran file terlalu besar! Maksimal 5MB.'); window.history.back();</script>";
    exit;
}

// ✅ 6. Sanitasi nama file (cegah karakter berbahaya)
$namaFile = preg_replace('/[^a-zA-Z0-9._-]/', '_', $namaFile);
$namaFile = time() . '_' . $namaFile; // Tambah timestamp agar unik

// ✅ 7. Tentukan lokasi upload & buat folder jika belum ada
$dirUpload = "pages/pendaftar/upload/";
if (!is_dir($dirUpload)) {
    mkdir($dirUpload, 0777, true);
}

// ✅ 8. Pindahkan file
$terupload = move_uploaded_file($namaSementara, $dirUpload . $namaFile);

if (!$terupload) {
    echo "<script>alert('Gagal mengupload file!'); window.history.back();</script>";
    exit;
}

// ✅ 9. Proses simpan ke database (HANYA jika form disubmit)
if (isset($_POST['btnSimpan'])) {
    
    // ✅ Sanitasi input POST
    $id_pendaftaran = mysqli_real_escape_string($con, $_POST['txtpendaftaran'] ?? '');
    $id_lowongan = mysqli_real_escape_string($con, $_POST['txtid_lowongan'] ?? '');
    $id_siswa = mysqli_real_escape_string($con, $_POST['txtid_siswa'] ?? '');
    
    // ✅ PERBAIKAN: Gunakan tabel & kolom yang BENAR sesuai database
    // tb_lamaran dengan kolom: id_lamaran, id_lowongan, id_siswa, cv
    $sql_insert = "INSERT INTO tb_lamaran (id_lamaran, id_lowongan, id_siswa, cv, status, tanggal_lamaran) 
                   VALUES ('$id_pendaftaran', '$id_lowongan', '$id_siswa', '$namaFile', 'Diproses', NOW())";
    
    $query_insert = mysqli_query($con, $sql_insert);
    
    if ($query_insert) {
        echo "<script>
            alert('✅ Data lamaran berhasil disimpan!');
            window.location='../../index.php?halaman=pendaftar_tampil';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal simpan data: " . mysqli_error($con) . "');
            window.history.back();
        </script>";
    }
}
?>
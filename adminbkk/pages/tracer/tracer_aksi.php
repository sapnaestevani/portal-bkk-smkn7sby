<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../../koneksi.php");

// Validasi parameter dengan sanitasi
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($con, $_GET['kode']) : '';

if (empty($kode)) {
    echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
    exit;
}

// Proses berdasarkan aksi
if ($aksi == 'hapus') {
    
    // Cek apakah data ada
    $check = mysqli_query($con, "SELECT * FROM tb_tracer WHERE id_tracer = '$kode'");
    
    if (mysqli_num_rows($check) == 0) {
        echo "<script>
            alert('❌ Data tidak ditemukan!');
            window.history.back();
        </script>";
        exit;
    }
    
    // Hapus data
    $sql_delete = "DELETE FROM tb_tracer WHERE id_tracer = '$kode'";
    
    if (mysqli_query($con, $sql_delete)) {
        echo "<script>
            alert('✅ Data berhasil dihapus!');
            window.location.href = document.referrer;
        </script>";
    } else {
        // Cek apakah error karena foreign key
        if (strpos(mysqli_error($con), 'foreign key') !== false) {
            echo "<script>
                alert('❌ Gagal menghapus!\\n\\nData ini masih memiliki keterkaitan dengan data lain.\\nHapus data terkait terlebih dahulu.');
                window.history.back();
            </script>";
        } else {
            echo "<script>
                alert('❌ Gagal menghapus: " . addslashes(mysqli_error($con)) . "');
                window.history.back();
            </script>";
        }
    }
} else {
    echo "<script>alert('Aksi tidak dikenal!'); window.history.back();</script>";
}

exit;
?>
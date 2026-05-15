<?php
// Hindari error jika session sudah aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("../koneksi.php");

// Pastikan session ada
if (!isset($_SESSION["ses_nisn"])) {
    echo "<script>window.location='../login.php';</script>";
    exit;
}

$nisn = $_SESSION["ses_nisn"];

// ==========================
// PROSES UPDATE
// ==========================
if (isset($_POST['btnSimpan'])) {

    $nama        = $_POST['nama'];
    $jekel       = $_POST['jekel'];
    $tempat_lhr  = $_POST['tempat_lhr'];
    $tgl_lhr     = $_POST['tgl_lhr'];
    $nama_ortu   = $_POST['nama_ortu'];
    $alamat      = $_POST['alamat'];
    $telp        = $_POST['telp'];
    $jurusan     = $_POST['jurusan'];
    $tahun_lulus = $_POST['tahun_lulus'];

    // Jika upload foto baru
    if (!empty($_FILES['foto']['name'])) {

        $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = "foto_" . time() . "." . $ext;
        $tmp  = $_FILES['foto']['tmp_name'];

        move_uploaded_file($tmp, "foto/" . $foto);

        $query = mysqli_query($con, "UPDATE tb_peserta SET
            nama='$nama',
            jekel='$jekel',
            tempat_lhr='$tempat_lhr',
            tgl_lhr='$tgl_lhr',
            nama_ortu='$nama_ortu',
            alamat='$alamat',
            telp='$telp',
            jurusan='$jurusan',
            tahun_lulus='$tahun_lulus',
            foto='$foto'
            WHERE nisn='$nisn'
        ");

    } else {

        $query = mysqli_query($con, "UPDATE tb_peserta SET
            nama='$nama',
            jekel='$jekel',
            tempat_lhr='$tempat_lhr',
            tgl_lhr='$tgl_lhr',
            nama_ortu='$nama_ortu',
            alamat='$alamat',
            telp='$telp',
            jurusan='$jurusan',
            tahun_lulus='$tahun_lulus'
            WHERE nisn='$nisn'
        ");
    }

    if ($query) {
        echo "<script>
            alert('Profil berhasil diperbarui');
            window.location='index_pst.php?halaman=profile';
        </script>";
        exit;
    }
}
?>
<?php
include_once("koneksi.php");

// ================== PROSES SIMPAN USER BARU ==================
if (isset($_POST['btnSIMPAN'])) {

    $username = mysqli_real_escape_string($con, $_POST['txtusername']);
    $nama = mysqli_real_escape_string($con, $_POST['txtnama']);
    // Hash password untuk keamanan (jika field password diisi)
    $password = !empty($_POST['txtpassword']) ? password_hash($_POST['txtpassword'], PASSWORD_DEFAULT) : '';
    $email = mysqli_real_escape_string($con, $_POST['txtemail']);
    $role = mysqli_real_escape_string($con, $_POST['rbstatus']); // Menggunakan 'role' bukan 'level'
    $status = 'aktif'; // Default status aktif

    // Validasi input wajib
    if (empty($username) || empty($nama) || empty($role)) {
        echo "<script>alert('❌ Username, Nama, dan Role wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah username sudah ada
    $cek_username = mysqli_query($con, "SELECT username FROM tb_user WHERE username='$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('❌ Username sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // 1. Insert ke tb_user terlebih dahulu
    $sql_simpan_user = "INSERT INTO tb_user (username, nama, password, email, role, status) VALUES (
        '$username',
        '$nama',
        '$password',
        '$email',
        '$role',
        '$status'
    )";

    $query_simpan_user = mysqli_query($con, $sql_simpan_user);

    if ($query_simpan_user) {
        // Ambil ID User yang baru saja dibuat
        $id_user_baru = mysqli_insert_id($con);

        // 2. Jika Role Siswa, buat entri dasar di tb_siswa agar foreign key terpenuhi
        if ($role == 'siswa') {
            mysqli_query($con, "INSERT INTO tb_siswa (id_user, nisn, nama) VALUES ('$id_user_baru', '$username', '$nama')");
        }
        // 3. Jika Role Perusahaan, buat entri dasar di tb_perusahaan
        elseif ($role == 'perusahaan') {
            mysqli_query($con, "INSERT INTO tb_perusahaan (id_user, nama_perusahaan, email) VALUES ('$id_user_baru', '$nama', '$email')");
        }

        echo "<script>alert('✅ User Berhasil Ditambahkan!');  window.location.href='index.php?halaman=super_tampil';
    </script>";
    } else {
        echo "<script>alert('❌ Gagal Menyimpan User: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}


// ================== PROSES UBAH DATA USER ==================
elseif (isset($_POST['btnUBAH'])) {

    $username = mysqli_real_escape_string($con, $_POST['txtusername']);
    $nama = mysqli_real_escape_string($con, $_POST['txtnama']);
    $email = mysqli_real_escape_string($con, $_POST['txtemail']);
    $role = mysqli_real_escape_string($con, $_POST['rbstatus']);

    // 1. Update tb_user terlebih dahulu
    if (!empty($_POST['txtpassword'])) {
        $password = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);
        $sql_ubah_user = "UPDATE tb_user SET nama='$nama', email='$email', role='$role', password='$password' WHERE username='$username'";
    } else {
        $sql_ubah_user = "UPDATE tb_user SET nama='$nama', email='$email', role='$role' WHERE username='$username'";
    }

    $query_ubah_user = mysqli_query($con, $sql_ubah_user);

    if ($query_ubah_user) {
        // 2. Ambil id_user untuk update di tabel terkait
        $get_id = mysqli_query($con, "SELECT id_user FROM tb_user WHERE username='$username'");
        $id_user = mysqli_fetch_assoc($get_id)['id_user'];

        // 3. Update juga di tabel profil terkait agar tampilan sinkron
        if ($role == 'siswa') {
            // Update nama & email di tb_siswa
            mysqli_query($con, "UPDATE tb_siswa SET nama='$nama', email='$email' WHERE id_user='$id_user'");
        } elseif ($role == 'perusahaan') {
            // Update nama_perusahaan & email di tb_perusahaan
            mysqli_query($con, "UPDATE tb_perusahaan SET nama_perusahaan='$nama', email='$email' WHERE id_user='$id_user'");
        }
        // Untuk Admin, tidak perlu update tabel lain karena datanya sudah ada di tb_user

        echo "<script>alert('✅ Data User Berhasil Diubah!'); window.location.href='/adminbkk/index.php?halaman=super_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal Mengubah Data: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}

// ================== PROSES HAPUS USER ==================
else {
    if (isset($_GET['kode'])) {
        $username = mysqli_real_escape_string($con, $_GET['kode']);

        try {
            // 1. Ambil ID User dan Role untuk menentukan tabel mana yang harus dibersihkan dulu
            $cek = mysqli_query($con, "SELECT id_user, role FROM tb_user WHERE username='$username'");
            $data_cek = mysqli_fetch_array($cek);

            if ($data_cek) {
                $id_user_hapus = $data_cek['id_user'];
                $role_user = $data_cek['role'];

                // 2. Hapus data terkait di tabel anak (tb_siswa atau tb_perusahaan) dulu
                // Ini penting untuk mencegah error Foreign Key Constraint
                if ($role_user == 'siswa') {
                    // Hapus lamaran siswa terlebih dahulu (jika ada)
                    $get_id_siswa = mysqli_query($con, "SELECT id_siswa FROM tb_siswa WHERE id_user='$id_user_hapus'");
                    if ($row_siswa = mysqli_fetch_assoc($get_id_siswa)) {
                        $id_siswa = $row_siswa['id_siswa'];
                        mysqli_query($con, "DELETE FROM tb_lamaran WHERE id_siswa='$id_siswa'");
                    }
                    // Hapus data siswa
                    mysqli_query($con, "DELETE FROM tb_siswa WHERE id_user='$id_user_hapus'");

                } elseif ($role_user == 'perusahaan') {
                    // Hapus lowongan milik perusahaan ini terlebih dahulu (jika ada)
                    $get_id_perusahaan = mysqli_query($con, "SELECT id_perusahaan FROM tb_perusahaan WHERE id_user='$id_user_hapus'");
                    if ($row_perusahaan = mysqli_fetch_assoc($get_id_perusahaan)) {
                        $id_perusahaan = $row_perusahaan['id_perusahaan'];
                        // Hapus lamaran yang terkait dengan lowongan perusahaan ini
                        mysqli_query($con, "DELETE FROM tb_lamaran WHERE id_lowongan IN (SELECT id_lowongan FROM tb_lowongan WHERE id_perusahaan='$id_perusahaan')");
                        // Hapus kelulusan yang terkait
                        mysqli_query($con, "DELETE FROM tb_kelulusan WHERE id_lowongan IN (SELECT id_lowongan FROM tb_lowongan WHERE id_perusahaan='$id_perusahaan')");
                        // Hapus jadwal yang terkait
                        mysqli_query($con, "DELETE FROM tb_jadwal WHERE id_lowongan IN (SELECT id_lowongan FROM tb_lowongan WHERE id_perusahaan='$id_perusahaan')");
                        // Hapus lowongan
                        mysqli_query($con, "DELETE FROM tb_lowongan WHERE id_perusahaan='$id_perusahaan'");
                    }
                    // Hapus data perusahaan
                    mysqli_query($con, "DELETE FROM tb_perusahaan WHERE id_user='$id_user_hapus'");
                }

                // 3. Baru hapus user dari tb_user
                $sql_hapus = "DELETE FROM tb_user WHERE username='$username'";
                $query_hapus = mysqli_query($con, $sql_hapus);

                if ($query_hapus) {
                    echo "<script>
        alert('✅ User Berhasil Dihapus!');
        window.location.href='index.php?halaman=super_tampil';
    </script>";
                    exit;
                } else {
                    throw new Exception(mysqli_error($con));
                }
            } else {
                echo "<script>alert('❌ User tidak ditemukan!'); window.location.href='../../index.php?halaman=super_tampil';</script>";
            }

        } catch (Exception $e) {
            echo "<script>alert('❌ Gagal Menghapus: " . addslashes($e->getMessage()) . "'); window.location.href='../../index.php?halaman=super_tampil';</script>";
        }
    }
}
?>
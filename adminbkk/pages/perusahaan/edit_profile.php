<?php
include_once(__DIR__ . "/../../koneksi.php");

// ======================
// CEK SESSION
// ======================
if (!isset($_SESSION['ses_username'])) {
    echo "<script>alert('Session habis! Silakan login ulang');window.location='../login_fix.php';</script>";
    exit;
}

$username = $_SESSION['ses_username'];

// ======================
// AMBIL DATA PERUSAHAAN
// ======================
$sql = mysqli_query($con, "
SELECT p.* FROM tb_perusahaan p
JOIN tb_user u ON p.id_user = u.id_user
WHERE u.username='$username'
") or die("Query error: " . mysqli_error($con));

$data = mysqli_fetch_assoc($sql);

// ======================
// VALIDASI DATA
// ======================
if (!$data) {
    echo "<div style='padding:20px; color:red; font-weight:bold;'>
    Data perusahaan tidak ditemukan! Silakan lengkapi profil terlebih dahulu.
    </div>";
    exit;
}

// ======================
// FOTO / LOGO
// ======================
if (empty($data['logo'])) {
    $foto_user = "dist/img/pegawai.png";
} else {
    $foto_user = "dist/img/foto_perusahaan/" . $data['logo'];
}
?>

<section class="content">

    <div class="box box-primary" style="max-width:800px; margin:auto;">
        <div class="box-header with-border">
            <h3 class="box-title" style="text-align:center; width:100%;">
                <b>Edit Profil Perusahaan</b>
            </h3>
        </div>

        <!-- ====================== -->
        <!-- FORM -->
        <!-- ====================== -->
        <form action="?halaman=profile_update_perusahaan" method="POST" enctype="multipart/form-data">

            <div class="box-body">

                <center>
                    <img src="<?= $foto_user; ?>"
                        style="width:180px; height:180px; border-radius:10px; object-fit:cover; border:3px solid #00a65a;">
                    <br><br>
                </center>

                <!-- Nama Perusahaan -->
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" class="form-control" name="nama_perusahaan"
                        value="<?= $data['nama_perusahaan']; ?>"
                        placeholder="Contoh: PT. Sapna Sejahtera Abadi"
                        required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email"
                        value="<?= $data['email']; ?>"
                        placeholder="Contoh: hrd@perusahaan.com"
                        required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" name="alamat"
                        value="<?= $data['alamat']; ?>"
                        placeholder="Contoh: Jl. Raya Gresik No. 123, Jawa Timur"
                        required>
                </div>

                <!-- Bidang Usaha -->
                <div class="form-group">
                    <label>Bidang Usaha</label>
                    <input type="text" class="form-control" name="bidang_usaha"
                        value="<?= $data['bidang_usaha']; ?>"
                        placeholder="Contoh: Teknologi Informasi / Manufaktur / Retail">
                </div>

                <!-- Jumlah Karyawan -->
                <div class="form-group">
                    <label>Jumlah Karyawan</label>
                    <input type="text" class="form-control" name="jumlah_karyawan"
                        value="<?= $data['jumlah_karyawan']; ?>"
                        placeholder="Contoh: 50 - 100 karyawan">
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label>Deskripsi Perusahaan</label>
                    <textarea class="form-control" name="deskripsi" rows="4"
                        placeholder="Contoh: Perusahaan yang bergerak di bidang teknologi dan fokus pada pengembangan aplikasi berbasis web dan mobile."><?= $data['deskripsi']; ?></textarea>
                </div>

                <!-- Manfaat -->
                <div class="form-group">
                    <label>Manfaat & Keuntungan</label>
                    <textarea class="form-control" name="manfaat" rows="3"
                        placeholder="Contoh: BPJS Kesehatan, Bonus Tahunan, Tunjangan Makan, Lingkungan Kerja Nyaman"><?= $data['manfaat']; ?></textarea>
                    <small style="color:gray;">
                        Pisahkan dengan koma (,)
                    </small>
                </div>

                <!-- Upload Logo -->
                <div class="form-group">
                    <label>Upload Logo Perusahaan</label>
                    <input type="file" class="form-control" name="logo">
                    <small style="color:gray;">Format JPG/PNG, maksimal 2MB</small>
                </div>

            </div>

            <!-- ====================== -->
            <!-- BUTTON -->
            <!-- ====================== -->
            <div class="box-footer">
                <button type="submit" name="btnUpdate" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
                <a href="?halaman=profile_perusahaan" class="btn btn-primary">Batal</a>
            </div>

        </form>

    </div>

</section>
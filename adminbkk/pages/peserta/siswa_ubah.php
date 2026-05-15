<?php
include_once("koneksi.php");

// Cek apakah parameter 'kode' (nisn) ada
if (!isset($_GET['kode'])) {
    echo "<script>alert('❌ Data tidak ditemukan!'); window.location.href='?halaman=siswa_tampil';</script>";
    exit;
}

// Sanitasi input untuk keamanan
$nisn_cek = mysqli_real_escape_string($con, $_GET['kode']);

// ✅ PERBAIKAN: Ganti 'tb_peserta' menjadi 'tb_siswa' (sesuai database Anda)
$sql_cek = "SELECT * FROM tb_siswa WHERE nisn='$nisn_cek'";
$query_cek = mysqli_query($con, $sql_cek);

// Cek apakah query berhasil dan data ditemukan
if (!$query_cek || mysqli_num_rows($query_cek) == 0) {
    echo "<script>alert('❌ Data siswa tidak ditemukan!'); window.location.href='?halaman=siswa_tampil';</script>";
    exit;
}

$data_cek = mysqli_fetch_assoc($query_cek);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Ubah Data Peserta
            <small>Perbarui informasi siswa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?halaman=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="?halaman=siswa_tampil">Peserta</a></li>
            <li class="active">Ubah Data</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border" style="text-align: center;">
                        <h3 class="box-title" style="display: inline-block; font-size: 20px;">
                            <i class="fa fa-edit"></i> Form Ubah Data Peserta
                        </h3>
                    </div>
                    
                    <form action="?halaman=siswa_aksi" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            
                            <!-- NISN (Readonly) -->
                            <div class="form-group">
                                <label>NISN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="txtnisn" 
                                       value="<?= htmlspecialchars($data_cek['nisn']); ?>" 
                                       readonly style="background:#f8f9fa; cursor:not-allowed;">
                                <small class="text-muted">NISN tidak dapat diubah.</small>
                            </div>

                            <!-- Nama Siswa -->
                            <div class="form-group">
                                <label>Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="txtnama" 
                                       placeholder="Masukkan Nama Siswa" 
                                       value="<?= htmlspecialchars($data_cek['nama']); ?>" required>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="form-group">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <div style="margin-top: 8px;">
                                    <label style="font-weight: normal; margin-right: 20px;">
                                        <input type="radio" name="rbjekel" value="Pria" 
                                               <?= ($data_cek['jekel'] == 'Pria') ? 'checked' : ''; ?>> Pria
                                    </label>
                                    <label style="font-weight: normal;">
                                        <input type="radio" name="rbjekel" value="Wanita" 
                                               <?= ($data_cek['jekel'] == 'Wanita') ? 'checked' : ''; ?>> Wanita
                                    </label>
                                </div>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="form-group">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="txttempat_lahir" 
                                       placeholder="Tempat Lahir" 
                                       value="<?= htmlspecialchars($data_cek['tempat_lahir']); ?>" required>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" name="txttanggal_lahir" 
                                       value="<?= !empty($data_cek['tanggal_lahir']) ? date('Y-m-d', strtotime($data_cek['tanggal_lahir'])) : ''; ?>">
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="txtalamat" rows="3" 
                                          placeholder="Masukkan Alamat Lengkap" required><?= htmlspecialchars($data_cek['alamat']); ?></textarea>
                            </div>

                            <!-- No. Telp -->
                            <div class="form-group">
                                <label>No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="txtno_hp" 
                                       placeholder="Contoh: 08123456789" 
                                       value="<?= htmlspecialchars($data_cek['no_hp']); ?>" required>
                            </div>

                            <!-- Jurusan -->
                            <div class="form-group">
                                <label>Jurusan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="txtjurusan" 
                                       placeholder="Contoh: Teknik Komputer dan Jaringan" 
                                       value="<?= htmlspecialchars($data_cek['jurusan']); ?>" required>
                            </div>

                            <!-- Tahun Lulus -->
                            <div class="form-group">
                                <label>Tahun Lulus <span class="text-danger">*</span></label>
                                <select name="txttahun" class="form-control" required>
                                    <option value="">- Pilih Tahun -</option>
                                    <?php
                                    $thn_skr = date('Y');
                                    for ($x = $thn_skr; $x >= 2010; $x--) {
                                        $selected = ($data_cek['tahun_lulus'] == $x) ? 'selected' : '';
                                        echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        
                        <div class="box-footer" style="text-align: center;">
                            <button type="submit" class="btn btn-warning" name="btnUBAH">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="?halaman=siswa_tampil" class="btn btn-default">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
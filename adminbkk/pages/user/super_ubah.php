<?php
include_once("koneksi.php");

// Cek apakah parameter 'kode' (username) ada
if (!isset($_GET['kode'])) {
    echo "<script>alert('❌ Data tidak ditemukan!'); window.location.href='?halaman=super_tampil';</script>";
    exit;
}

$username_cek = mysqli_real_escape_string($con, $_GET['kode']);

// Query untuk mengambil data user dari tb_user
$sql_cek = "SELECT * FROM tb_user WHERE username='$username_cek'";
$query_cek = mysqli_query($con, $sql_cek);

if (!$query_cek || mysqli_num_rows($query_cek) == 0) {
    echo "<script>alert('❌ User tidak ditemukan!'); window.location.href='?halaman=super_tampil';</script>";
    exit;
}

$data_cek = mysqli_fetch_assoc($query_cek);
?>

<div class="form-group">
    <br>
    <div class="card mb-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">✏️ Ubah Data User</h3>
            </div>
            
            <div class="box-body">
                <!-- Form Action mengarah ke super_aksi.php -->
                <form action="?halaman=super_aksi" method="post">
                    
                    <!-- Username (Readonly) -->
                    <div class="form-group">
                        <label>Username (NIP/NISN)</label>
                        <input type="text" class="form-control" name="txtusername" 
                               value="<?= htmlspecialchars($data_cek['username']); ?>" readonly 
                               style="background:#f8f9fa; cursor:not-allowed;">
                        <small class="text-muted">Username tidak dapat diubah.</small>
                    </div>

                    <!-- Nama -->
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="txtnama" 
                               value="<?= htmlspecialchars($data_cek['nama']); ?>" required>
                    </div>

                    <!-- Password (Opsional) -->
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" class="form-control" name="txtpassword" 
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti password.</small>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="txtemail" 
                               value="<?= htmlspecialchars($data_cek['email']); ?>" required>
                    </div>

                    <!-- Role/Level -->
                    <div class="form-group">
                        <label>Role Pengguna <span class="text-danger">*</span></label>
                        <select name="rbstatus" class="form-control" required>
                            <!-- Opsi Admin -->
                            <option value="admin" <?= ($data_cek['role'] == 'admin') ? 'selected' : ''; ?>>
                                Admin / Ka. BKK
                            </option>
                            <!-- Opsi Perusahaan -->
                            <option value="perusahaan" <?= ($data_cek['role'] == 'perusahaan') ? 'selected' : ''; ?>>
                                Perusahaan / CV
                            </option>
                            <!-- Opsi Siswa -->
                            <option value="siswa" <?= ($data_cek['role'] == 'siswa') ? 'selected' : ''; ?>>
                                Siswa / Alumni
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning btn-sm" name="btnUBAH">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="?halaman=super_tampil" class="btn btn-secondary btn-sm">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
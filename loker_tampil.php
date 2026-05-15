<?php
// ============================================
// 1. INISIALISASI & KEAMANAN
// ============================================
include_once("koneksi.php");  // ✅ Menghubungkan ke database
session_start();              // ✅ Memulai session untuk akses data login

// ✅ Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login!'); window.location='login_perusahaan.php';</script>";
    exit;  // ✅ Hentikan eksekusi jika belum login
}

// ✅ Ambil data dari session
$id_user = $_SESSION['id_user'];  // ID user yang login
$data_status = isset($_SESSION['ses_level']) ? $_SESSION['ses_level'] : '';  // Level user (admin/perusahaan)

// ✅ Ambil nama perusahaan (dari session atau database)
if (isset($_SESSION['ses_nama'])) {
    $data_nama = $_SESSION['ses_nama'];  // ✅ Lebih cepat: ambil dari session
} else {
    // ✅ Fallback: ambil dari database jika session kosong
    $getUser = mysqli_query($con, "SELECT nama_perusahaan FROM tb_perusahaan WHERE id_user='$id_user'");
    $userData = mysqli_fetch_assoc($getUser);
    $data_nama = $userData['nama_perusahaan'] ?? '';
}
?>

<!-- ============================================
     2. STRUKTUR HTML TAMPILAN
     ============================================ -->
<div class="form-group">
    <br>
    <div class="card mb-3">
        <div class="card-header">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lowongan Kerja</h3>
                    <!-- Tombol collapse/remove box -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="box-body">
                    <!-- Judul dengan efek neon -->
                    <div class="neon-container">
                        <h4 class="text-center">Informasi Lowongan Update</h4>
                    </div>
                    
                    <!-- Tabel Data Lowongan -->
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perusahaan</th>
                                <th>Lowongan</th>
                                <th>Jenis Kelamin</th>
                                <th>Keterangan</th>
                                <th>Sumber</th>
                                <th>Batas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // ============================================
                            // 3. QUERY DATA DARI DATABASE
                            // ============================================
                            
                            // ✅ PERBAIKAN: Gunakan tb_lowongan dengan filter id_perusahaan
                            $sql_tampil = "SELECT l.*, p.nama_perusahaan 
                                          FROM tb_lowongan l
                                          INNER JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan
                                          WHERE p.id_user = '$id_user'  // ✅ Filter: hanya lowongan milik user ini
                                          ORDER BY l.tanggal_posting DESC";
                            
                            $query_tampil = mysqli_query($con, $sql_tampil);
                            
                            // ✅ Error handling jika query gagal
                            if (!$query_tampil) {
                                echo "<tr><td colspan='7' class='text-danger'>Error: " . mysqli_error($con) . "</td></tr>";
                            } 
                            // ✅ Cek jika tidak ada data
                            elseif (mysqli_num_rows($query_tampil) == 0) {
                                echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada lowongan yang dibuat.</td></tr>";
                            } 
                            // ✅ Tampilkan data jika ada
                            else {
                                $no = 1;
                                while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
                            ?>
                            <tr>       
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($data['nama_perusahaan']); ?></td>
                                <td><?php echo htmlspecialchars($data['judul_lowongan']); ?></td>
                                <td><?php echo isset($data['jekel']) ? htmlspecialchars($data['jekel']) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($data['posisi'] ?? $data['keterangan'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($data['sumber'] ?? '-'); ?></td>
                                <td><?php echo isset($data['batas_lamaran']) ? date('d F Y', strtotime($data['batas_lamaran'])) : '-'; ?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     4. CSS UNTUK EFEK VISUAL (NEON)
     ============================================ -->
<style>
.neon-container {
    width: 100%;
    max-width: 600px;
    padding: 10px;
    margin: 50px auto;
    text-align: center;
    background-color: #070e69;
    border-radius: 10px;
    transition: box-shadow 0.3s ease-in-out;
}

.neon-container h4 {
    color: #fff;
    font-size: 1.8em;
    margin: 0;
}

/* Efek neon saat hover */
.neon-container:hover {
    box-shadow: 0 0 20px rgba(135, 206, 250, 0.8),
                0 0 30px rgba(135, 206, 250, 0.8),
                0 0 40px rgba(135, 206, 250, 1),
                0 0 60px rgba(135, 206, 250, 1) !important;
}
</style>
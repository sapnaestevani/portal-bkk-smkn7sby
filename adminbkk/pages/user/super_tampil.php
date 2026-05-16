<?php
include_once("koneksi.php");

// Session handling untuk keamanan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek akses: Hanya admin/super user yang boleh lihat halaman ini
if (!isset($_SESSION['ses_username']) || ($_SESSION['ses_level'] ?? '') != 'admin') {
    echo "<script>alert('❌ Akses ditolak!'); window.location.href='../login.php';</script>";
    exit;
}
?>

<style>
    /* Modern Table Styling */
    .modern-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 20px 0;
        margin-top: 15px;
    }
    
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .modern-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-modern-primary {
        background: white;
        color: #667eea;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: #764ba2;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    
    .modern-table thead {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    
    .modern-table thead th {
        padding: 15px;
        text-align: left;
        font-weight: 700;
        color: #2d3748;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .modern-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        transform: scale(1.01);
    }
    
    .modern-table tbody td {
        padding: 15px;
        color: #4a5568;
        font-size: 14px;
        border: none;
        vertical-align: middle;
    }
    
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-role {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .badge-status-active {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .badge-status-inactive {
        background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        color: white;
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        font-size: 14px;
    }
    
    .btn-deactivate {
        background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
    }
    
    .btn-activate {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    
    .btn-action:hover {
        transform: translateY(-2px) rotate(5deg);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        color: white;
    }
    
    .dataTables_wrapper {
        padding: 20px;
    }
    
    .dataTables_length, .dataTables_filter {
        margin-bottom: 20px;
    }
    
    .dataTables_filter input {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 15px;
        margin-left: 10px;
        transition: all 0.3s ease;
    }
    
    .dataTables_filter input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 3px;
        border: none !important;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
        color: #2d3748 !important;
        transition: all 0.3s ease;
    }
    
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .modern-header {
            flex-direction: column;
            text-align: center;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        .modern-table {
            font-size: 12px;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 10px 8px;
        }
    }
</style>
<div class="modern-table-container">
    <div class="modern-header">
        <h3><i class="fa fa-users"></i> Manajemen User (Super Admin)</h3>
        <a href="?halaman=super_tambah" class="btn-modern-primary">
            <i class="fa fa-plus"></i> Tambah User
        </a>
    </div>
    
    <div class="table-responsive">
        <table id="example1" class="modern-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role/Posisi</th>
                    <th>Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                
                // ✅ QUERY PERBAIKAN: Menggunakan LEFT JOIN untuk mengambil nama & email dari tabel terkait
                // Menambahkan COALESCE untuk menangani NULL dengan lebih baik
                $sql_tampil = "
                    SELECT 
                        u.id_user,
                        u.username,
                        u.role,
                        u.status,
                        u.nama AS nama_user,
                        u.email AS email_user,
                        s.nama AS nama_siswa,
                        s.email AS email_siswa,
                        p.nama_perusahaan AS nama_perusahaan,
                        p.email AS email_perusahaan
                    FROM tb_user u
                    LEFT JOIN tb_siswa s ON u.id_user = s.id_user
                    LEFT JOIN tb_perusahaan p ON u.id_user = p.id_user
                    ORDER BY u.id_user DESC
                ";
                
                $query_tampil = mysqli_query($con, $sql_tampil);

                if (!$query_tampil) {
                    echo "<tr><td colspan='7' class='text-danger text-center'>Error Query: " . mysqli_error($con) . "</td></tr>";
                } elseif (mysqli_num_rows($query_tampil) == 0) {
                    echo "<tr><td colspan='7'>
                            <div class='empty-state'>
                                <i class='fa fa-users'></i>
                                <h4>📭 Belum ada data user.</h4>
                            </div>
                          </td></tr>";
                } else {
                    while ($data = mysqli_fetch_assoc($query_tampil)) {
                        
                        // Logika menentukan Nama dan Email berdasarkan Role
                        $role = $data['role'];
                        
                        // Prioritas: Data dari tabel profil > Data dari tb_user > Username
                        if ($role == 'siswa') {
                            $nama_tampil = !empty($data['nama_siswa']) ? $data['nama_siswa'] : ($data['nama_user'] ?: $data['username']);
                            $email_tampil = !empty($data['email_siswa']) ? $data['email_siswa'] : ($data['email_user'] ?: '-');
                        } 
                        elseif ($role == 'perusahaan') {
                            $nama_tampil = !empty($data['nama_perusahaan']) ? $data['nama_perusahaan'] : ($data['nama_user'] ?: $data['username']);
                            $email_tampil = !empty($data['email_perusahaan']) ? $data['email_perusahaan'] : ($data['email_user'] ?: '-');
                        } 
                        else { // Admin atau role lainnya
                            $nama_tampil = !empty($data['nama_user']) ? $data['nama_user'] : $data['username'];
                            $email_tampil = !empty($data['email_user']) ? $data['email_user'] : '-';
                        }

                        $status = $data['status'] ?? 'nonaktif';
                ?>
                <tr>       
                    <td class="text-center"><strong><?= $no++; ?></strong></td>
                    <td><strong style="color: #2d3748;"><?= htmlspecialchars($data['username']); ?></strong></td>
                    <td><?= htmlspecialchars($nama_tampil); ?></td>
                    <td><?= htmlspecialchars($email_tampil); ?></td>
                    <td>
                        <span class="badge-modern badge-role"><?= ucfirst($role); ?></span>
                    </td>
                    <td>
                        <?php if ($status == 'aktif'): ?>
                            <span class="badge-modern badge-status-active"><?= ucfirst($status); ?></span>
                        <?php else: ?>
                            <span class="badge-modern badge-status-inactive"><?= ucfirst($status); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <?php if ($status == 'aktif'): ?>
                            <!--    <a href="?halaman=super_nonaktif&kode=<?= urlencode($data['username']); ?>" 
                                   class="btn-action btn-deactivate" 
                                   onclick="return confirm('Yakin ingin menonaktifkan user <?= htmlspecialchars($data['username']); ?>?')"
                                   title="Nonaktifkan">
                                    <i class="fa fa-times"></i>
                                </a> -->
                            <?php else: ?>
                            <!--    <a href="?halaman=super_aktif&kode=<?= urlencode($data['username']); ?>" 
                                   class="btn-action btn-activate" 
                                   onclick="return confirm('Yakin ingin mengaktifkan user <?= htmlspecialchars($data['username']); ?>?')"
                                   title="Aktifkan">
                                    <i class="fa fa-check"></i>
                                </a> -->
                            <?php endif; ?>
                            
                            <a href="?halaman=super_ubah&kode=<?= urlencode($data['username']); ?>" 
                               class="btn-action btn-edit" 
                               title="Ubah Data">
                                <i class="fa fa-edit"></i>
                            </a>
                            
                            <a href="?halaman=super_aksi&aksi=hapus&kode=<?= urlencode($data['username']); ?>" 
                               onclick="return confirm('⚠️ Yakin ingin menghapus user <?= htmlspecialchars($data['username']); ?> secara permanen?')" 
                               class="btn-action btn-delete" 
                               title="Hapus Permanen">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php 
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script DataTables -->
<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#example1')) $('#example1').DataTable().destroy();
    $('#example1').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'responsive': true,
        'language': {
            'search': '🔍 Cari:',
            'lengthMenu': 'Tampilkan _MENU_ data',
            'info': 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            'paginate': { 'first': '«', 'last': '»', 'next': '›', 'previous': '‹' },
            'zeroRecords': 'Tidak ada data ditemukan',
            'emptyTable': 'Tidak ada data tersedia'
        }
    });
});
</script>
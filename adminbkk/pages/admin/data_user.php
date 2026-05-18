<?php
// Hitung total data untuk badge
$total_siswa = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_user WHERE role='siswa'"));
$total_perusahaan = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_user WHERE role='perusahaan'"));
?>

<style>
    /* Modern Account Data Styling */
    .account-data-container {
        padding: 20px -30px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e1e6f0 100%);
        min-height: 100vh;
        animation: fadeIn 0.6s ease;
    }
    
    .page-header-modern {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .page-header-modern h1 {
        font-size: 36px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }
    
    .page-header-modern p {
        color: #718096;
        font-size: 16px;
    }
    
    .tables-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .modern-table-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .modern-table-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }
    
    .table-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .table-header-modern.perusahaan {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .table-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }
    
    .table-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .badge-count {
        background: rgba(255, 255, 255, 0.25);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }
    
    .table-body-modern {
        padding: 0;
        max-height: 400px;
        overflow-y: auto;
    }
    
    .table-body-modern::-webkit-scrollbar {
        width: 8px;
    }
    
    .table-body-modern::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-body-modern::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }
    
    .table-body-modern::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    
    .modern-table thead {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .modern-table thead th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 700;
        color: #2d3748;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        border-bottom: 2px solid #cbd5e0;
    }
    
    .modern-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:last-child {
        border-bottom: none;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        transform: scale(1.005);
    }
    
    .modern-table tbody td {
        padding: 16px 20px;
        color: #4a5568;
        font-size: 14px;
        border: none;
        vertical-align: middle;
    }
    
    .modern-table tbody td:first-child {
        font-weight: 600;
        color: #667eea;
        width: 60px;
        text-align: center;
    }
    
    .modern-table tbody td:nth-child(2) {
        font-weight: 600;
        color: #2d3748;
    }
    
    .text-warning-custom {
        color: #f59e0b;
        font-weight: 600;
        font-style: italic;
    }
    
    .badge-role {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-siswa {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    
    .badge-perusahaan {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(17, 153, 142, 0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 768px) {
        .table-header-modern {
            flex-direction: column;
            text-align: center;
        }
        
        .table-title {
            justify-content: center;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 15px;
            font-size: 13px;
        }
        
        .modern-table tbody td:nth-child(2) {
            word-break: break-all;
        }
    }
</style>

<div class="account-data-container">
    <div class="page-header-modern">
        <h1>🔐 Data Akun Pengguna</h1>
        <p>Kelola akun peserta dan perusahaan</p>
    </div>
    
    <div class="tables-grid">
        <!-- Data Akun Peserta -->
        <div class="modern-table-card">
            <div class="table-header-modern">
                <div class="table-title">
                    <div class="table-icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    Data Akun Peserta
                </div>
                <span class="badge-count"><?= $total_siswa; ?> Akun</span>
            </div>
            
            <div class="table-body-modern">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th width="15%">Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($con, "
                            SELECT s.nisn, s.nama, u.role
                            FROM tb_user u
                            LEFT JOIN tb_siswa s 
                            ON u.id_user = s.id_user
                            WHERE u.role='siswa'
                        ");
                        
                        if (mysqli_num_rows($query) > 0) {
                            while($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($data['nisn']); ?></strong></td>
                            <td>
                                <?php 
                                if (!empty($data['nama'])) {
                                    echo htmlspecialchars($data['nama']);
                                } else {
                                    echo "<span class='text-warning-custom'><i class='fa fa-exclamation-circle'></i> Belum ada</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <span class="badge-role badge-siswa"><?= htmlspecialchars($data['role']); ?></span>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='4'><div class='empty-state'><i class='fa fa-users'></i><p>Tidak ada data peserta</p></div></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Data Akun Perusahaan -->
        <div class="modern-table-card">
            <div class="table-header-modern perusahaan">
                <div class="table-title">
                    <div class="table-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    Data Akun Perusahaan
                </div>
                <span class="badge-count"><?= $total_perusahaan; ?> Akun</span>
            </div>
            
            <div class="table-body-modern">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Nama Perusahaan</th>
                            <th width="15%">Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($con, "
                            SELECT u.username, p.nama_perusahaan, u.role
                            FROM tb_user u
                            LEFT JOIN tb_perusahaan p 
                            ON u.id_user = p.id_user
                            WHERE u.role='perusahaan'
                        ");
                        
                        if (mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($data['username']); ?></strong></td>
                            <td>
                                <?php 
                                if (!empty($data['nama_perusahaan'])) {
                                    echo htmlspecialchars($data['nama_perusahaan']);
                                } else {
                                    echo "<span class='text-warning-custom'><i class='fa fa-exclamation-circle'></i> Belum isi</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <span class="badge-role badge-perusahaan">Perusahaan</span>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='4'><div class='empty-state'><i class='fa fa-building'></i><p>Tidak ada data perusahaan</p></div></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
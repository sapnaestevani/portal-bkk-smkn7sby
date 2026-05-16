<style>
    /* Modern Card Layout */
    .modern-grid-container{
    width:100%;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:20px;
    padding:10px 0 20px;
}

    .modern-card{
    width:100%;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
    transition:0.3s ease;
    position:relative;
    border:1px solid #f1f5f9;
}

    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-number {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
    }

    .status-badge-modern {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-aktif {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(17, 153, 142, 0.3);
    }

    .status-nonaktif {
        background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(252, 74, 26, 0.3);
    }

    .card-body-modern {
        padding: 25px;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 18px;
        gap: 12px;
    }

    .info-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 12px;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 14px;
        color: #2d3748;
        font-weight: 500;
        line-height: 1.5;
    }

    .info-value.username {
        color: #667eea;
        font-weight: 600;
        font-size: 15px;
    }

    .info-value.role {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .card-actions {
        padding: 20px 25px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-action-modern {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        font-size: 15px;
        position: relative;
        overflow: hidden;
    }

    .btn-action-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-action-modern:hover::before {
        opacity: 1;
    }

    .btn-deactivate {
        background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        box-shadow: 0 4px 12px rgba(252, 74, 26, 0.3);
    }

    .btn-activate {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
    }

    .btn-edit-modern {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
    }

    .btn-delete-modern {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);
    }

    .btn-action-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    /* DataTables Styling */
    .dataTables_wrapper {
        padding: 20px;
    }

    .dataTables_filter input {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 16px;
        margin-left: 10px;
        transition: all 0.3s ease;
    }

    .dataTables_filter input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .dataTables_length select {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 6px 12px;
        transition: all 0.3s ease;
    }

    .dataTables_length select:focus {
        outline: none;
        border-color: #667eea;
    }

    .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 3px;
        border: none !important;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
        color: #2d3748 !important;
        transition: all 0.3s ease;
        padding: 8px 14px !important;
    }

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .box-body {
        margin-top: -20px;
    }

    /* SEARCH */
/* SEARCH */
.search-wrapper-modern{
    width:100%;
    display:flex;
    justify-content:flex-end;
    margin-bottom:20px;
}

.search-box-modern{
    width:100%;
    max-width:420px;
    position:relative;
}

.search-box-modern i{
    position:absolute;
    top:50%;
    left:15px;
    transform:translateY(-50%);
    color:#667eea;
    font-size:15px;
}

.search-box-modern input{
    width:100%;
    height:48px;
    border:none;
    outline:none;
    border-radius:14px;
    padding:0 15px 0 45px;
    background:#fff;
    font-size:14px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:0.3s ease;
}

.search-box-modern input:focus{
    box-shadow:0 4px 20px rgba(102,126,234,0.25);
}

/* MOBILE */
@media(max-width:768px){

    /* SEARCH */
.search-wrapper-modern{
    width:100%;
    display:flex;
    justify-content:flex-end;
    margin-bottom:20px;
}

.search-box-modern{
    width:100%;
    max-width:420px;
    position:relative;
}

.search-box-modern i{
    position:absolute;
    top:50%;
    left:15px;
    transform:translateY(-50%);
    color:#667eea;
    font-size:15px;
}

.search-box-modern input{
    width:100%;
    height:48px;
    border:none;
    outline:none;
    border-radius:14px;
    padding:0 15px 0 45px;
    background:#fff;
    font-size:14px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:0.3s ease;
}

.search-box-modern input:focus{
    box-shadow:0 4px 20px rgba(102,126,234,0.25);
}
}

    /* Responsive */
    @media(max-width:768px){

    body{
        overflow-x:hidden;
    }

    .box-body{
        margin-top:15px;
    }

    .search-wrapper-modern{
        justify-content:center;
        margin-bottom:15px;
    }

    .search-box-modern{
        max-width:100%;
    }

    .search-box-modern input{
        height:45px;
        font-size:13px;
    }

    .modern-grid-container{
        grid-template-columns:1fr;
        gap:15px;
    }

    .modern-card{
        border-radius:15px;
    }

    .card-header-modern{
        flex-direction:row;
        align-items:center;
        justify-content:space-between;
        padding:15px;
    }

    .card-body-modern{
        padding:18px;
    }

    .info-row{
        gap:10px;
        margin-bottom:15px;
    }

    .info-icon{
        width:32px;
        height:32px;
        font-size:14px;
    }

    .info-label{
        font-size:11px;
    }

    .info-value{
        font-size:13px;
        word-break:break-word;
    }

    .card-actions{
        padding:15px;
        flex-wrap:wrap;
        justify-content:center;
    }

    .btn-action-modern{
        width:35px;
        height:35px;
        font-size:13px;
    }

    .btn-sm{
        width:100%;
        text-align:center;
    }

}
</style>
<div class="box-body">
    <!-- SEARCH -->
<div class="search-wrapper-modern">
    <div class="search-box-modern">
        <i class="fa fa-search"></i>
        <input type="text" id="searchPerusahaan" placeholder="Cari nama perusahaan...">
    </div>
</div>
    <div class="modern-grid-container">
        <?php
        $query_tampil = mysqli_query($con, "
            SELECT u.*, p.id_perusahaan, p.alamat, p.bidang_usaha
            FROM tb_user u
            JOIN tb_perusahaan p ON u.id_user = p.id_user
            WHERE u.role='perusahaan'
        ");
        $no = 1;

        while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
            ?>
            <div class="modern-card perusahaan-card"
     data-perusahaan="<?= strtolower(htmlspecialchars($data['nama'])); ?>">
                <div class="card-header-modern">
                    <div class="card-number"><?= $no++; ?></div>
                    <span
                        class="status-badge-modern <?= $data['status'] == 'aktif' ? 'status-aktif' : 'status-nonaktif'; ?>">
                        <?= ucfirst($data['status']); ?>
                    </span>
                </div>

                <div class="card-body-modern">
                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Username</div>
                            <div class="info-value username"><?= htmlspecialchars($data['username']); ?></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nama Perusahaan</div>
                            <div class="info-value"><?= htmlspecialchars($data['nama']); ?></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= htmlspecialchars($data['email']); ?></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Alamat</div>
                            <div class="info-value"><?= htmlspecialchars($data['alamat']); ?></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Bidang Usaha</div>
                            <div class="info-value"><?= htmlspecialchars($data['bidang_usaha'] ?? '-'); ?></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fa fa-shield"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Posisi</div>
                            <span class="info-value role"><?= ucfirst($data['role']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="card-actions">

    <!-- ✅ TOMBOL DETAIL (TAMBAHKAN DI SINI) -->
    <a href="index.php?halaman=perusahaan_detail&id=<?= $data['id_perusahaan']; ?>" 
       class="btn-action-modern btn-edit-modern" 
       title="Lihat Detail">
        <i class="fa fa-eye"></i>
    </a>

    <?php if ($data['status'] == 'aktif') { ?>
        <a href="pages/perusahaan/perusahaan_aksi.php?aksi=nonaktif&kode=<?= $data['username']; ?>"
           onclick="return confirm('Yakin ingin menonaktifkan akun ini?')" 
           class="btn btn-danger btn-sm">
            <i class="fa fa-ban"></i> Nonaktifkan
        </a>
    <?php } else { ?>
        <a href="pages/perusahaan/perusahaan_aksi.php?aksi=aktif&kode=<?= $data['username']; ?>"
           onclick="return confirm('Yakin ingin mengaktifkan akun ini?')" 
           class="btn btn-success btn-sm">
            <i class="fa fa-check"></i> Aktifkan
        </a>
    <?php } ?>

    <!-- <a href="?halaman=super_ubah&kode=<?php echo $data['username']; ?>" 
                       class="btn-action-modern btn-edit-modern" 
                       title="Edit">
                        <i class="fa fa-edit"></i> 
                    </a> -->

    <a href="?halaman=super_aksi&kode=<?php echo $data['username']; ?>"
       onclick="return confirm('Apakah anda yakin hapus data ini ?')"
       class="btn-action-modern btn-delete-modern" 
       title="Hapus">
        <i class="fa fa-trash"></i>
    </a>

</div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const input = document.getElementById("searchPerusahaan");

    const cards = document.querySelectorAll(".perusahaan-card");

    input.addEventListener("input", function(){

        let keyword = input.value.toLowerCase().trim();

        cards.forEach(function(card){

            let text = card.innerText.toLowerCase();

            if(text.includes(keyword)){

                card.style.display = "";

            }else{

                card.style.display = "none";

            }

        });

    });

});

</script>
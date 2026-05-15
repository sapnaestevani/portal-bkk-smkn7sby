<?php 
include_once("koneksi.php");

// AUTO ID
$carikode = mysqli_query($con,"SELECT MAX(id_sekolah) FROM tb_sekolah") or die (mysqli_error($con));
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $nilaikode = substr($datakode[0], 3);
    $kode = (int) $nilaikode + 1;
    $hasilkode = "YSM".str_pad($kode,2, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "YSM01";
}
?>

<div class="card">
<div class="box box-primary">

<div class="box-header with-border d-flex justify-content-between align-items-center">
    <h3 class="box-title">Profil Sekolah</h3>

    <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Tambah Data
    </a>
</div>

<div class="box-body">

<div class="row">

<?php
$sql = mysqli_query($con, "SELECT * FROM tb_sekolah");

while ($data = mysqli_fetch_array($sql)) {

    // contoh hitung jumlah siswa & jurusan (sesuaikan tabel kamu)
    $jumlah_siswa = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_siswa"));
    $jumlah_jurusan = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_jurusan"));
?>

<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card-sekolah">

        <!-- HEADER -->
        <div class="header-sekolah">

            <div class="header-content">
                <img src="dist/img/sekolah.png" class="logo-sekolah">

                <div>
                    <h4><?php echo $data['nama_sekolah']; ?></h4>
                    <small>ID: <?php echo $data['id_sekolah']; ?></small>
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="body-sekolah">

            <div class="info-item">
                <i class="fa fa-envelope"></i>
                <span><?php echo $data['email']; ?></span>
            </div>

            <div class="info-item">
                <i class="fa fa-calendar"></i>
                <span>Berdiri: <?php echo $data['tahun']; ?></span>
            </div>

            <div class="info-item">
                <i class="fa fa-info-circle"></i>
                <span><?php echo nl2br($data['keterangan']); ?></span>
            </div>

            <!-- STATISTIK -->
            <div class="stats">
                <div class="stat-box">
                    <h5><?php echo $jumlah_siswa; ?></h5>
                    <small>Siswa</small>
                </div>

                <div class="stat-box">
                    <h5><?php echo $jumlah_jurusan; ?></h5>
                    <small>Jurusan</small>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="btn-area">
                <a href="?halaman=sekolah_ubah&kode=<?php echo $data['id_sekolah']; ?>" 
                class="btn btn-warning btn-aksi">
                    <i class="fa fa-edit"></i>
                </a>

                <a href="?halaman=sekolah_aksi&kode=<?php echo $data['id_sekolah']; ?>" 
                onclick="return confirm('Yakin hapus data?')" 
                class="btn btn-danger btn-aksi">
                    <i class="fa fa-trash"></i>
                </a>
            </div>

        </div>

    </div>
</div>

<?php } ?>

</div>
</div>
</div>

<!-- STYLE -->
<style>
.card-sekolah {
    border-radius: 15px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: 0.4s;
    animation: fadeIn 0.6s ease-in-out;
}

.card-sekolah:hover {
    transform: translateY(-8px) scale(1.01);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.header-sekolah {
    background: linear-gradient(135deg, #1e88e5, #00c6ff);
    padding: 20px;
    color: white;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-sekolah {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid white;
}

.body-sekolah {
    padding: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    color: #555;
    font-size: 14px;
}

.info-item i {
    margin-right: 10px;
    color: #1e88e5;
}

.stats {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.stat-box {
    text-align: center;
    background: #f5f7fa;
    padding: 10px;
    border-radius: 10px;
    width: 48%;
}

.stat-box h5 {
    margin: 0;
    color: #1e88e5;
    font-weight: bold;
}

.btn-area {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.btn-aksi {
    border-radius: 10px;
    padding: 6px 12px;
}

/* ANIMASI */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .stats {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
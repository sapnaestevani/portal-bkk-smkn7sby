<?php	
error_reporting(0);
include_once("koneksi.php");
?>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html,
body{
    width:100%;
    overflow-x:hidden;
    background:#f4f6f9;
    font-family:'Segoe UI',sans-serif;
}

/* CONTAINER */
.modern-container{
    width:100%;
    max-width:100%;
    background:white;
    border-radius:20px;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
    margin-top:-5px;
    overflow:hidden;
}

/* HEADER */
.modern-header{
    width:100%;
    background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    color:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.modern-header h3{
    margin:0;
    font-size:clamp(20px,4vw,28px);
    font-weight:700;
    display:flex;
    align-items:center;
    gap:10px;
}

/* BUTTON */
.btn-modern-primary{
    background:white;
    color:#667eea;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    font-weight:600;
    text-decoration:none;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:0.3s ease;
}

.btn-modern-primary:hover{
    transform:translateY(-2px);
    color:#764ba2;
}

/* TABLE WRAPPER */
.table-responsive{
    width:100%;
    overflow-x:auto;
    padding:15px;
}

/* TABLE */
.modern-table{
    width:100%;
    min-width:900px;
    border-collapse:collapse;
}

/* HEADER TABLE */
.modern-table thead{
    background:#eef2ff;
}

.modern-table thead th{
    padding:15px;
    text-align:center;
    font-weight:700;
    color:#1e293b;
    font-size:14px;
    white-space:nowrap;
    border:none;
}

/* BODY TABLE */
.modern-table tbody td{
    padding:14px;
    font-size:14px;
    color:#475569;
    border-bottom:1px solid #e5e7eb;
    vertical-align:middle;
    white-space:nowrap;
}

.modern-table tbody tr:hover{
    background:#f8fafc;
}

/* ACTION BUTTON */
.action-buttons-modern{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:6px;
    flex-wrap:nowrap;
}

.btn-action-modern{
    width:35px;
    height:35px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    text-decoration:none;
    transition:0.3s ease;
    flex-shrink:0;
}

.btn-action-modern:hover{
    transform:translateY(-2px);
    color:white;
}

/* COLORS */
.btn-detail{
    background:#8b5cf6;
}

.btn-edit-modern{
    background:#06b6d4;
}

.btn-delete-modern{
    background:#ef4444;
}

/* DATATABLE */
.dataTables_wrapper{
    width:100%;
}

.dataTables_length,
.dataTables_filter{
    margin-bottom:15px;
}

.dataTables_filter input{
    border:1px solid #d1d5db;
    border-radius:8px;
    padding:8px 12px;
    margin-left:8px;
    width:220px;
    max-width:100%;
}

.dataTables_paginate{
    margin-top:15px !important;
}

.dataTables_paginate .paginate_button{
    border-radius:8px !important;
    border:none !important;
    margin:0 3px;
}

/* MODAL */
.modal-content{
    border:none;
    border-radius:18px;
    overflow:hidden;
}

.modal-header{
    background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    color:white;
    border:none;
}

.modal-title{
    font-weight:700;
}

.modal-body{
    padding:20px;
}

.form-control{
    border-radius:10px;
    height:45px;
    border:1px solid #d1d5db;
    box-shadow:none;
}

.form-control:focus{
    border-color:#667eea;
    box-shadow:0 0 0 0.15rem rgba(102,126,234,.2);
}

/* ================= MOBILE RESPONSIVE ================= */
@media screen and (max-width:768px){

    body{
        overflow-x:hidden !important;
    }

    .modern-container{
    width:100%;
    max-width:100%;
    background:white;
    border-radius:20px;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
    margin-top:18px;
    overflow:hidden;
}

    .modern-header{
        padding:15px !important;
        flex-direction:column !important;
        align-items:stretch !important;
        text-align:center;
    }

    .modern-header h3{
        font-size:20px !important;
        justify-content:center;
    }

    .btn-modern-primary{
        width:100% !important;
        justify-content:center !important;
        font-size:14px !important;
        padding:12px !important;
    }

    .table-responsive{
        width:100% !important;
        overflow-x:auto !important;
        padding:8px !important;
    }

    .modern-table{
        min-width:750px !important;
    }

    .modern-table thead th{
        font-size:12px !important;
        padding:10px !important;
        white-space:nowrap;
    }

    .modern-table tbody td{
        font-size:12px !important;
        padding:10px !important;
        white-space:nowrap;
    }

    .action-buttons-modern{
        flex-direction:row !important;
        flex-wrap:nowrap !important;
        gap:4px !important;
    }

    .btn-action-modern{
        width:30px !important;
        height:30px !important;
        font-size:12px !important;
    }

    .dataTables_wrapper{
        padding:0 !important;
    }

    .dataTables_filter{
        width:100% !important;
        margin-top:10px !important;
        text-align:left !important;
    }

    .dataTables_filter input{
        width:100% !important;
        margin-left:0 !important;
        margin-top:5px !important;
    }

    .dataTables_length{
        margin-bottom:10px !important;
    }

    .paginate_button{
        padding:5px 10px !important;
        font-size:12px !important;
    }

    .modal-dialog{
        width:95% !important;
        margin:20px auto !important;
    }

    .modal-body{
        padding:15px !important;
    }

    .form-group{
        margin-bottom:15px !important;
    }

    .col-lg-3,
    .col-lg-9,
    .col-lg-12{
        width:100% !important;
        max-width:100% !important;
        flex:100% !important;
    }

    .form-control{
        width:100% !important;
    }

}

</style>

<?php
if ($data_status=="admin"){
?>


<div class="modern-container">
    <div class="modern-header">
        <h3><i class="fa fa-users"></i> Peserta</h3>
        <button type="button" class="btn-modern-primary" data-toggle="modal" data-target="#cetak1">
            <i class="fa fa-filter"></i> Filter Data
        </button>
    </div>
    
    <!-- Modal Modern -->
    <div class="modal fade modal-modern" id="cetak1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-filter"></i> Lihat Laporan</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="inputnim" class="col-lg-3 control-label" style="text-align: left;">Asal Sekolah</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="txtasal" id="txtasal">
                                        <option value="">- Pilih Sekolah -</option>
                                        <?php
                                            $sql_asal = mysqli_query($con, "select distinct id_sekolah, nama_sekolah from tb_sekolah") or die(mysqli_error($con));
                                            while($data_asal = mysqli_fetch_array($sql_asal)) {
                                                echo '<option value="'.$data_asal['id_sekolah'].'">'.$data_asal['nama_sekolah'].'</option>';              
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tahun" class="col-lg-3 control-label" style="text-align: left;">Tahun</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="tahun" id="tahun">
                                        <option value="">- Pilih Tahun -</option>
                                        <?php
                                            $thn_skr = date('Y');
                                            for ($x = $thn_skr; $x >= 2017; $x--) {
                                                echo '<option value="'.$x.'">'.$x.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12" style="text-align: right; margin-top: 20px;">
                                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Batal
                                    </button>
                                    <button type="submit" value="Pilih" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Lihat
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="example1" class="modern-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Tahun Lulus</th>
                    <th width="15%">Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $query = $_POST['txtasal'];
                    $tahun = $_POST['tahun'];
                    if($query != ''){
                        $sql_tampil = mysqli_query($con,"select * from tb_siswa, tb_sekolah WHERE tb_siswa.id_sekolah=tb_sekolah.id_sekolah AND tb_sekolah.id_sekolah LIKE'".$query."' AND tb_siswa.tahun_lulus = $tahun ORDER BY tahun_lulus DESC");
                    }else{
                        $sql_tampil = mysqli_query($con,"SELECT * FROM tb_siswa ");		
                    }            
                    while($data = mysqli_fetch_array($sql_tampil)){
                ?>
                <tr>       
                    <td class="text-center"><strong><?= $no; ?></strong></td>
                    <td><strong><?= htmlspecialchars($data['nisn']); ?></strong></td>
                    <td><?= htmlspecialchars($data['nama']); ?></td>
                    <td><?= htmlspecialchars($data['jekel']); ?></td>
                    <td><?= htmlspecialchars($data['jurusan']); ?></td>
                    <td><?= htmlspecialchars($data['tahun_lulus']); ?></td>
                    <td>
                        <div class="action-buttons-modern">
                            <a href="?halaman=siswa_detail&kode=<?php echo $data['nisn']; ?>" class="btn-action-modern btn-detail" title="Detail">
                                <i class="fa fa-link"></i>
                            </a>
                        <!--    <a href="?halaman=siswa_ubah&kode=<?php echo $data['nisn']; ?>" class="btn-action-modern btn-edit-modern" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a> -->
                            <a href="?halaman=siswa_aksi&kode=<?php echo $data['nisn']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" class="btn-action-modern btn-delete-modern" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
} elseif ($data_status=="Ka. BKK"){
?>
<div class="modern-container">
    <div class="modern-header">
        <h3><i class="fa fa-users"></i> Peserta</h3>
        <button type="button" class="btn-modern-primary" data-toggle="modal" data-target="#cetak1">
            <i class="fa fa-filter"></i> Filter Data
        </button>
    </div>
    
    <!-- Modal Modern -->
    <div class="modal fade modal-modern" id="cetak1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-filter"></i> Lihat Peserta</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="tahun" class="col-lg-3 control-label" style="text-align: left;">Tahun</label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="tahun" id="tahun">
                                        <option value="">- Pilih Tahun -</option>
                                        <?php
                                            $thn_skr = date('Y');
                                            for ($x = $thn_skr; $x >= 2017; $x--) {
                                                echo '<option value="'.$x.'">'.$x.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12" style="text-align: right; margin-top: 20px;">
                                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Batal
                                    </button>
                                    <button type="submit" value="Pilih" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Lihat
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="example1" class="modern-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Asal</th>
                    <th>Jurusan</th>
                    <th>Tahun Lulus</th>
                    <th width="15%">Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $tahun = $_POST['tahun'];
                    if($tahun != ''){
                        $sql_tampil = mysqli_query($con,"select * from tb_siswa, tb_sekolah WHERE tb_siswa.id_sekolah=tb_sekolah.id_sekolah AND tb_sekolah.id_sekolah='$data_username' AND tb_siswa.tahun_lulus = $tahun ORDER BY tahun_lulus DESC");
                    }else{
                        $sql_tampil = mysqli_query($con,"SELECT * from tb_siswa, tb_sekolah WHERE tb_siswa.id_sekolah=tb_sekolah.id_sekolah AND tb_sekolah.id_sekolah='$data_username' ORDER BY tahun_lulus DESC");		
                    }            
                    while($data = mysqli_fetch_array($sql_tampil)){
                ?>
                <tr>       
                    <td class="text-center"><strong><?= $no; ?></strong></td>
                    <td><strong><?= htmlspecialchars($data['nisn']); ?></strong></td>
                    <td><?= htmlspecialchars($data['nama']); ?></td>
                    <td><?= htmlspecialchars($data['jekel']); ?></td>
                    <td><?= htmlspecialchars($data['nama_sekolah']); ?></td>
                    <td><?= htmlspecialchars($data['jurusan']); ?></td>
                    <td><?= htmlspecialchars($data['tahun_lulus']); ?></td>
                    <td>
                        <div class="action-buttons-modern">
                            <a href="?halaman=siswa_detail&kode=<?php echo $data['nisn']; ?>" class="btn-action-modern btn-detail" title="Detail">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="?halaman=siswa_ubah&kode=<?php echo $data['nisn']; ?>" class="btn-action-modern btn-edit-modern" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="?halaman=siswa_aksi&kode=<?php echo $data['nisn']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" class="btn-action-modern btn-delete-modern" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
}
?>

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
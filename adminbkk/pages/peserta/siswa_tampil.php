<?php	
error_reporting(0);
include_once("koneksi.php");
?>

<style>
    /* Modern Styling */
    .modern-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin: 5px;
        overflow: hidden;
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
        cursor: pointer;
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
        transform: scale(1.005);
    }
    
    .modern-table tbody td {
        padding: 15px;
        color: #4a5568;
        font-size: 14px;
        border: none;
        vertical-align: middle;
    }
    
    .action-buttons-modern {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .btn-action-modern {
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
    
    .btn-detail {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .btn-edit-modern {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .btn-delete-modern {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    
    .btn-action-modern:hover {
        transform: translateY(-2px) rotate(5deg);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        color: white;
    }
    
    .btn-text {
        width: auto;
        padding: 0 12px;
        font-size: 12px;
    }
    
    /* Modal Modern */
    .modal-modern .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    .modal-modern .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 20px;
    }
    
    .modal-modern .modal-title {
        font-weight: 700;
        font-size: 20px;
    }
    
    .modal-modern .close {
        color: white;
        opacity: 1;
        text-shadow: none;
    }
    
    .modal-modern .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .modal-modern .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .modal-modern .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .dataTables_wrapper {
        padding: 20px;
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
    
    @media (max-width: 768px) {
        .modern-header {
            flex-direction: column;
            text-align: center;
        }
        
        .modern-table {
            font-size: 12px;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 10px 8px;
        }
        
        .action-buttons-modern {
            flex-direction: column;
        }
        
        .btn-action-modern {
            width: 100%;
            margin-bottom: 5px;
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
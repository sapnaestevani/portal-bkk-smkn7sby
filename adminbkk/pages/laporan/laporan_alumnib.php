<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("koneksi.php");

// Sanitasi input untuk mencegah SQL Injection
$tahun = isset($_POST['tahun']) ? mysqli_real_escape_string($con, $_POST['tahun']) : '';
?>

<?php if ($data_status == "admin") { ?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->                        
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak1">
                    <i class="fa fa-book"></i> Lihat Laporan
                </button>
                <br><br>

                <!-- Modal Lihat Laporan -->
                <div class="modal fade" id="cetak1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Lihat Laporan</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="tahun_view" class="col-lg-2 control-label">Tahun Lulus</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="tahun" id="tahun_view">
                                                    <option value="">- Semua -</option>
                                                    <?php
                                                    $thn_skr = date('Y');
                                                    for ($x = $thn_skr; $x >= 2017; $x--) {
                                                        $selected = ($tahun == $x) ? 'selected' : '';
                                                        echo '<option value="' . $x . '" ' . $selected . '>' . $x . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-10 col-lg-offset-2">
                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="filter" class="btn btn-primary">Lihat</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <b>Data Alumni Bekerja</b>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id Alumni</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Instansi</th>
                                        <th>Tahun Lulus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    
                                    // Build query berdasarkan filter
                                    $base_query = "
                                        SELECT 
                                            tb_tracer.id_tracer,
                                            tb_siswa.nisn,
                                            tb_siswa.nama,
                                            tb_tracer.status_setelah_lulus,
                                            tb_tracer.nama_instansi,
                                            tb_siswa.tahun_lulus
                                        FROM tb_tracer
                                        INNER JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
                                        WHERE tb_tracer.status_setelah_lulus = 'Bekerja'
                                    ";
                                    
                                    if (!empty($tahun)) {
                                        $base_query .= " AND tb_siswa.tahun_lulus = '$tahun'";
                                    }
                                    
                                    $base_query .= " ORDER BY tb_tracer.id_tracer DESC";
                                    
                                    $sql_tampil = mysqli_query($con, $base_query);
                                    
                                    if ($sql_tampil && mysqli_num_rows($sql_tampil) > 0) {
                                        while ($data = mysqli_fetch_array($sql_tampil)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($data['id_tracer']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nisn']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($data['status_setelah_lulus']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nama_instansi']); ?></td>
                                        <td><?php echo htmlspecialchars($data['tahun_lulus']); ?></td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center">Tidak ada data alumni bekerja</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } elseif ($data_status == "Ka. BKK") { ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->                        
                <br>
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak">
                    <i class="fa fa-book"></i> Cetak Laporan
                </button>
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak1">
                    <i class="fa fa-book"></i> Lihat Laporan
                </button>
                <br><br>

                <!-- Modal Cetak Laporan -->
                <div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Cetak Laporan</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="?halaman=cetak_kerja" enctype="multipart/form-data" target="_blank">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="tahun_cetak_bkk" class="col-lg-2 control-label">Tahun Lulus</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="tahun" id="tahun_cetak_bkk" required>
                                                    <option value="">- Pilih -</option>
                                                    <?php
                                                    $thn_skr = date('Y');
                                                    for ($x = $thn_skr; $x >= 2017; $x--) {
                                                        echo '<option value="' . $x . '">' . $x . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-10 col-lg-offset-2">
                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="cetak" class="btn btn-primary">Cetak</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <a href="?halaman=cetak_kerja_semua" class="btn btn-primary" target="_blank">
                                    <i class="fa fa-fw fa-print"></i> Cetak Semua
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Lihat Laporan -->
                <div class="modal fade" id="cetak1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Lihat Laporan</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="tahun_view_bkk" class="col-lg-2 control-label">Tahun Lulus</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="tahun" id="tahun_view_bkk">
                                                    <option value="">- Semua -</option>
                                                    <?php
                                                    $thn_skr = date('Y');
                                                    for ($x = $thn_skr; $x >= 2017; $x--) {
                                                        $selected = ($tahun == $x) ? 'selected' : '';
                                                        echo '<option value="' . $x . '" ' . $selected . '>' . $x . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-10 col-lg-offset-2">
                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="filter" class="btn btn-primary">Lihat</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <b>Data Alumni Bekerja</b>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id Alumni</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Instansi</th>
                                        <th>Tahun Lulus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    
                                    // Build query untuk Ka. BKK
                                    $base_query = "
                                        SELECT 
                                            tb_tracer.id_tracer,
                                            tb_siswa.nisn,
                                            tb_siswa.nama,
                                            tb_tracer.status_setelah_lulus,
                                            tb_tracer.nama_instansi,
                                            tb_siswa.tahun_lulus
                                        FROM tb_tracer
                                        INNER JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
                                        WHERE tb_tracer.status_setelah_lulus = 'Bekerja'
                                    ";
                                    
                                    if (!empty($tahun)) {
                                        $base_query .= " AND tb_siswa.tahun_lulus = '$tahun'";
                                    }
                                    
                                    $base_query .= " ORDER BY tb_tracer.id_tracer DESC";
                                    
                                    $sql_tampil = mysqli_query($con, $base_query);
                                    
                                    if ($sql_tampil && mysqli_num_rows($sql_tampil) > 0) {
                                        while ($data = mysqli_fetch_array($sql_tampil)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($data['id_tracer']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nisn']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($data['status_setelah_lulus']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nama_instansi']); ?></td>
                                        <td><?php echo htmlspecialchars($data['tahun_lulus']); ?></td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center">Tidak ada data alumni bekerja</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
<?php
error_reporting(0);
include_once("../../koneksi.php");
?>

<style>

/* =====================================
   RESPONSIVE ALL DEVICE
===================================== */

html,
body{
  overflow-x:hidden !important;
}

/* BUTTON ATAS */
.form-group .btn{
  border-radius:12px !important;
  font-weight:600 !important;
  padding:10px 18px !important;
  margin-bottom:10px !important;
}

/* BOX */
.box{
  border-radius:20px !important;
  overflow:hidden !important;
  box-shadow:0 4px 20px rgba(0,0,0,0.08) !important;
  border:none !important;
}

/* HEADER BOX */
.box-header{
  padding:18px 20px !important;
}

.box-title{
  font-weight:700 !important;
  font-size:20px !important;
}

/* TABLE */
.table{
  margin-bottom:0 !important;
}

.table thead tr{
  background:#667eea !important;
  color:#fff !important;
}

.table thead th{
  border:none !important;
  padding:14px !important;
  text-align:center !important;
  white-space:nowrap;
}

.table tbody td{
  vertical-align:middle !important;
  padding:12px !important;
}

/* BUTTON TABLE */
.table .btn{
  border-radius:10px !important;
  padding:6px 10px !important;
}

/* DATATABLE */
.dataTables_wrapper{
  width:100% !important;
}

.dataTables_filter input{
  border-radius:10px !important;
  padding:8px 12px !important;
}

.dataTables_length select{
  border-radius:10px !important;
}

/* MODAL */
.modal-content{
  border-radius:20px !important;
  overflow:hidden !important;
  border:none !important;
}

.modal-header{
  background:linear-gradient(135deg,#667eea 0%,#764ba2 100%) !important;
  color:#fff !important;
}

.modal-title{
  font-weight:700 !important;
}

.modal-body{
  padding:25px !important;
}

/* FORM */
.form-control{
  border-radius:12px !important;
  height:45px !important;
}

/* =====================================
   TABLET
===================================== */

@media (max-width:991px){

  .box-title{
    font-size:18px !important;
  }

  .table thead th,
  .table tbody td{
    font-size:13px !important;
    padding:10px !important;
  }

}

/* =====================================
   MOBILE
===================================== */

@media (max-width:768px){

  .form-group{
    padding:0 !important;
  }

  /* BUTTON */
  .form-group .btn{
    width:100% !important;
    margin-bottom:10px !important;
    font-size:14px !important;
  }

  /* BOX */
  .box{
    border-radius:18px !important;
  }

  .box-header{
    padding:15px !important;
    text-align:center !important;
  }

  .box-title{
    font-size:18px !important;
    line-height:1.4 !important;
  }

  /* TABLE RESPONSIVE */
  .box-body{
    overflow-x:auto !important;
    padding:10px !important;
  }

  table{
    min-width:700px !important;
  }

  /* DATATABLE */
  .dataTables_wrapper .row{
    margin:0 !important;
  }

  .dataTables_filter,
  .dataTables_length,
  .dataTables_info,
  .dataTables_paginate{
    text-align:center !important;
    width:100% !important;
    margin-bottom:10px !important;
  }

  .dataTables_filter input{
    width:100% !important;
    margin-left:0 !important;
  }

  /* MODAL */
  .modal-dialog{
    width:95% !important;
    margin:20px auto !important;
  }

  .modal-body{
    padding:20px !important;
  }

  /* FORM */
  .form-control{
    font-size:16px !important;
  }

  /* BUTTON TABLE */
  .table .btn{
    display:block !important;
    width:100% !important;
    margin-bottom:5px !important;
  }

}

/* =====================================
   SMALL MOBILE
===================================== */

@media (max-width:480px){

  .box-title{
    font-size:16px !important;
  }

  .table thead th,
  .table tbody td{
    font-size:12px !important;
  }

  .form-group .btn{
    font-size:13px !important;
    padding:10px !important;
  }

}

</style>

<div class="form-group">
    <br>

    <!-- Tombol Cetak Laporan -->
    <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCetak">
        <i class="fa fa-print"></i> Cetak Laporan
    </a>

    <!-- Tombol Filter Tahun -->
    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cetak1">
        <i class="fa fa-calendar"></i> Tahun Lulus
    </a>

    <br>

    <!-- ================= MODAL CETAK ================= -->
    <div class="modal fade" id="modalCetak" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cetak Laporan</h4>
                </div>
                <div class="modal-body">
                    <!-- ✅ Path relatif: asumsi tracer_pdf.php satu folder -->
                    <a href="pages/tracer/tracer_pdf.php?tipe=all_bekerja" target="_blank" class="btn btn-success btn-block">
                        <i class="fa fa-print"></i> Cetak Semua Data
                    </a>
                    <hr>
                    <form action="pages/tracer/tracer_pdf.php" method="GET" target="_blank">
                        <input type="hidden" name="tipe" value="year_bekerja">
                        <label>Pilih Tahun Lulus</label>
                        <select class="form-control" name="tahun" required>
                            <option value="">- Pilih Tahun -</option>
                            <?php
                            // ✅ UBAH: Ambil tahun_lulus dari tb_siswa
                            $sql_tahun2 = mysqli_query($con, "SELECT DISTINCT s.tahun_lulus 
                                FROM tb_tracer t
                                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                                WHERE t.status_setelah_lulus = 'Bekerja'
                                AND s.tahun_lulus IS NOT NULL 
                                ORDER BY s.tahun_lulus DESC");
                            while ($t = mysqli_fetch_array($sql_tahun2)) {
                                echo '<option value="' . $t['tahun_lulus'] . '">' . $t['tahun_lulus'] . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-print"></i> Cetak Berdasarkan Tahun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL FILTER TAHUN ================= -->
    <div class="modal fade" id="cetak1" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Filter Tahun Lulus</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label>Pilih Tahun Lulus</label>
                        <select class="form-control" name="txttahun">
                            <option value="">- Semua Tahun -</option>
                            <?php
                            // ✅ UBAH: Filter berdasarkan tahun_lulus dari tb_siswa
                            $sql_tahun = mysqli_query($con, "SELECT DISTINCT s.tahun_lulus 
                            FROM tb_tracer t
                            INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                            WHERE t.status_setelah_lulus = 'Bekerja'
                            AND s.tahun_lulus IS NOT NULL
                            ORDER BY s.tahun_lulus DESC");
                            while ($data_tahun = mysqli_fetch_array($sql_tahun)) {
                                $selected = (isset($_POST['txttahun']) && $_POST['txttahun'] == $data_tahun['tahun_lulus']) ? 'selected' : '';
                                echo '<option value="' . $data_tahun['tahun_lulus'] . '" ' . $selected . '>' . $data_tahun['tahun_lulus'] . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        <?php if (isset($_POST['txttahun']) && !empty($_POST['txttahun'])): ?>
                            <a href="?halaman=tracerb" class="btn btn-default">Reset</a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <!-- ================= BOX TABEL DATA ================= -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Data Alumni Bekerja</h3>
            <?php if (isset($_POST['txttahun']) && !empty($_POST['txttahun'])): ?>
                <span class="label label-info pull-right">Tahun Lulus: <?php echo htmlspecialchars($_POST['txttahun']); ?></span>
            <?php endif; ?>
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
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Alumni</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Instansi</th>
                        <th>Tahun Lulus</th>
                        <th>Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = isset($_POST['txttahun']) ? mysqli_real_escape_string($con, $_POST['txttahun']) : '';

                    if (!empty($query)) {
                        // ✅ UBAH: Ambil tahun_lulus dari tb_siswa
                        $sql_tampil = mysqli_query($con, "
                            SELECT 
                                t.id_tracer, 
                                s.nama, 
                                t.status_setelah_lulus,
                                t.nama_instansi,
                                s.tahun_lulus 
                            FROM tb_tracer t
                            INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa 
                            WHERE t.status_setelah_lulus = 'Bekerja'
                            AND s.tahun_lulus = '$query'
                            ORDER BY t.id_tracer DESC
                        ");
                    } else {
                        $sql_tampil = mysqli_query($con, "
                            SELECT 
                                t.id_tracer, 
                                s.nama, 
                                t.status_setelah_lulus,
                                t.nama_instansi,
                                s.tahun_lulus 
                            FROM tb_tracer t
                            INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa 
                            WHERE t.status_setelah_lulus = 'Bekerja'
                            ORDER BY t.id_tracer DESC
                        ");
                    }

                    if ($sql_tampil && mysqli_num_rows($sql_tampil) > 0) {
                        while ($data = mysqli_fetch_array($sql_tampil)) {
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo htmlspecialchars($data['id_tracer']); ?></td>
                                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                <td><?php echo htmlspecialchars($data['status_setelah_lulus']); ?></td>
                                <td><?php echo htmlspecialchars($data['nama_instansi'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($data['tahun_lulus']); ?></td>
                                <td>
                                    <a href="?halaman=tracer_detail&kode=<?php echo $data['id_tracer']; ?>"
                                        class='btn btn-warning btn-sm' title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                 <!--   <a href="?halaman=tracer_ubah&kode=<?php echo $data['id_tracer']; ?>"
                                        class='btn btn-warning btn-sm' title="Edit">
                                        <i class="fa fa-edit"></i> -->
                                    </a>
                                    <a href="pages/tracer/tracer_aksi.php?aksi=hapus&kode=<?= $data['id_tracer']; ?>"
                                        onclick="return confirm('Apakah anda yakin hapus data ini ?')"
                                        class='btn btn-danger btn-sm' title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $no++;
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-center text-muted py-4">
                            <i class="fa fa-inbox fa-3x mb-2"></i><br>
                            <strong>Tidak ada data alumni bekerja</strong><br>
                            <small>Silakan tambahkan data tracer study terlebih dahulu.</small>
                          </td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- DataTables Script -->
    <script>
        $(document).ready(function () {
            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            $('#example1').DataTable({
                responsive: true,
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_",
                    info: "_START_ - _END_ dari _TOTAL_",
                    paginate: { next: "›", previous: "‹" },
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Tidak ada data tersedia"
                }
            });
        });
    </script>
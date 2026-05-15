<?php
// Aktifkan error reporting untuk debugging jika diperlukan, matikan untuk production
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);

include_once("koneksi.php");

// Sanitasi Input untuk Keamanan (Mencegah SQL Injection)
$txtasal = isset($_POST['txtasal']) ? mysqli_real_escape_string($con, $_POST['txtasal']) : '';
$tahun = isset($_POST['tahun']) ? mysqli_real_escape_string($con, $_POST['tahun']) : '';
?>

<?php if ($data_status == "admin") { ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
  

                <!-- Tombol Modal -->
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak1">
                    <i class="fa fa-book"></i> Lihat Laporan
                </button>
                <br><br>

                <!-- ================= MODAL LIHAT ================= -->
                <div class="modal fade" id="cetak1" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Lihat Laporan</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post">
                                    <!-- Filter Asal Sekolah Dikomentari/Dihapus karena tb_sekolah tidak lagi digunakan -->
                                    <!-- 
                                    <div class="form-group">
                                        <label>Asal Sekolah</label>
                                        <select class="form-control" name="txtasal">
                                            <option value="">- Pilih -</option>
                                            ...
                                        </select>
                                    </div> 
                                    -->

                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select class="form-control" name="tahun">
                                            <option value="">- Pilih -</option>
                                            <?php
                                            $thn_skr = date('Y');
                                            for ($x = $thn_skr; $x >= 2017; $x--) {
                                                $selected = ($tahun == $x) ? 'selected' : '';
                                                echo "<option value='$x' $selected>$x</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Lihat</button>
                                    <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= TABEL DATA ================= -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <b>Data Alumni Belum Bekerja</b>
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
                                        <th>Asal</th>
                                        <th>Status</th>
                                        <th>Aktivitas</th>
                                        <th>Cara Cari Kerja</th>
                                        <th>Kendala</th>
                                        <th>Luar Kota</th>
                                        <th>Tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;

                                    // Query Dasar
                                    $sql_tampil = mysqli_query($con, "
                                        SELECT 
                                            tb_tracer.id_tracer,
                                            tb_siswa.nisn,
                                            tb_siswa.nama,
                                            '-' AS nama_sekolah,
                                            tb_tracer.status_setelah_lulus,
                                            tb_tracer.aktivitas,
                                            tb_tracer.cara_cari_kerja,
                                            tb_tracer.kendala,
                                            tb_tracer.luar_kota,
                                            tb_siswa.tahun_lulus
                                        FROM tb_tracer
                                        INNER JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
                                        WHERE tb_tracer.status_setelah_lulus = 'Belum Bekerja'
                                        " . (!empty($tahun) ? "AND tb_siswa.tahun_lulus = '$tahun'" : "") . "
                                        ORDER BY tb_tracer.id_tracer DESC
                                    ");

                                    // Tampilkan Data
                                    if ($sql_tampil) {
                                        while ($data = mysqli_fetch_array($sql_tampil)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($data['id_tracer']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nisn']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($data['nama_sekolah']); ?></td>
                                        <td><?php echo htmlspecialchars($data['status_setelah_lulus']); ?></td>
                                        <td><?php echo htmlspecialchars($data['aktivitas']); ?></td>
                                        <td><?php echo htmlspecialchars($data['cara_cari_kerja']); ?></td>
                                        <td><?php echo htmlspecialchars($data['kendala']); ?></td>
                                        <td><?php echo htmlspecialchars($data['luar_kota']); ?></td>
                                        <td><?php echo htmlspecialchars($data['tahun_lulus']); ?></td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        // Opsional: Tampilkan error query jika terjadi masalah koneksi
                                        echo "<tr><td colspan='11'>Gagal memuat data: " . mysqli_error($con) . "</td></tr>";
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
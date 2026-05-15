<?php
error_reporting(0);
include_once("koneksi.php");
?>

<?php
if ($data_status == "admin") {
?>

<div id="page-wrapper">
<div id="page-inner">
<div class="row">
<div class="col-md-12">


<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak1">
<i class="fa fa-book"></i> Lihat Laporan
</button>

<br>

<div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Cetak Laporan</h4>
</div>

<div class="modal-body">

<form class="form-horizontal" method="post" action="./pages/laporan/cetak_alumni_s.php"
enctype="multipart/form-data" target="_blank">

<fieldset>

<div class="input-group">
<input type="text" value="<?php echo $row['id_user']; ?>" name="id_user" id="id_user" hidden>
</div>

<div class="form-group">
<label class="col-lg-2 control-label">Asal Sekolah</label>
<div class="col-lg-10">

<select class="form-control" name="txtasal" id="txtasal">
<option value="">- Pilih -</option>

<?php
$sql_asal = mysqli_query($con, "SELECT DISTINCT id_sekolah, nama_sekolah FROM tb_sekolah");
while ($data_asal = mysqli_fetch_array($sql_asal)) {
echo '<option value="'.$data_asal['id_sekolah'].'">'.$data_asal['nama_sekolah'].'</option>';
}
?>

</select>

<br>

<div class="col-lg-10">
<select class="form-control" name="tahun" id="tahun">
<option value="">- Pilih -</option>
<?php
$thn_skr = date('Y');
for ($x = $thn_skr; $x >= 2017; $x--) {
echo "<option value='$x'>$x</option>";
}
?>
</select>
</div>

</div>
</div>

<div class="form-group">
<div class="col-lg-10 col-lg-offset-2">
<button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" id="cetak" name="cetak" class="btn btn-primary">Cetak</button>

<form method="post">
<div class="modal-footer">
<a href="./pages/laporan/cetak_alumni.php" class="btn btn-primary" target="_blank">
<i class="fa fa-fw fa-print"></i> Cetak Semua
</a>
</div>
</form>

</div>
</div>

</fieldset>
</form>

</div>
</div>
</div>
</div>

<br><br>

<!-- MODAL LIHAT -->
<div class="modal fade" id="cetak1" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Lihat Laporan</h4>
</div>

<div class="modal-body">

<form method="post">

<div class="form-group">
<label>Asal Sekolah</label>
<select class="form-control" name="txtasal">
<option value="">- Pilih -</option>

<?php
$sql_asal = mysqli_query($con, "SELECT DISTINCT id_sekolah,nama_sekolah FROM tb_sekolah");
while ($data_asal = mysqli_fetch_array($sql_asal)) {
echo "<option value='".$data_asal['id_sekolah']."'>".$data_asal['nama_sekolah']."</option>";
}
?>

</select>
</div>

<div class="form-group">
<label>Tahun</label>
<select class="form-control" name="tahun">
<option value="">- Pilih -</option>

<?php
$thn_skr = date('Y');
for ($x=$thn_skr; $x>=2017; $x--){
echo "<option value='$x'>$x</option>";
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

<!-- TABEL -->
<div class="panel panel-info">
<div class="panel-heading">
<b>Data Alumni Studi Lanjut</b>
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
<th>Instansi</th>
<th>Tahun</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;
$query = isset($_POST['txtasal']) ? $_POST['txtasal'] : '';
$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : '';

if ($query != '' && $tahun != '') {

$sql_tampil = mysqli_query($con,"
SELECT 
tb_tracer.id_tracer,
tb_siswa.nisn,
tb_siswa.nama,
tb_sekolah.nama_sekolah,
tb_tracer.status_setelah_lulus,
tb_tracer.nama_instansi,
tb_siswa.tahun_lulus
FROM tb_tracer
JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
LEFT JOIN tb_sekolah ON tb_sekolah.id_sekolah = tb_sekolah.id_sekolah
WHERE tb_tracer.status_setelah_lulus='Studi'
AND tb_siswa.tahun_lulus='$tahun'
ORDER BY tb_tracer.id_tracer ASC
");

} else {

$sql_tampil = mysqli_query($con,"
SELECT 
tb_tracer.id_tracer,
tb_siswa.nisn,
tb_siswa.nama,
tb_sekolah.nama_sekolah,
tb_tracer.status_setelah_lulus,
tb_tracer.nama_instansi,
tb_siswa.tahun_lulus
FROM tb_tracer
JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
LEFT JOIN tb_sekolah ON tb_sekolah.id_sekolah = tb_sekolah.id_sekolah
WHERE tb_tracer.status_setelah_lulus='Studi'
ORDER BY tb_tracer.id_tracer DESC
");

}

while ($data = mysqli_fetch_array($sql_tampil)) {
?>

<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $data['id_tracer']; ?></td>
<td><?php echo $data['nisn']; ?></td>
<td><?php echo $data['nama']; ?></td>
<td><?php echo $data['nama_sekolah']; ?></td>
<td><?php echo $data['status_setelah_lulus']; ?></td>
<td><?php echo $data['nama_instansi']; ?></td>
<td><?php echo $data['tahun_lulus']; ?></td>
</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>
</div>

</div>
</div>
</div>

<?php
} elseif ($data_status == "Ka. BKK") {
?>

<div id="page-wrapper">
<div id="page-inner">
<div class="row">
<div class="col-md-12">

<div class="panel panel-info">
<div class="panel-heading">
<b>Data Alumni Studi Lanjut</b>
</div>

<div class="panel-body">
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover">

<thead>
<tr>
<th>No</th>
<th>Id Alumni</th>
<th>NISN</th>
<th>Nama</th>
<th>Asal</th>
<th>Status</th>
<th>Instansi</th>
<th>Tahun</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;
$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : '';

if ($tahun != '') {

$sql_tampil = mysqli_query($con,"
SELECT 
tb_tracer.id_tracer,
tb_siswa.nisn,
tb_siswa.nama,
tb_sekolah.nama_sekolah,
tb_tracer.status_setelah_lulus,
tb_tracer.nama_instansi,
tb_siswa.tahun_lulus
FROM tb_tracer
JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
LEFT JOIN tb_sekolah ON tb_sekolah.id_sekolah = tb_sekolah.id_sekolah
WHERE tb_tracer.status_setelah_lulus='Studi'
AND tb_siswa.tahun_lulus='$tahun'
ORDER BY tb_tracer.id_tracer ASC
");

} else {

$sql_tampil = mysqli_query($con,"
SELECT 
tb_tracer.id_tracer,
tb_siswa.nisn,
tb_siswa.nama,
tb_sekolah.nama_sekolah,
tb_tracer.status_setelah_lulus,
tb_tracer.nama_instansi,
tb_siswa.tahun_lulus
FROM tb_tracer
JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
LEFT JOIN tb_sekolah ON tb_sekolah.id_sekolah = tb_sekolah.id_sekolah
WHERE tb_tracer.status_setelah_lulus='Studi'
ORDER BY tb_tracer.id_tracer DESC
");

}

while ($data = mysqli_fetch_array($sql_tampil)) {
?>

<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $data['id_tracer']; ?></td>
<td><?php echo $data['nisn']; ?></td>
<td><?php echo $data['nama']; ?></td>
<td><?php echo $data['nama_sekolah']; ?></td>
<td><?php echo $data['status_setelah_lulus']; ?></td>
<td><?php echo $data['nama_instansi']; ?></td>
<td><?php echo $data['tahun_lulus']; ?></td>
</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>
</div>

</div>
</div>
</div>

<?php } ?>
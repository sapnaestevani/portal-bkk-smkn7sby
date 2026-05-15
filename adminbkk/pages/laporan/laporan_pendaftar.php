<?php
error_reporting(0);
include_once("koneksi.php");

/* ================= FILTER ================= */
$jenis  = isset($_POST['jenis_laporan']) ? $_POST['jenis_laporan'] : "";
$filter = isset($_POST['txttahun']) ? $_POST['txttahun'] : "";

$where = "";

if ($jenis == "per_loker" && $filter != "") {
    $where = " AND tb_lowongan.id_lowongan = '$filter'";
}
elseif ($jenis == "per_perusahaan" && $filter != "") {
    $where = " AND tb_perusahaan.id_perusahaan = '$filter'";
}
elseif ($jenis == "per_status" && $filter != "") {
    $where = " AND tb_lamaran.status = '$filter'";
}
?>

<div id="page-wrapper">
<div id="page-inner">
<div class="row">
<div class="col-md-12">


<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak">
<i class="fa fa-book"></i> Cetak Laporan
</button>

<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak1">
<i class="fa fa-book"></i> Lihat Laporan
</button>

<br><br>

<!-- ================= MODAL CETAK ================= -->
<div class="modal fade" id="cetak" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Cetak Laporan</h4>
</div>

<div class="modal-body">
<form class="form-horizontal" method="post" action="./pages/laporan/cetak_pendaftar.php" target="_blank">

<div class="form-group">
<label class="col-lg-3 control-label">Jenis Laporan</label>
<div class="col-lg-9">
<select class="form-control" name="jenis_laporan" id="jenis_laporan" onchange="updateFilter()">
<option value="per_loker">Per Lowongan</option>
<option value="per_perusahaan">Per Perusahaan</option>
<option value="per_status">Per Status</option>
<option value="semua">Semua Data</option>
</select>
</div>
</div>

<div class="form-group" id="filter_group">
<label class="col-lg-3 control-label">Pilih Filter</label>
<div class="col-lg-9">
<select class="form-control" name="txttahun" id="filter_data">
<option value="">- Pilih -</option>
</select>
</div>
</div>

<div class="form-group text-center">
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" name="mode" value="print" class="btn btn-primary">
    <i class="fa fa-print"></i> Cetak
</button>

<button type="submit" name="mode" value="pdf" class="btn btn-danger">
    <i class="fa fa-file-pdf-o"></i> Download PDF
</button>
</div>

</form>
</div>

</div>
</div>
</div>

<!-- ================= MODAL LIHAT ================= -->
<div class="modal fade" id="cetak1" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Lihat Laporan</h4>
</div>

<div class="modal-body">

<form class="form-horizontal" method="post" action="">

<!-- Jenis Laporan -->
<div class="form-group">
<label class="col-lg-3 control-label">Jenis Laporan</label>
<div class="col-lg-9">
<select class="form-control" name="jenis_laporan" id="jenis_laporan_lihat" onchange="updateFilterLihat()">
<option value="per_loker">Per Lowongan</option>
<option value="per_perusahaan">Per Perusahaan</option>
<option value="per_status">Per Status</option>
<option value="semua">Semua Data</option>
</select>
</div>
</div>

<!-- Filter Dinamis -->
<div class="form-group" id="filter_group_lihat">
<label class="col-lg-3 control-label">Pilih Filter</label>
<div class="col-lg-9">
<select class="form-control" name="txttahun" id="filter_data_lihat">
<option value="">- Pilih -</option>
</select>
</div>
</div>

<div class="form-group">
<div class="col-lg-10 col-lg-offset-2">
<button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary">Lihat</button>
</div>
</div>

</form>

</div>
</div>
</div>
</div>

<!-- ================= TABEL ================= -->
<div class="panel panel-info">
<div class="panel-heading">
<b>Data Pendaftar</b>
</div>

<div class="panel-body">
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover" id="dataTables-example">

<thead>
<tr>
<th>No</th>
<th>No. Pendaftaran</th>
<th>NISN</th>
<th>Nama</th>
<th>Lowongan</th>
<th>Perusahaan</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;

$sql_tampil = "
SELECT 
    tb_lamaran.id_lamaran,
    tb_siswa.nisn,
    tb_siswa.nama,
    tb_lowongan.judul_lowongan,
    tb_perusahaan.nama_perusahaan,
    tb_lamaran.status
FROM tb_lamaran
JOIN tb_siswa ON tb_lamaran.id_siswa = tb_siswa.id_siswa
JOIN tb_lowongan ON tb_lamaran.id_lowongan = tb_lowongan.id_lowongan
JOIN tb_perusahaan ON tb_lowongan.id_perusahaan = tb_perusahaan.id_perusahaan
WHERE 1=1
$where
ORDER BY tb_lamaran.id_lamaran DESC
";

$query_tampil = mysqli_query($con, $sql_tampil);

while ($data = mysqli_fetch_array($query_tampil)) {
?>

<tr>
<td><?php echo $no; ?></td>
<td><?php echo $data['id_lamaran']; ?></td>
<td><?php echo $data['nisn']; ?></td>
<td><?php echo $data['nama']; ?></td>
<td><?php echo $data['judul_lowongan']; ?></td>
<td><?php echo $data['nama_perusahaan']; ?></td>
<td><?php echo $data['status']; ?></td>
</tr>

<?php
$no++;
}
?>

</tbody>
</table>

</div>
</div>
</div>

<!-- ================= SCRIPT DROPDOWN ================= -->
<script>
// Data dari PHP untuk filter
var dataLowongan = <?php 
$lowongan_array = array();
$sql = mysqli_query($con,"SELECT tb_lowongan.id_lowongan, tb_lowongan.judul_lowongan, tb_perusahaan.nama_perusahaan 
                           FROM tb_lowongan 
                           JOIN tb_perusahaan ON tb_lowongan.id_perusahaan = tb_perusahaan.id_perusahaan");
while($d = mysqli_fetch_array($sql)){
    $lowongan_array[] = array(
        'id' => $d['id_lowongan'],
        'judul' => $d['judul_lowongan'],
        'perusahaan' => $d['nama_perusahaan']
    );
}
echo json_encode($lowongan_array);
?>;

var dataPerusahaan = <?php 
$perusahaan_array = array();
$sql2 = mysqli_query($con,"SELECT id_perusahaan, nama_perusahaan FROM tb_perusahaan");
while($d2 = mysqli_fetch_array($sql2)){
    $perusahaan_array[] = array(
        'id' => $d2['id_perusahaan'],
        'nama' => $d2['nama_perusahaan']
    );
}
echo json_encode($perusahaan_array);
?>;

function updateFilter() {
    var jenis = document.getElementById("jenis_laporan").value;
    var filter = document.getElementById("filter_data");
    var group = document.getElementById("filter_group");
    
    filter.innerHTML = '<option value="">- Pilih -</option>';
    
    if (jenis === "per_loker") {
        group.style.display = "block";
        dataLowongan.forEach(function(item) {
            filter.innerHTML += '<option value="' + item.id + '">' + item.judul + ' - ' + item.perusahaan + '</option>';
        });
    }
    else if (jenis === "per_perusahaan") {
        group.style.display = "block";
        dataPerusahaan.forEach(function(item) {
            filter.innerHTML += '<option value="' + item.id + '">' + item.nama + '</option>';
        });
    }
    else if (jenis === "per_status") {
        group.style.display = "block";
        filter.innerHTML += '<option value="Diproses">Diproses</option>';
        filter.innerHTML += '<option value="Diterima">Diterima</option>';
        filter.innerHTML += '<option value="Ditolak">Ditolak</option>';
        filter.innerHTML += '<option value="Dibatalkan">Dibatalkan</option>';
        filter.innerHTML += '<option value="Panggilan Wawancara">Panggilan Wawancara</option>';
    }
    else if (jenis === "semua") {
        group.style.display = "none";
        filter.value = "";
    }
}

function updateFilterLihat() {
    var jenis = document.getElementById("jenis_laporan_lihat").value;
    var filter = document.getElementById("filter_data_lihat");
    var group = document.getElementById("filter_group_lihat");
    
    filter.innerHTML = '<option value="">- Pilih -</option>';
    
    if (jenis === "per_loker") {
        group.style.display = "block";
        dataLowongan.forEach(function(item) {
            filter.innerHTML += '<option value="' + item.id + '">' + item.judul + ' - ' + item.perusahaan + '</option>';
        });
    }
    else if (jenis === "per_perusahaan") {
        group.style.display = "block";
        dataPerusahaan.forEach(function(item) {
            filter.innerHTML += '<option value="' + item.id + '">' + item.nama + '</option>';
        });
    }
    else if (jenis === "per_status") {
        group.style.display = "block";
        filter.innerHTML += '<option value="Diproses">Diproses</option>';
        filter.innerHTML += '<option value="Diterima">Diterima</option>';
        filter.innerHTML += '<option value="Ditolak">Ditolak</option>';
        filter.innerHTML += '<option value="Dibatalkan">Dibatalkan</option>';
        filter.innerHTML += '<option value="Panggilan Wawancara">Panggilan Wawancara</option>';
    }
    else if (jenis === "semua") {
        group.style.display = "none";
        filter.value = "";
    }
}

// Initialize on page load
window.onload = function() {
    updateFilter();
    updateFilterLihat();
};
</script>

</div>
</div>
</div>
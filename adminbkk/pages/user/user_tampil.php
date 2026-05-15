<?php	
include_once("koneksi.php");
?>

<div class="form-group">

<br>
<div class="card mb-3">
<div class="card-header">
<a href="?halaman=user_tambah" class="btn btn-primary btn-sm">Tambah User</a> </div>
<br>
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">User Peserta</h3>

  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
  </div>
</div>

<div class="box-body">
<table id="example1" class="table table-bordered table-striped">
<thead>
<center>
<tr>
<th>NO</th>
<th>USERNAME/NISN</th>
<th>NAMA PENGGUNA</th>
<th>STATUS</th>
<th>KET</th>
</tr>
</center>
</thead>

<tbody>

<?php

/* =========================
   QUERY SUDAH BENAR
   ========================= */
$sql_tampil = "
SELECT 
    tb_user.id_user,
    tb_user.username,
    tb_user.role,
    tb_siswa.nama,
    tb_siswa.nisn
FROM tb_user 
LEFT JOIN tb_siswa ON tb_user.id_user = tb_siswa.id_user
";

$query_tampil = mysqli_query($con, $sql_tampil);
$no=1;

while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {

/* =========================
   PENGAMAN DATA
   ========================= */
$username = isset($data['username']) ? $data['username'] : '-';
$nama     = isset($data['nama']) ? $data['nama'] : '-';
$nisn     = isset($data['nisn']) ? $data['nisn'] : '-';
$role     = isset($data['role']) ? $data['role'] : '-';

?>

<tr>       
<td><?php echo $no; ?></td>

<!-- USERNAME / NISN -->
<td>
    <?php 
    if($nisn != '-') {
        echo $nisn; // kalau siswa
    } else {
        echo $username; // kalau admin/perusahaan
    }
    ?>
</td>

<td><?php echo $nama; ?></td>
<td><?php echo $role; ?></td>

<td>
    <a href="?halaman=user_ubah&kode=<?php echo $data['id_user']; ?>" class='btn btn-warning btn-sm'>
        <i class="fa fa-edit"></i>
    </a>
    <a href="?halaman=user_aksi&kode=<?php echo $data['id_user']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" class='btn btn-danger btn-sm'>
        <i class="fa fa-trash"></i>
    </a>
</td>

</tr>

<?php
$no++;
}
?>

</tbody>
</table>
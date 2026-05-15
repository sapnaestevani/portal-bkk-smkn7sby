<?php 
$konek = mysqli_connect("localhost","root","","bkk"); 
?>

<section id="subintro">
        <div class="container">
        <div class="row">
        <div class="span4">
            <h3>Alumni</strong></h3>
        </div>
            <div class="span8">
            <ul class="breadcrumb notop">
                <li><a href="?halaman=beranda">Home</a><span class="divider">/</span></li>
                <li class="active"><a href="?halaman=alumni">Kembali</a></li>
            </ul>
            </div>
        </div>
        </div>
      </div>
    </div>
        </section>

        <section id="maincontent">
        <div class="container">
        <div class="row">
        <div class="col-md-12">

<form action="coba.php" method="get">
	<label>Cari :</label>
	<input type="text" name="cari">
	<input type="submit" value="Cari">
</form>

<?php 
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
    echo "<b>Hasil pencarian : ".$cari."</b>";
    
}
?>

<div class="panel panel-info">
        <div class="panel-heading">
          <br>
       </div>
       <div class="panel-body">
           <div class="table-responsive">
               <table class="table table-striped table-bordered table-hover  id="dataTables-example"">
               <thead>
	<tr>
    <th>No</th>
    <th>ID Alumni</th>
    <th>NISN</th>
    <th>Nama</th>
    <th>Asal Sekolah</th>
    <th>Status</th>
    <th>Tahun Lulus</th>
	</tr>
	<?php 
	if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$data =mysqli_query($konek,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND  nama like '%".$cari."%' ORDER BY id_alumni DESC");				
	}else{
		$data =mysqli_query($konek,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah ORDER BY id_alumni DESC ");		
	}
	$no = 1;
	while($datas = mysqli_fetch_array($data)){
	?>
	<tr>
	<td><?php echo $no; ?></td>
        <td><?php echo $datas['id_alumni']; ?></td>
        <td><?php echo $datas['nisn']; ?></td>
        <td><?php echo $datas['nama']; ?></td>
        <td><?php echo $datas['nama_sekolah']; ?></td>
        <td><?php echo $datas['status']; ?></td>
        <td><?php echo $datas['tahun_lulus']; ?></td>
<td>
    <!-- <a href="alumni_kuliah.php" class='btn btn-warning btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a> -->
    <a href="?halaman=alumni_det&kode=<?php echo $datas['id_alumni']; ?>"><i class="icon-info icon-1x"></i></a>
</td>
	</tr>
    <?php
    $no++;
    }
    ?>
    </center>
    
    
                       </tbody>
                   </table>
                </div>
                </div>
                </section>

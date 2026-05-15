<?php
error_reporting(0);
include_once("koneksi.php");  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>BKK - Bursa Kerja Khusus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Clean responsive bootstrap website template">
  <meta name="author" content="">
  <!-- styles -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="assets/css/docs.css" rel="stylesheet">
  <link href="assets/css/prettyPhoto.css" rel="stylesheet">
  <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="assets/css/prettyPhoto.css" rel="stylesheet">
  <link href="assets/css/flexslider.css" rel="stylesheet">
  <link href="assets/css/refineslide.css" rel="stylesheet">
  <link href="assets/css/font-awesome.css" rel="stylesheet">
  <link href="assets/css/animate.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/color/default.css" rel="stylesheet">

  <!-- fav and touch icons -->
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  <!-- =======================================================
    Theme Name: Plato
    Theme URL: https://bootstrapmade.com/plato-responsive-bootstrap-website-template/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
  <!-- <style>
  .bungkus{ width:500; height:260; border : 1px solid #A9A9A9; border-radius:10px;
padding:10px; } input{ width: 150 px; padding: 12px; border: 1 px solid #ccc;
border-radius: 4 px; box sizing: border-box; resize: vertical; } select{ width: 
200px; padding: 12 px; border:1px solid #cccc; border-radius: 4px; box-sizing:
border-box; resize : vertical;} input:hover{background-color= #87CEEB; font-size
: 12pt; color:white; font-family:calibri;}</style> -->
</head>


<body>
         <section
         <div class="container">
        <div class="row">
            
            <h3>Alumni</strong></h3>
        </div>
        </div>

        </section>
        <section id="maincontent">
        <div class="container">
        <div class="row">
        <div class="col-md-12">
        <br><br>
<!-- <form action="cari.php" method="get"> -->
<form action="cari.php" method="get">
	<label>Cari :</label>
	<input type="text" name="cari">
	<input type="submit" placeholder="Nama Alumni"value="Cari">
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
             </thead>
            
             <?php 
	if(isset($_GET['cari'])){
		$cari = $_GET['cari'];
		$data =mysqli_query($con,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND  nama like '%".$cari."%' ORDER BY id_alumni DESC");				
	}else{
		$data =mysqli_query($con,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah ORDER BY id_alumni DESC ");		
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
    <a href="cari_det.php?kode=<?php echo $datas['id_alumni']; ?>"><i class="icon-info icon-1x"></i></a>
</td>
</tr>
</center>
<?php
$no++;
}
?>

                   </tbody>
               </table>
               <a href="index.php" class="btn btn-default">Kembali</a>
            </div>
            </div>
            </section>
  <!-- Footer
 ================================================== -->
  
</body>

</html>

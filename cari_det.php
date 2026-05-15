<?php

if(isset($_GET['kode'])){
    include_once("koneksi.php");
    $sql = $con->query("SELECT id_alumni, tb_tracer.nisn, tb_peserta.nama, tb_peserta.jekel, tb_peserta.alamat, tb_sekolah.nama_sekolah, tb_peserta.jurusan, tb_peserta.telp, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.id_alumni ='".$_GET['kode']."'");
    $tampil = $sql->fetch_assoc();
}
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
<section id="subintro">
<div class="container">
<div class="row">
    <div class="span4">
    <h3>Alumni</strong></h3>
    </div>
    <div class="span8">
    <ul class="breadcrumb notop">
        <li><a href="index.php">Home</a><span class="divider"></span></li>
        
    </ul>
    </div>
</div>
</div>

</section>
<section id="maincontent">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="panel panel-primary">
                        <div class="panel-heading">
                        <b>Data Alumni Detail : <?php echo $tampil['nama'];?></b>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                <tbody>
                                         <tr>
                                            <td>ID Alumni</td>                                          
                                            <td width="80%">: <?php echo $tampil['id_alumni'];?></td>
                                        </tr>
                                        <tr>
                                            <td>NISN</td>                                          
                                            <td width="80%">: <?php echo $tampil['nisn'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>: <?php echo $tampil['nama'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>: <?php echo $tampil['jekel'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: <?php echo $tampil['alamat'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Asal Sekolah</td>
                                            <td>: <?php echo $tampil['nama_sekolah'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Jurusan</td>
                                            <td>: <?php echo $tampil['jurusan'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Nomor HP</td>
                                            <td>: <?php echo $tampil['telp'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>: <?php echo $tampil['status'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Instansi</td>
                                            <td>: <?php echo $tampil['nama_instansi'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Lulus</td>
                                            <td>: <?php echo $tampil['tahun_lulus'];?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>

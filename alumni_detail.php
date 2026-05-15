<?php
if(isset($_GET['kode'])){
    $konek = mysqli_connect("localhost","root","","bkk"); 
    $sql = $konek->query("SELECT id_alumni, tb_tracer.nisn, tb_peserta.nama, tb_peserta.jekel, tb_peserta.alamat, tb_sekolah.nama_sekolah, tb_peserta.jurusan, tb_peserta.telp, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.id_alumni ='".$_GET['kode']."'");
    $tampil = $sql->fetch_assoc();
}
?>
<section id="subintro">
<div class="container">
<div class="row">
    <div class="span4">
    <h3>Detail Alumni</strong></h3>
    </div>
    <div class="span8">
    <ul class="breadcrumb notop">
        <li><a href="?halaman=beranda">Home</a><span class="divider">/</span></li>
        <li class="active"><a href="?halaman=contact">Contact</a></li>
    </ul>
    </div>
</div>
</div>

</section>
<section id="maincontent">
<div class="container">
  <div class="row">
    <div class="features">
    <div class="panel panel-info">
    <div class="panel-heading">
   </div>
   
                        <b>Data Alumni Detail : <?php echo $tampil['nama'];?></b>
                        </div>
                        <br>
                        <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover  id="dataTables-example"">
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
                                <a href="?halaman=alumnib" class="btn btn-default">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
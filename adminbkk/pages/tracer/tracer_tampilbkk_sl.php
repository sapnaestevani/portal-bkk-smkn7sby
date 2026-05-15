<?php	
error_reporting(0);
include_once("koneksi.php");
    ?>

<h4><span class="glyphicon glyphicon-briefcase"></span>Data Alumni SMK NU Ma'arif Kudus</h4>
<div class="form-group">


<br>
<div class="card mb-3">
<div class="card-header">
<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cetak1"><i class="fa fa-year"></i>
                                  Tahun Lulus
                                </a>		
<br>

<div class="modal fade" id="cetak1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Tahun Lulus</h4>
                          </div>
                          <div class="modal-body">
                            <!--FORM MODAL-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <fieldset>
                                <div class="form-group">
                                  <label for="inputnim" class="col-lg-2 control-label">Tahun Lulus</label>
                                  <div class="col-lg-10">
                                  <select class="form-control" name="txttahun" id="txttahun">
<option value="">- Pilih -</option>
<?php
$tahun=['txttahun'];
$sql_tahun = mysqli_query($con, "Select DISTINCT tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta WHERE tb_tracer.nisn=tb_peserta.nisn ;") or die
(mysqli_error($con));
while($data_tahun = mysqli_fetch_array($sql_tahun)) {
echo '<option value="'.$data_tahun['tahun_lulus'].'">'.$data_tahun['tahun_lulus'].' </option>';              
}?>
</select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <button type="submit" value="Pilih" class="btn btn-primary">Lihat</button>
                                  </div>
                                </div>
											</fieldset>
										</form>
<!--END FORM MODAL-->
                                      </div>
                                      
                                    </div>
                                  </div>
                                </div>
<br>
<div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
    <center>
      <tr>
        <th>No</th>
        <th>Id Alumni</th>
        <th>Nama</th>
        <th>Instansi</th>
        <th>Tahun</th>
        <th>Piihan</th>
    </tr>
    </center>
    </thead>
    <tbody>
         <?php 
            $no = 1;
            $query = $_POST['txttahun'];
            if($query != ''){
            $sql_tampil = mysqli_query($con,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_tracer.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Studi Lanjut' AND tb_sekolah.id_sekolah ='$data_username' AND tahun_lulus LIKE'".$query."' ORDER BY id_alumni DESC");				
            }else{
            $sql_tampil =mysqli_query($con,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_tracer.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Studi Lanjut'AND tb_sekolah.id_sekolah ='".$data_username."'  ORDER BY id_alumni DESC");		
            }
            $query_tampil = mysqli_query($con, $sql_tampil);
            $no=1;
            while($data = mysqli_fetch_array($sql_tampil)){
                
            ?>
       
    
        <tr>       
            <td><?php echo $no; ?></td>
            <td><?php echo $data['id_alumni']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['nama_instansi']; ?></td>
            <td><?php echo $data['tahun_lulus']; ?></td>
            <td>
                <a href="?halaman=tracer_detail&kode=<?php echo $data['id_alumni']; ?>"class='btn btn-warning btn-sm'><i class="fa fa-link"></i></a>
                <a href="?halaman=tracer_ubah&kode=<?php echo $data['id_alumni']; ?>"class='btn btn-warning btn-sm'><i class="fa fa-edit"></i></a>
                <a href="?halaman=tracer_aksi&kode=<?php echo $data['id_alumni']; ?>"  onclick="return confirm('Apakah anda yakin hapus data ini ?')" class='btn btn-danger btn-sm'><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php
            $no++;
            }
        
        ?>
    </tbody>
  </table>
  
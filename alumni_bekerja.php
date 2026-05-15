<?php
error_reporting(0);
include_once("koneksi.php");
?>
<section id="subintro">
        <div class="container">
        <div class="row">
        <div class="span4">
            <h3>Alumni Bekerja</strong></h3>
        </div>
            <div class="span8">
            <ul class="breadcrumb notop">
                <li><a href="?halaman=beranda">Home</a><span class="divider">/</span></li>
                <li class="active"><a href="?halaman=contact">Contact</a></li>
            </ul>
            </div>
        </div>
        
        <div class="modal fade" id="cetak1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <br><br>
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Tahun Lulus</h4>
                          </div>
                          <div class="modal-body">
                            <!-- FORM MODAL-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <fieldset>
                                <div class="form-group">
                                  <label for="inputnim" class="col-lg-2 control-label">Tahun Lulus</label>
                                  <div class="col-lg-10">
                                  <select class="form-control" name="txttahun" id="txttahun">
<option value="">- Pilih -</option>
<?php
$tahun=['txttahun'];
$sql_tahun = mysqli_query($con, "Select DISTINCT tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta WHERE tb_tracer.nisn=tb_peserta.nisn") or die
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
                  </nav>
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
                    
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#cetak1"><i class="fa fa-book"></i>
                      Tahun Lulus
                    </button>		
        <br><br>
        
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
$no = 1;
$query = $_POST['txttahun'];
if($query != ''){
$sql_tampil = mysqli_query($con,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.id_sekolah, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Bekerja' AND tahun_lulus LIKE'".$query."' ORDER BY id_alumni ASC");				
}else{
$sql_tampil =mysqli_query($con,"SELECT DISTINCT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Bekerja' ORDER BY id_alumni DESC");		
}
while($data = mysqli_fetch_array($sql_tampil)){
       
?>
<tr>       
<td><?php echo $no; ?></td>
<td><?php echo $data['id_alumni']; ?></td>
<td><?php echo $data['nisn']; ?></td>
<td><?php echo $data['nama']; ?></td>
<td><?php echo $data['nama_sekolah']; ?></td>
<td><?php echo $data['status']; ?></td>
<td><?php echo $data['tahun_lulus']; ?></td>
<td>
    <!-- <a href="alumni_kuliah.php" class='btn btn-warning btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a> -->
    <a href="?halaman=alumni_det&kode=<?php echo $data['id_alumni']; ?>"><i class="icon-info icon-1x"></i></a>
</td>
</tr>
</center>
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
            
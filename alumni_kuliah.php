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
                <li><a href="index.php">Home</a><span class="divider">/</span></li>
                <li class="active"><a href="contact.php">Contact</a></li>
            </ul>
            </div>
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
        <!-- Advanced Tables -->                        
                   
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
// $id_sekolah = $_POST['txtid_sekolah'];
$query = $_POST['txttahun'];
if($query != ''){
$sql_tampil = mysqli_query($con,"SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.id_sekolah, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Studi' AND tahun_lulus LIKE'".$query."' ORDER BY id_alumni ASC");
}else{
$sql_tampil =mysqli_query($con,"SELECT DISTINCT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Studi' ORDER BY id_alumni DESC");		
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

                   </tbody>
               </table>
            </div>
            </div>
            </section>
  <!-- Footer
 ================================================== -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="span3">
          <div class="widget">
            <!-- logo -->
            <div class="footerlogo">
              <h6><a href="index.php">Alamat</a></h6>
              <!-- <img src="assets/img/logo.png" alt="" /> -->
            </div>
            <!-- end logo -->
            <address>
				<strong>SMK NU Ma’arif 1 Kudus</strong><br>
        Jl. Jepara Prambatan Lor 679<br>
				 Kabupaten Kudus<br>
				 Telp : 0291-434330 </address>
          </div>
        </div>
        <div class="row">
        <div class="span3">
          <div class="widget">
            <!-- logo -->
            <div class="footerlogo">
             <br><br><br>
              <!-- <img src="assets/img/logo.png" alt="" /> -->
            </div>
            <!-- end logo -->
            <address>
				<strong>SMK NU Ma’arif 2 Kudus</strong><br>
        Jl. Siliwangi Gg. 1 No 99 Jekulo<br>
				 Kabupaten Kudus<br>
				 Telp : 0291-430756 </address>
          </div>
        </div>
        <div class="row">
        <div class="span3">
          <div class="widget">
            <!-- logo -->
            <div class="footerlogo">
             <br><br><br>
              <!-- <img src="assets/img/logo.png" alt="" /> -->
            </div>
            <!-- end logo -->
            <address>
				<strong>SMK NU Ma’arif 3 Kudus</strong><br>
        Jl. Golantepus RT. 02 RW. V Mejobo<br>
				 Kabupaten Kudus<br>
				 Phone : 0291-430756 </address>
          </div>
        </div>
        <div class="span3">
          
            <ul class="social-network">
              <!-- <li><a href="https://facebook.com/bawaslukudus/"><i class="icon-bg-light icon-facebook icon-circled icon-1x"></i></a></li> -->
              <!-- <li><a href="kudus.bawaslu.go.id/" title="Linkedin"><i class="icon-bg-light icon-linkedin icon-circled icon-1x"></i></a></li> -->
              <!-- <li><a href="https://instagram.com/bawaslu_kudus/" title="Instagram"><i class="icon-bg-light icon-instagram icon-circled icon-1x" target="_blank"></i></a></li> -->
            </ul>
          </div>
        </div>
      </div>
    </div>
    
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
      </div>
    </div>
  </footer>

  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/modernizr.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/google-code-prettify/prettify.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/jquery.prettyPhoto.js"></script>
  <script src="assets/js/portfolio/jquery.quicksand.js"></script>
  <script src="assets/js/portfolio/setting.js"></script>
  <script src="assets/js/hover/jquery-hover-effect.js"></script>
  <script src="assets/js/jquery.flexslider.js"></script>
  <script src="assets/js/classie.js"></script>
  <script src="assets/js/cbpAnimatedHeader.min.js"></script>
  <script src="assets/js/jquery.refineslide.js"></script>
  <script src="assets/js/jquery.ui.totop.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Custom Javascript File -->
  <script src="assets/js/custom.js"></script>

</body>

</html>

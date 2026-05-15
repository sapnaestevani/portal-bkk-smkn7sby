
<?php	
error_reporting(0);
	$konek = mysqli_connect("localhost","root","","bkk");
    ?>


  <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <center>
                    <tr>
                      <th>No</th>
                      <th>NISN</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Jurusan</th>
                      <th>Tahun Lulus</th>
                      <th>Piihan</th>
                  </tr>
                  </center>
                  </thead>
                  <tbody>
    
                  <?php
                      $sql_tampil = "SELECT * FROM tb_peserta ";
                      $query_tampil = mysqli_query($konek, $sql_tampil);
                      $no=1;
                      while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
                  ?>
                  <tr>       
                      <td><?php echo $no; ?></td>
                      <td><?php echo $data['nisn']; ?></td>
                      <td><?php echo $data['nama']; ?></td>
                      <td><?php echo $data['jekel']; ?></td>
                      <td><?php echo $data['jurusan']; ?></td>
                      <td><?php echo $data['tahun_lulus']; ?></td>
                      <td>
                          <a href="?halaman=siswa_detail&kode=<?php echo $data['nisn']; ?>"class='btn btn-warning btn-sm'><i class="fa fa-link"></i></a>
                          <a href="?halaman=siswa_ubah&kode=<?php echo $data['nisn']; ?>"class='btn btn-warning btn-sm'><i class="fa fa-edit"></i> Edit</a>
                          <a href="?halaman=siswa_aksi&kode=<?php echo $data['nisn']; ?>"  onclick="return confirm('Apakah anda yakin hapus data ini ?')" class='btn btn-danger btn-sm'><i class="fa fa-trash"></i></a>
                      </td>
                  </tr>
                  <?php
                      $no++;
                      }
                  
                  ?>
                  <?php 
                   if(isset($_POST["cari"])){
                   $search = $_POST['keyword'];
          
                   $query = $db->query("SELECT * FROM tb_peserta WHERE nama LIKE '%$search%' ORDER BY id ASC");
                   } else {
                            $query = $db->query("SELECT * FROM tb_peserta ORDER BY id ASC");
                     }
                 $no = 1;
              while($row = mysqli_fetch_assoc($query)) {
                                  ?>
                                  <?php } ?>
              </tbody>
            </table>
            <div id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Tambah Peserta Baru</h4>
                      </div>
                      <div class="modal-body">
                          <form action="?halaman=siswa_tambah" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                  <label>NISN</label>
                                  <input type="text" class="form-control" name="txtnisn" placeholder="Nomor Induk Siswa Nasional" />
                              </div>
                              <div class="form-group">
                                  <label>Nama</label>
                                  <input type="text" class="form-control" name="txtnama_siswa" placeholder="Nama Siswa"
                                  oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                              </div>
                          <div class="form-group">
                              <label>Jenis Kelamin :</label>
                              <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" name="rbjekel" value="Pria"> Pria
                              <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" name="rbjekel" value="Wanita"> Wanita
                          </div>
                          <div class="form-group">
                          <label>Tempat Lahir</label>
                          <input type="text" class="form-control" name="txttempat" placeholder="Tempat Lahir"
                          oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                          </div>
                          <div class="form-group">
                              <label>Tanggal Kelahiran</label>
                              <input type='date' class="form-control" name="txttanggal" />
                          </div>
                                  <div class="form-group">
                                      <label>Nama Orang Tua / Wali</label>
                                      <input type="text" class="form-control" name="txtnama_ortu" placeholder="Nama Orang Tua "
                                      oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                                  </div>
                                  <div class="form-group">
                                          <label>Alamat</label>
                                          <textarea class="form-control" name="txtalamat"
                                          oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                                          </textarea>
                                  </div>
                                  <div class="form-group">
                                      <label>No. Telp</label>
                                      <input type="text" class="form-control" name="txtno_telp" placeholder="Telepon"
                                      oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                                  </div>
                                  <div class="form-group">
                                      <label>Jurusan</label>
                                      <input type="text" class="form-control" name="txtjurusan" placeholder="Telepon"
                                      oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                                  </div>
                              <div class="form-group">
                              <label>Asal Sekolah</label>
                              <select name="txtasal_sek" id="id_sekolah" class="form-control" required>
                              <option value="">- Pilih -</option>
                              <?php
                              $sql_jur = mysqli_query($konek, "select id_sekolah , nama_sekolah from tb_sekolah") or die
                                  (mysqli_error($con));
                                  while($data_jur = mysqli_fetch_array($sql_jur)) {
                                      echo '<option value="'.$data_jur['id_sekolah'].'">'.$data_jur['id_sekolah'].' - '.$data_jur['nama_sekolah'].'</option>';
                                  } ?>
                              </select>
                            </div>
                              <div class="form-group">
                              <label>Tahun Lulus</label><br>
                              <select name="txttahun">
                                  <option value="">Tahun</option>
                                  <?php
                                  $thn_skr = date('Y');
                                  for ($x = $thn_skr; $x >= 2010; $x--) {
                                  ?>
                                      <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                  <?php
                                  }
                                  ?>
                              </select>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary" name="btnSimpan">Simpan</button>
                          </div>
                      </form>
                  </div>

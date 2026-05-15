<?php 
    $konek = mysqli_connect("localhost","root","","bkk");
    ?>
<body OnLoad="document.login.username.focus();" colorbackground="blue">
<body><br><br>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
            <br><br><br>
            
                    <h1><b>REGISTRASI PESERTA</b></h1>
                    <h3><b>SMKN 7 Surabaya</b></h3>
            </div>
        </div>
         <div class="row text-center">
               
         <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
         <div class="panel panel-info">
             <div class="panel-heading">  
             </div>
             <div class="panel-body">
                 <form action="" method="POST" enctype="multipart/form-data">
                        <br />
                      <div class="form-group input-group" <label>NISN  </label>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;
                             <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan NISN" name="txtnisn" required autofocus/>
                         </div>
                     <div class="form-group input-group"<label>Nama Lengkap  </label>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap" name="txtnama_siswa" required="">
                         </div>
                         <div class="form-group input-group" <label>Jenis Kelamin</label>                         
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         
                         <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbjekel" value="Pria"> Pria
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbjekel" value="Wanita"> Wanita 
                        &nbsp;&nbsp;
                         </div>
                         &nbsp;&nbsp;
                         <div class="form-group input-group"<label>Tempat Kelahiran</label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir" name="txttempat" required="">
                         </div>
                         <div class="form-group input-group"<label>Tanggal Kelahiran  </label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="date" class="form-control"  name="txttanggal" required="">
                         </div>
                         <div class="form-group input-group" <label>Nama Orang Tua / Wali  </label>
                         &nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan Nama Orang Tua" name="txtnama_ortu"  required="">
                         </div>
                         <div class="form-group input-group"<label>Alamat  </label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                <input type="text" class="form-control" placeholder="Masukkan Alamat" name="txtalamat"  required="">
                         </div>
                         <div class="form-group input-group" <label>No. Telepon  </label> 
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan No Telp" name="txtno_telp"  required="">
                         </div>
                         <div class="form-group input-group"<label>Jurusan  </label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan Jurusan" name="txtjurusan"  required="">
                         </div>
                         <div class="form-group" <label>Asal Sekolah</label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;
                         <select name="txtid_sekolah" id="id_sekolah" class="form-control" required>
                         <option value="">- Pilih -</option>
                         <?php
                         $sql_jur = mysqli_query($konek, "select id_sekolah, nama_sekolah from tb_sekolah") or die
                             (mysqli_error($con));
                             while($data_jur = mysqli_fetch_array($sql_jur)) {
                                 echo '<option value="'.$data_jur['id_sekolah'].'">'.$data_jur['id_sekolah'].' - '.$data_jur['nama_sekolah'].'</option>';
                             } ?>
                         </select>
                       </div>
                         <div class="form-group input-group" <label>Tahun Lulus  </label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <select name="txttahun">
                                        <option value="">Tahun</option>
                                        <?php
                                        $thn_skr = date('Y');
                                        for ($x = $thn_skr; $x >= 2015; $x--) {
                                        ?>
                                            <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                         </div><br><br>
                         <button type="submit" class="btn btn-warning btn-sm" name="btnDaftarPes" title="Masuk Sistem" />Registrasi</button>
                     <br><br>
                     Bursa Kerja SMK Negeri 7 Surabaya
                     <hr />
                     </form>
             </div>
         </div>
     </div>
                   
                
        </div>
    </div>

     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>


<?php
 $konek = mysqli_connect("localhost","root","","bkk"); 
 if (isset ($_POST['btnDaftarPes'])){
		$sql_simpan = "INSERT INTO tb_peserta (nisn,nama,jekel,tempat_lhr,tgl_lhr,nama_ortu,alamat,telp,jurusan,id_sekolah,tahun_lulus) VALUES (
                    '".$_POST['txtnisn']."',
                    '".$_POST['txtnama_siswa']."',
					'".$_POST['rbjekel']."',
                    '".$_POST['txttempat']."',
                    '".$_POST['txttanggal']."',
                    '".$_POST['txtnama_ortu']."',
                    '".$_POST['txtalamat']."',
                    '".$_POST['txtno_telp']."',
                    '".$_POST['txtjurusan']."',
                    '".$_POST['txtid_sekolah']."',
					'".$_POST['txttahun']."')";
		$query_simpan = mysqli_query($konek,$sql_simpan);

        if ($query_simpan) {
            echo "<script>alert('Tahap Selanjutnya')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?halaman=user_add'>";
        }else{
            echo "<script>alert('Proses Gagal')</script>";
        }
        //selesai proses simpan
    }
?>
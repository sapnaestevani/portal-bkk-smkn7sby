<?php 
    $konek = mysqli_connect("localhost","root","","coba_bkk");
    // KODE OTOMATIS
	// membuat query max untuk kode
	$carikode = mysqli_query($konek,"SELECT MAX(id_alumni) FROM tb_tracer") or die (mysqli_error());
	// menjadikannya array
	$datakode = mysqli_fetch_array($carikode);
	// jika $datakode
	if ($datakode) {
	// membuat variabel baru untuk mengambil kode mulai dari 3
	$nilaikode = substr($datakode[0], 4);
	// menjadikan $nilaikode ( int )
	$kode = (int) $nilaikode;
	// setiap $kode di tambah 1
	$kode = $kode + 1;
	// hasil untuk menambahkan kode 
	// angka 3 untuk menambahkan tiga angka setelah B dan angka 0 angka yang berada di tengah
	// atau angka sebelum $kode
	$hasilkode = "ASM".str_pad($kode, 4, "0", STR_PAD_LEFT);
	}else{
		$hasilkode = "ASM0001";
	}
    // KODE OTOMATIS
    ?>
<body OnLoad="document.login.username.focus();" colorbackground="blue">
<body>
<br><br><br>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
            <br><br><br>
                    <h3><b>Masukkan NISN Sesuai Registrasi<br>
                </b></h3>
                <h5>Pastikan Telah Melakukan Registrasi !!!</h5>
                    <br>
            </div>
        </div>
         <div class="row text-center">
               
         <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
         <div class="panel panel-info">
             <div class="panel-heading">  
             </div>
             <div class="panel-body">
                 <form action="" method="POST" enctype="multipart/form-data">
                        <br/>
                        <div class="form-group input-group" <label>ID Alumni  </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                                <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                <input type="text" class="form-control" name="txtid_alumni" value="<?php echo $hasilkode; ?>" readonly />
                           </div>
                        <div class="form-group input-group" <label>NISN  </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                               <input type="text" class="form-control" placeholder="Masukkan NISN" name="txtnisn" required autofocus/>
                           </div>
                         <div class="form-group" <label>Status :</label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select class="form-control" name="txtstatus" required>  
                            <option value="">-- Pilih --</option>
                            <option>Studi</option>
                            <option>Bekerja</option>
                            </select>
                        </div>
                        <div class="form-group input-group"<label>Nama Instansi  </label>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan Nama Instansi Terkait" name="txtnama_instansi" required="">
                         </div>
                          <div class="form-group input-group" <label>Kapan Anda mulai mencari pekerjaan ?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>                
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbmulai" value="Sebelum"> Sebelum
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbmulai" value="Sesudah"> Sesudah 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbmulai" value="Tidak"> Tidak 
                        &nbsp;&nbsp;
                         </div>
                         &nbsp;&nbsp;
                          <div class="form-group input-group" <label>Apakah anda bekerja saat ini ?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>                
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbekerja" value="Sambilan"> Freelance
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbekerja" value="Wirausaha"> Wirausaha 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbekerja" value="Tidak"> Tidak 
                        &nbsp;&nbsp;
                         </div>
                         &nbsp;&nbsp;
                         <div class="form-group" <label>Mulai bekerja setelah lulus ?</label>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                           
                            <select class="form-control" name="txtbulan" required>  
                            <option value="">-- Jeda Waktu --</option>
                            <option>1 Bulan</option>
                            <option>2 Bulan</option>
                            <option>3 Bulan</option>
                            <option>4 Bulan</option>
                            <option>5 Bulan</option>
                            <option>6 Bulan</option>
                            <option>Lebih 6 Bulan</option>
                            </select>
                        </div>
                         <div class="form-group" <label>Jenis Perusahaan :</label>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select class="form-control" name="txtjnsper" required>  
                            <option value="">-- Pilih --</option>
                            <option>BUMN</option>
                            <option>Nonprofil</option>
                            <option>Swasta</option>
                            <option>Wiraswasta</option>
                            <option>Kuliah</option>
                            </select>
                        </div>
                        <div class="form-group" <label>Gaji Pertama :</label>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select class="form-control" name="txtgaji" required>  
                            <option value="">-- Pilih --</option>
                            <option>< 2.000.000</option>
                            <option>2.000.000 - 4.000.000</option>
                            <option> 4.000.000</option>
                            <option> Kuliah</option>
                            </select>
                        </div>
                          <br><br>
                         <a href="index.php"class='btn btn btn-sm'>Kembali</a>
                         <button type="submit" class="btn btn-warning btn-sm" name="btnTracer" title="Masuk Sistem" />Daftar Tracer</button>
                     <br><br>
                     Bursa Kerja SMK NU Ma'arif Kudus
                     <hr>
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
</html>

<?php
    $konek = mysqli_connect("localhost","root","","coba_bkk"); 
    if (isset ($_POST['btnTracer'])){
        //mulai proses simpan
        $sql_simpan = "INSERT INTO tb_tracer (id_alumni,nisn,status,nama_instansi,mulai,pekerjaan,waktu,jenis_perusahaan,gaji) VALUES (
            '".$_POST['txtid_alumni']."',
            '".$_POST['txtnisn']."',
            '".$_POST['txtstatus']."',
            '".$_POST['txtnama_instansi']."',
            '".$_POST['rbmulai']."',
            '".$_POST['rbekerja']."',
            '".$_POST['txtbulan']."',
            '".$_POST['txtjnsper']."',
            '".$_POST['txtgaji']."')";
            $query_simpan = mysqli_query($konek,$sql_simpan);

        if ($query_simpan) {
            echo "<script>alert('Registrasi Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        }else{
            echo "<script>alert('Registrasi Gagal')</script>";
        }
        //selesai proses simpan
    }
?>
      </aside>
    </div>        
      </form>
    </div>
  </div>
</div>
</section>

<!-- Footer
================================================== -->

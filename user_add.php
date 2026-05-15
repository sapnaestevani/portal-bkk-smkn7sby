<?php 
    $konek = mysqli_connect("localhost","root","","bkk");
    ?>

<body OnLoad="document.login.username.focus();" colorbackground="blue">
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
            <br><br><br>
                    <h3><b>Masukkan NISN & Password Pengguna<BR>
                </b></h3>
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
                        <br />
                      <div class="form-group input-group" <label>NISN  </label>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;
                             <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan NISN Registrasi" name="txtnisn" required autofocus/>
                         </div>
                     <div class="form-group input-group"<label>Password  </label>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                             <input type="text" class="form-control" placeholder="Masukkan Password Pengguna" name="txtpassword" required="">
                         </div>
                          <br><br>
                         <a href="index.php"class='btn btn btn-sm'>Kembali</a>
                         <button type="submit" class="btn btn-warning btn-sm" name="btnDaftaruser" title="Masuk Sistem" />Registrasi</button>
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
</html>

<?php
    $konek = mysqli_connect("localhost","root","","bkk"); 
    if (isset ($_POST['btnDaftaruser'])){
        //mulai proses simpan
        $sql_simpan = "INSERT INTO tb_user (nisn,password,level) VALUES (
            '".$_POST['txtnisn']."',
            '".$_POST['txtpassword']."',
            '".'Peserta'."');";
        $query_simpan = mysqli_multi_query($konek, $sql_simpan);

        if ($query_simpan) {
            echo "<script>alert('Registrasi Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=adminbkk/peserta.php'>";
        }else{
            echo "<script>alert('Registrasi Gagal')</script>";
        }
        //selesai proses simpan
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | BKK SMK NU MA'ARIF 3 KUDUS</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body OnLoad="document.register.username.focus();" colorbackground="blue">
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
            <br><br><br><br><br>
                    <h2><b>REGISTRASI PESERTA <BR>
                BKK SMK NU MA'ARIF KUDUS</b></h2>
                    <br>
            </div>
        </div>
         <div class="row text-center">
               
         <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
         <div class="panel panel-info">
             <div class="panel-heading">

<form action="" method="post" enctype="multipart/form-data">
    <center><h2>Register Peserta</h2></center>
    <div class="panel-body">
                 <form action="" method="POST" enctype="multipart/form-data">

        <div class="form-group input-group">
            <label>NISN :</label>
            <input type="text" class="form-control" placeholder="Masukkan NISN" name="txtnisn" required="">
        </div>
        <div class="form-group input-group">
            <label>Nama Lengkap :</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap" name="txtnama_siswa" required="">
        </div>
        <div class="form-group input-group">
            <label>Jenis Kelamin :</label>
             &nbsp;&nbsp;&nbsp;
            <input type="radio" name="rb_jekel" value="Pria"> Pria
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="rb_jekel" value="Wanita"> Wanita         
        </div>
        <div class="form-group input-group">
            <label>Tempat Kelahiran</label>
            <input class="form-control" name="txttempat"/>
        </div>
        <div class="form-group input-group">
            <label>Tanggal Kelahiran</label>
            <input type='date' class="form-control" name="txttanggal"/>
        </div>
        <div class="form-group input-group">
                            <label>Nama Orang Tua / Wali</label>
                            <input type="text" class="form-control" name="txtnama_ortu" placeholder="Nama Orang Tua "
                            oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                        </div>
                        <div class="form-group input-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="txtalamat"
                                oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                                </textarea>
                        </div>
                        <div class="form-group input-group">
                            <label>No. Telp</label>
                            <input type="text" class="form-control" name="txtno_telp" placeholder="Telepon"
                            oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                        </div>
                <div class="form-group input-group">
                            <label>Jurusan</label>
                            <input type="text" class="form-control" name="txtjurusan" placeholder="Jurusan"
                            oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                        </div>
                <div class="form-group input-group">
                            <label>Asal Sekolah</label>
                            <input type="text" class="form-control" name="txtasal_sek" placeholder="Asal Sekolah"
                            oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required/>
                        </div>
                        <div class="form-group input-group">
                    <label>Tahun Masuk</label><br>
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
            <div class="form-group input-group">
            <button type="submit" class="btn btn-success btn-sm" name="btnDaftar">Register</button>
            <a href="?halaman=pribadi_tampil" class='btn btn-danger btn-sm'>Batal</a>
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
    if (isset ($_POST['btnDaftar'])){
        //mulai proses simpan
        $sql_simpan = "INSERT INTO tb_peserta (nisn,nama,jekel,tempat_lhr,tgl_lhr,nama_ortu,alamat,telp,jurusan,asal_sek,tahun_lulus) VALUES (
            '".$_POST['txtnisn']."',
            '".$_POST['txtnama_siswa']."',
            '".$_POST['rb_jekel']."',
            '".$_POST['txttempat']."',
            '".$_POST['txttanggal']."',
            '".$_POST['txtnama_ortu']."',
            '".$_POST['txtalamat']."',
            '".$_POST['txtno_telp']."',
            '".$_POST['txtjurusan']."',
            '".$_POST['txtasal_sek']."',
            '".$_POST['txttahun']."')";  
        $query_simpan = mysqli_multi_query($konek, $sql_simpan);

        if ($query_simpan) {
            echo "<script>alert('SIMPAN BERHASIL')</script>";
            echo "<meta http-equiv='refresh' content='0; url=user_add.php'>";
        }else{
            echo "<script>alert('SIMPAN GAGAL')</script>";
        }
        //selesai proses simpan
    }
?>
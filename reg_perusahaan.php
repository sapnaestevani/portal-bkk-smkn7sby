<?php
$konek = mysqli_connect("localhost", "root", "", "bkk");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrasi | Perusahaan</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body OnLoad="document.login.username.focus();" colorbackground="blue">

    <body>
        <div class="container">
            <div class="row text-center ">
                <div class="col-md-12">
                    <br><br><br>
                    <h2><b>REGISTRASI PERUSAHAAN </b></h2>
                    <h4><b>SMKN 7 Surabaya </b></h4>
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
                                <div class="form-group input-group" <label>Username </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                    <input type="text" class="form-control" placeholder="Buat Username Anda disini" name="txtusername" required autofocus />
                                </div>
                                <div class="form-group input-group" <label>Perusahaan / CV </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" class="form-control" placeholder="Masukkan Nama Perusahaan" name="txtnama" required="">
                                </div>
                                <!-- <div class="form-group input-group" <label>Jenis Kelamin</label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                         <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbjekel" value="Pria"> Pria
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="radio" name="rbjekel" value="Wanita"> Wanita
                        &nbsp;&nbsp;
                         </div> -->
                                <div class="form-group input-group" <label>Password</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" placeholder="Masukkan Password (Maks. 8)" name="txtpassword" required="">
                                </div>
                                <div class="form-group input-group" <label>Email </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" class="form-control" placeholder="Email Perusahaan" name="txtemail" required="">
                                </div>
                                <div class="form-group input-group" <label>Alamat </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <textarea class="form-control" name="txtalamat" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required />
                                    </textarea>
                                </div>
                                <br><br>
                                <a href="index.php" class='btn btn btn-sm'>Kembali</a>
                                <button type="submit" class="btn btn-warning btn-sm" name="btnDaftarPer" title="Masuk Sistem" />Registrasi</button>
                                <br><br>
                                Bursa Kerja SMK Negeri 7 Surabaya
                                <hr />
                            </form>
                            <br>
                            <center>
                                <p>Repost by <a title='Sapna Estevania' target='_blank'>Sapna Estevania</a></p>
                            </center>

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
$konek = mysqli_connect("localhost", "root", "", "bkk");
if (isset($_POST['btnDaftarPer'])) {
    $sql_simpan = "INSERT INTO user (username,nama,password,email,alamat,level,status) VALUES (
                    '" . $_POST['txtusername'] . "',
                    '" . $_POST['txtnama'] . "',
					'" . $_POST['txtpassword'] . "',
                    '" . $_POST['txtemail'] . "',
                    '" . $_POST['txtalamat'] . "',
                    '" . 'Perusahaan / CV' . "',
                    '" . 'Nonaktif' . "');";
    $query_simpan = mysqli_query($konek, $sql_simpan);

    if ($query_simpan) {
        echo "<script>alert('Tahap Selanjutnya')</script>";
        echo "<meta http-equiv='refresh' content='0; url=login_perusahaan.php'>";
    } else {
        echo "<script>alert('Proses Gagal')</script>";
    }
    //selesai proses simpan
}
?>
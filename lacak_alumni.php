
  <section id="subintro">

    <div class="container">
      <div class="row">
        <div class="span4">
          <h3>Alumni Kami</strong></h3>
        </div>
        <div class="span8">
          <ul class="breadcrumb notop">
            <li><a href="index.php">Home</a><span class="divider">/</span></li>
            <li class="active"><a href="contact.php">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>

  </section>
  <section id="maincontent">
    <div class="container">
      <div class="row">
        <div>
          <aside>
          <center>
          <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label>NISN :</label>
                  <input type="text" class="form-control" name="txtnisn" required="">
              </div>
              
              <div class="form-group">                        
                  <button type="submit" class="btn btn-primary btn-sm" name="btnCek">CEK PROGRES</button>
              </div>
              </center>
          </form>
      </div>
          </aside>
        </div>        
          </form>
        </div>
      </div>
    </div>
  </section>
  
 
<?php
    $konek = mysqli_connect("localhost","root","","bkk"); 

    if (isset($_POST['btnCek'])) {
        $sql_login = "SELECT tb_peserta.nisn, tb_tracer.id_alumni, tb_peserta.nama, tb_sekolah.nama_sekolah, jekel, tahun_lulus FROM tb_peserta, tb_sekolah, tb_tracer WHERE tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.nisn ='".$_POST['txtnisn']."'";
        $query_login = mysqli_query($konek, $sql_login);
        $data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
        $jumlah_login = mysqli_num_rows($query_login);
        
        if ($jumlah_login >=1 ){
            // session_start();
            $_SESSION["ses_nis"]=$data_login["nisn"];
            $_SESSION["ses_id"]=$data_login["id_alumni"];
            $_SESSION["ses_nama"]=$data_login["nama"];
            $_SESSION["ses_jekel"]=$data_login["jekel"];
            $_SESSION["ses_sekolah"]=$data_login["nama_sekolah"];
            $_SESSION["ses_tahun"]=$data_login["tahun_lulus"];
            
            echo "<script>alert('Alumni ditemukan')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?halaman=lacak'>";
        }else{
            echo "<script>alert('Alumni tidak ditemukan')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?halaman=alumni'>";
        }
    }
?>
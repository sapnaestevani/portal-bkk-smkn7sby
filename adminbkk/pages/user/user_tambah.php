<?php 
     include_once("koneksi.php");
    ?>
<div id="page-wrapper" >
<div id="page-inner">
<div class="row">
  <div class="col-md-12">
      <div class="panel panel-primary">
      <div class="panel-heading">
      <form action="?halaman=user_aksi" method="post" enctype="multipart/form-data">
      <b>Data User Peserta</b>
      </div>
    <form action="?halaman=user_aksi" method="post" enctype="multipart/form-data">
    <center><h2>TAMBAH USER</h2></center>

    <div class="form-group">
    <label>NISN Peserta</label>
    <select name="txtnisn" id="nisn" class="form-control" required>
    <option value="">- Pilih -</option>
    <?php
    $sql_nip = mysqli_query($con, "select nisn, nama from tb_peserta") or die
        (mysqli_error($con));
        while($data_nip = mysqli_fetch_array($sql_nip)) {
            echo '<option value="'.$data_nip['nisn'].'">'.$data_nip['nisn'].' - '.$data_nip['nama'].'</option>';
        } ?>
    </select>
    </div>

        <div class="form-group">
            <label>PASSWORD :</label>
            <input type="text" class="form-control" placeholder="Masukkan Password" name="txtpassword" required="">
        </div>
       <div class="form-group">
            <button type="submit" class="btn btn-success btn-sm" name="btnSIMPAN">SIMPAN</button>
            <a href="?halaman=user_tampil" class='btn btn-dark btn-sm'>BATAL</a>
        </div>
        
</form>

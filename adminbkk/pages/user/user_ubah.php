<div id="page-wrapper" >
<div id="page-inner">
<?php
    if(isset($_GET['kode'])){
        $sql_cek = "SELECT * FROM tb_user WHERE nisn='".$_GET['kode']."'";
        $query_cek = mysqli_query($con, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }
?>

<form action="?halaman=user_aksi" method="post" enctype="multipart/form-data">
    <center><h4>UBAH DATA USER PEGAWAI</h4></center>

<div class="form-group">
    <label>NIP :</label>
    <input type="text" class="form-control" placeholder="Masukkan NISN / Username" name="txtnisn" value="<?php echo $data_cek['nisn']; ?>" required="" readonly="">
</div>

<div class="form-group">
    <label>PASSWORD :</label>
    <input type="text" class="form-control" placeholder="Masukkan Password User" name="txtpassword" value="<?php echo $data_cek['password']; ?>" required="">
</div>

<label>LEVEL PENGGUNA :</label>
         <select name="rblevel" class="form-control" value="<?php echo $data_cek['level']; ?>" required="">
            <option>Peserta</option>
           <option>Admin</option>
        </select>

<div class="form-group">
    <button type="submit" class="btn btn-warning btn-sm" name="btnUBAH">UBAH</button>
    <a href="?halaman=user_tampil" class='btn btn-dark btn-sm'>BATAL</a>
</div>

</form>
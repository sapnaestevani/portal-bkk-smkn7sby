<?php
 include_once("koneksi.php");
    if(isset($_GET['kode'])){
        $sql_cek = "SELECT * FROM tb_sekolah WHERE id_sekolah='".$_GET['kode']."'";
        $query_cek = mysqli_query($con, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }
?>

<form action="?halaman=sekolah_aksi" method="post" enctype="multipart/form-data">
    <center><h2>Ubah Data Lowongan</h2></center>

        <div class="form-group">
            <label>Id Sekolah :</label>
            <input type="text" class="form-control"  name="txtidsekolah" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"
            value="<?php echo $data_cek['id_sekolah']; ?>" required="" readonly="">
        </div>

        <div class="form-group">
            <label>Nama Sekolah :</label>
            <input type="text" class="form-control"  name="txtnama_sekolah" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"
            value="<?php echo $data_cek['nama_sekolah']; ?>"  required="">
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="text" class="form-control" name="txtemail" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"
            value="<?php echo $data_cek['email']; ?>"  required="">
        </div>

        <div class="form-group">
            <label>Keterangan :</label>
            <input type="text" class="form-control" name="txtketerangan" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"
            value="<?php echo $data_cek['keterangan']; ?>" required="">
        </div>
        <div class="form-group">
                    <label>Tahun :</label><br>
                    <select name="txttahun">
                        <option value="">Tahun Berdiri</option>
                        <?php
                        $thn_skr = date('Y');
                        for ($x = $thn_skr; $x >= 2000; $x--) {
                        ?>
                            
                            <option value="<?php echo $x ?>"><?php echo $x ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-sm" name="btnUBAH">UBAH</button>
            <a href="?halaman=sekolah_tampil" class='btn btn-dark btn-sm'>BATAL</a>
        </div>
        
</form>
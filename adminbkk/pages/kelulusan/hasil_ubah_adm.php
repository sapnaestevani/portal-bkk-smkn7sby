<?php
$konek = mysqli_connect("localhost","root","","bkk");
    if(isset($_GET['kode'])){
        $sql_cek = "SELECT * FROM tb_kelulusan WHERE kode_hasil='".$_GET['kode']."'";
        $query_cek = mysqli_query($konek, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }
?>

<form action="?halaman=hasil_aksi" method="post" enctype="multipart/form-data">
    <center><h2>Ubah Data Hasil</h2></center>

        <div class="form-group">
            <label>Kode :</label>
            <input type="text" class="form-control"  name="txtkode_hasil" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"
            value="<?php echo $data_cek['kode_hasil']; ?>" required="" readonly="">
        </div>
        <div class="form-group">
                    <label>Lowongan</label>
                            <select name="txtloker" id="id_loker" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php
                            $sql_jur = mysqli_query($konek, "select id_loker , nm_loker from tb_loker where nm_perusahaan ='$data_nama'") or die
                                (mysqli_error($con));
                                while($data_jur = mysqli_fetch_array($sql_jur)) {
                                    echo '<option value="'.$data_jur['id_loker'].'">'.$data_jur['id_loker'].' - '.$data_jur['nm_loker'].'</option>';
                                } ?>
                            </select>
        </div>
        <div class="form-group">
            <form action="hasil_ubah.php" method="post" enctype="multipart/form-data">
                Pilih Berkas: <input type="file" name="berkas" />
                <input type="submit" name="btnUbah" value="Upload" />
            </form>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-sm" name="btnUBAH">UBAH</button>
            <a href="?halaman=loker_tampil" class='btn btn-dark btn-sm'>BATAL</a>
        </div>
        <form action="?halaman=hasil_arsip" method="post" enctype="multipart/form-data">
        
        </form>
</form>
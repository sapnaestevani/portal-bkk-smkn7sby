<div id="page-wrapper" >
            <div id="page-inner">
<form action="?halaman=jurusan_aksi" method="post" enctype="multipart/form-data">
    <center><h2>TAMBAH DATA JURUSAN</h2></center>

        <div class="form-group">
            <label>Kode Jurusan :</label>
            <input type="text" class="form-control" placeholder="Masukkan Kode Jurusan" name="txtkode_jur" required="">
        </div>

        <div class="form-group">
            <label>Nama Jurusan :</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama Jurusan" name="txtnmjurusan" required="">
        </div>

        <div class="form-group">
            <label>Tahun :</label>
            <input type="text" class="form-control" placeholder="Masukkan Tahun Peresmian" name="txttahun" required="">
        </div>
        <div class="form-group">
            <label>Keterangan :</label>
            <input type="text" class="form-control" placeholder="Masukkan Keterangan" name="txtketerangan" required="">
        </div>
                      <div class="form-group">
            <button type="submit" class="btn btn-success btn-sm" name="btnSIMPAN">SIMPAN</button>
            <a href="?halaman=jurusan_tampil" class='btn btn-dark btn-sm'>BATAL</a>
        </div>
        
</form>
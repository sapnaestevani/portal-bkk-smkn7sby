  <section id="subintro">

    <div class="container">
      <div class="row">
        <div class="span4">
          <h3>Info<strong> Hasil Tes Seleksi</strong></h3>
        </div>
        <div class="span8">
          <ul class="breadcrumb notop">
            <li><a href="?halaman=beranda">Home</a><span class="divider">/</span></li>
            <li class="active">Contact</li>
          </ul>
        </div>
      </div>
    </div>

  </section>
  <section id="maincontent">
    <div class="container">
      <div class="row">
        <div class="features">
  <div class="card mb-3">
<div class="card-header">
  <div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        
    <thead>
      <tr>
      <th>No</th>
      <th>Kode</th>
      <th>Nama Perusahaan</th>
      <th>Lowongan</th>
      <th>File Pengumuman</th>
      <th>Opsi</th>
      </tr>
    </thead>
    <tbody>
        
   
        <?php
           include_once("koneksi.php");
            $sql_tampil = "SELECT tb_kelulusan.kode_hasil, tb_loker.nm_perusahaan, tb_loker.nm_loker, berkas,tb_kelulusan.keterangan FROM tb_kelulusan, tb_loker WHERE tb_kelulusan.id_loker=tb_loker.id_loker AND tb_kelulusan.keterangan = 'Tampil' ORDER BY kode_hasil DESC";
            $query_tampil = mysqli_query($con, $sql_tampil);
            $no=1;
            while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
                
        ?>
        <tr>       
            <td><?php echo $no; ?></td>
            <td><?php echo $data['kode_hasil']; ?></td>
            <td><?php echo $data['nm_perusahaan']; ?></td>
            <td><?php echo $data['nm_loker']; ?></td>
            <td><?php echo $data['berkas']; ?></td>
            <td>
                <a href="download.php?filename=<?=$data['berkas'];?>"><i class="icon-download icon-2x"></i></a>	
            </td>
        </tr>
        <?php
            $no++;
            }
        
        ?>
    </tbody>
  </table>
        </section>
  

  <section id="subintro">

    <div class="container">
      <div class="row">
        <div class="span4">
          <h3>Data<strong> Lowongan Kerja</strong></h3>
        </div>
        <div class="span8">
          <ul class="breadcrumb notop">
            <li><a href="#">Home</a><span class="divider">/</span></li>
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
        <th>Kode Lowongan</th>
        <th>Perusahaan</th>
        <th>Lowongan</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
        
   
        <?php
        	include_once("koneksi.php");
            $sql_tampil = "SELECT * FROM tb_loker WHERE status ='Tampil'";
            $query_tampil = mysqli_query($con, $sql_tampil);
            $no=1;
            while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
                
        ?>
        <tr>       
            <td><?php echo $no; ?></td>
            <td><?php echo $data['id_loker']; ?></td>
            <td><?php echo $data['nm_perusahaan']; ?></td>
            <td><?php echo $data['nm_loker']; ?></td>
            <td><?php echo $data['keterangan']; ?></td>
            
        </tr>
        <?php
            $no++;
            }
        
        ?>
    </tbody>
  </table>
        </section>

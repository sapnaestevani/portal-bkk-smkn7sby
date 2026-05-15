<!DOCTYPE html>
<?php	
error_reporting(0);
	$konek = mysqli_connect("localhost","root","","bkk");
    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <center>
                    <tr>
                      <th>No</th>
                      <th>NISN</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Jurusan</th>
                      <th>Tahun Lulus</th>
                      <th>Piihan</th>
                  </tr>
                  </center>
                  <tbody>
    
        <?php
            $sql_tampil = "SELECT * FROM tb_peserta ";
            $query_tampil = mysqli_query($konek, $sql_tampil);
            $no=1;
            while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
        ?>
        <tr>       
            <td><?php echo $no; ?></td>
            <td><?php echo $data['nisn']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['jekel']; ?></td>
            <td><?php echo $data['jurusan']; ?></td>
            <td><?php echo $data['tahun_lulus']; ?></td>
            <td>
                <a href="?halaman=siswa_detail&kode=<?php echo $data['nisn']; ?>"class='btn btn-warning btn-sm'><i class="fa fa-link"></i></a>
                <a href="?halaman=siswa_ubah&kode=<?php echo $data['nisn']; ?>"class='btn btn-warning btn-sm'><i class="fa fa-edit"></i> Edit</a>
                <a href="?halaman=siswa_aksi&kode=<?php echo $data['nisn']; ?>"  onclick="return confirm('Apakah anda yakin hapus data ini ?')" class='btn btn-danger btn-sm'><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php
            $no++;
            }
        
        ?>
    </tbody>
  </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<!-- ./wrapper -->


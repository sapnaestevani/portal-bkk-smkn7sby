<div id="page-wrapper" >
<div id="page-inner">
<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                   <br>
                   <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal"><i class="fa fa-book"></i>
                                  Cetak Laporan
                                </button>
                    <br><br>
                    <div class="panel panel-info">
                    <div class="panel-heading">
                      <b>Data Nominative</b>
                      </div>
    <div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cetak Laporan Loker</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
                <form action="pages/laporan/cetak_loker.php" method="post" enctype="multipart/form-data" target="_blank">
					<div class="form-group">
						<label>Tanggal Awal</label>
                        <input type="date" class="form-control" name="tgl1" required/>
                    </div>
					<div class="form-group">
						<label>Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tgl2" required/>
                    </div>
                        <button type="submit" class="btn btn-primary" name="btnCetak" target="_blank">Cetak</button>
                    </div>
                </form>
                <form action="pages/laporan/cetak_loker.php" method="post" enctype="multipart/form-data" target="_blank">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="btnCetakSemua">Cetak semua</button>
                    </div>
                </form>
        </div>
    </div>     
</div> 
                   <div class="panel-body">
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered table-hover  id="dataTables-example"">
                           <thead>
      <tr>
        <th>No</th>
        <th>Kode Lowongan</th>
        <th>Perusahaan</th>
        <th>Lowongan</th>
        <th>Jenis Kelamin</th>
        <th>Keterangan</th>
        <th>Tanggal</th>
        <th>Batas</th>
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
            <td><?php echo $data['jekel']; ?></td>
            <td><?php echo $data['keterangan']; ?></td>
            <td><?php echo $data['tanggal']; ?></td>
            <td><?php echo $data['batas']; ?></td>
            
        </tr>
        </center>
        <?php
            $no++;
            }
        ?>

                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>

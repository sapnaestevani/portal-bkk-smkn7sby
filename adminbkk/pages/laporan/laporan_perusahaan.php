<div id="page-wrapper" >
<div id="page-inner">
<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                   <br>
                    <a href="./pages/laporan/cetak_perusahaan.php" class="btn btn-default"target="_blank"><i class="fa fa-fw fa-print"></i> Print</a>
                    <br><br>
                    <div class="panel panel-info">
                    <div class="panel-heading">
                      <b>Data Nominative</b>
                      </div>
                   <div class="panel-body">
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered table-hover  id="dataTables-example"" align="center">
                           <thead>
                           <tr>
                             <th>No</th>
                             <th>Id Perusahaan</th>
                             <th>Nama Perusahaan</th>
                             <th>Email</th>
                             <th>Alamat</th>
                             <th>Jumlah Loker</th>                            
                             </tr>
                         </thead>
                         
        <?php
         include_once("koneksi.php");
            $sql_tampil = "SELECT DISTINCT user.username, user.nama, user.email, user.alamat, (SELECT COUNT(nm_perusahaan) FROM tb_loker WHERE sumber=nama) FROM user, tb_loker where level='Perusahaan / CV' AND user.nama=tb_loker.sumber ";
            $query_tampil = mysqli_query($con, $sql_tampil);
            $no=1;
            while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
        ?>
        <tr>       
            <td><?php echo $no; ?></td>
            <td><?php echo $data['username']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['email']; ?></td>
            <td><?php echo $data['alamat']; ?></td>
            <td><?php echo $data['(SELECT COUNT(nm_perusahaan) FROM tb_loker WHERE sumber=nama)']; ?></td>
            
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

<?php
  $konek = mysqli_connect("localhost","root","","bkk");     
    ?>
    
<section id="subintro">
        <div class="container">
        <div class="row">
        <div class="span4">
            <h3>Halaman Pengecekkan Alumni</strong></h3>
        </div>
            <div class="span8">
            <ul class="breadcrumb notop">
                <li><a href="index.php">Home</a><span class="divider">/</span></li>
                <li class="active"><a href="contact.php">Contact</a></li>
            </ul>
            </div>
        </div>
        </div>

        </section>
        <section id="maincontent">
        <div class="container">
        <div class="row">
        <div class="col-md-12">
        
                    
        <br><br>
        <div class="panel panel-info">
        <div class="panel-heading">
          <br>
       </div>
       <div class="panel-body">
           <div class="table-responsive">
               <table class="table table-striped table-bordered table-hover  id="dataTables-example"">
               <thead>
               <tr>
                <th>No</th>
                <th>ID Alumni</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Asal Sekolah</th>
                <th>Tahun Lulus</th>
             </tr>
             </thead>
            

<tr>       
                <td><?php echo $no; ?></td>
                <td><?php echo $id_alumni; ?></td>
                <td><?php echo $nisn; ?></td>
                <td><?php echo $nama; ?></td>
                <td><?php echo $sekolah; ?></td>
                <td><?php echo $tahun; ?></td>
                <td>
                    <a href="?halaman=alumni_det&kode=<?php echo $nisn; ?>" class="btn btn-info btn-sm" title="Detail">
                   
                        Detail
                    </a>
                </td>
</tr>
</center>
                  </tbody>
               </table>
            </div>
            </div>
            </section>
 
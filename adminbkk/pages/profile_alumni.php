<?php
    $konek = mysqli_connect("localhost","root","","sistembkk");   
    $sql2 = $konek->query("SELECT * FROM user WHERE username='$data_username'");
    $tampil = $sql2->fetch_assoc();
    
?>
<br>
<div class="card mb-3">
<div class="card-header">
  <i class="fa fa-table"></i> <b>Profil Saya  : <?php echo $tampil['nama'];?></b> </div>
<div class="card-body">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                <tbody>
                                        <tr>
                                            <td>Username</td>                                          
                                            <td width="80%">: <?php echo $tampil['username'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>                                          
                                            <td width="80%">: <?php echo $tampil['email'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: <?php echo $tampil['alamat'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>: <?php echo $tampil['status'];?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <a href="?halaman=beranda" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>





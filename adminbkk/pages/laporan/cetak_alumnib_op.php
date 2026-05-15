    <?php 
      include_once("../../koneksi.php");
        $sql_asal = mysqli_query($con, "select distinct id_sekolah, nama_sekolah from tb_sekolah");
      
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Data Alumni Bekerja</title>

    <!-- Bootstrap core CSS -->
    <link href="css/sb-admin.min.css" rel="stylesheet">
</head>

<body style=color:black;>

<table border="0" cellspacing="0" cellpadding="0">
    <thead>

    </thead>
    <tbody>
        <tr>       
            <td style=width:150px;>
				<center>
				<img src="img/maarif.jpg" width="110" height="110">
				</center>
			</td>
            <td style=width:1066px;>
                <center>
				BURSA KERJA KHUSUS<br>
				<b>YAYASAN SMK MA'ARIF KUDUS</b><br>
				Desa Prambatan Lor No.679, Pereng, Prambatan Lor, Kec. Kaliwungu <br> Kabupaten Kudus, Jawa Tengah 59361<br>
                Email : smknumaarifkudus@yahoo.com <br>
                <!-- Website : kecamatangembong.patikab.go.id<br> -->
                </center>
            </td>
			<td style=width:150px;>
            <center>
				<img src="img/iso.jpg" width="130" height="110">
				</center>
			</td>
        </tr>
    </tbody>
</table>

<hr>
<br>
<center>
<h3>Laporan Data Alumni Bekerja</h3>
</center>
<table class="table table-bordered" >
		<thead>
			<tr>
                <th>No</th>
                <th>Id Alumni</th>
                <th>NISN</th>
                <th>Asal</th>
                <th>Status</th>
                <th>Instansi</th>
                <th>Tahun</th>
			</tr>
		</thead>
	<tbody>
    <?php
         $no = 1;
         $query = $_POST['txtasal'];
         $tahun = $_POST['tahun'];
         $sql_tampil =  "SELECT tb_tracer.id_alumni, tb_peserta.nisn, tb_peserta.nama, tb_sekolah.id_sekolah, tb_sekolah.nama_sekolah, status, nama_instansi, tb_peserta.tahun_lulus FROM tb_tracer, tb_peserta, tb_sekolah WHERE tb_tracer.nisn=tb_peserta.nisn AND tb_peserta.id_sekolah=tb_sekolah.id_sekolah AND tb_tracer.status='Bekerja' AND tb_sekolah.id_sekolah LIKE'" . $query . "' AND tb_peserta.tahun_lulus = $tahun ORDER BY id_alumni ASC";
         $query_tampil = mysqli_query($con, $sql_tampil);
         while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
        ?>
        <tr>       
            <td><?php echo $no; ?></td>
            <td><?php echo $data['id_alumni']; ?></td>
            <td><?php echo $data['nisn']; ?></td>
            <td><?php echo $data['nama_sekolah']; ?></td>
            <td><?php echo $data['status']; ?></td>
            <td><?php echo $data['nama_instansi']; ?></td>
            <td><?php echo $data['tahun_lulus']; ?></td>
        </tr>
        </center>
        <?php
            $no++;
            }
           
        ?> 

		</tbody>
	</table>

<br>
<table border="0" cellspacing="0" cellpadding="0">
    <thead>

    </thead>
    <tbody>
        <tr>       
            <td style=width:1040px;></td>
            <td style=width:330px;>
                <div style=text-align:center;><b>Kudus, <?php echo date("d-m-Y"); ?></b><br></div>
                <br>
                <center>KEPALA BKK SMK
                <br><br><br><br>
                <u><b>Arif Syaifudin, ST</b></u><br>
                Pembina Tingkat I<br>
                NIP : 0123456789
                </center>
            </td>
        </tr>
    </tbody>
</table>
</center>
<script>
    window.print();
</script>

</body>
</html>


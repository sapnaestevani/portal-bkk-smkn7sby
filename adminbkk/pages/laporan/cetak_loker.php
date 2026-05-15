<?php 
    include_once("../../koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Data Lowongan Kerja</title>

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
<h3>Laporan Data Perusahaan</h3>
</center>
<table class="table table-striped table-bordered" style=color:black; >
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
if(isset($_POST["btnCetak"])){
        $dt1 = $_POST["tgl1"];
        $dt2 = $_POST["tgl2"];
       
        $sql = "SELECT * FROM tb_loker WHERE status ='Tampil' AND tanggal BETWEEN '$dt1' AND '$dt2'";
    }elseif 
    (isset($_POST["btnCetakSemua"])){
        $sql = "SELECT * FROM tb_loker WHERE status ='Tampil'";
    }
        $query = mysqli_query($con,$sql) or die (mysqli_error($con));
        $no = 1;
					while($data = mysqli_fetch_array($query)){?>
						
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

						<?php $no++; ?>

					<?php } ?>

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


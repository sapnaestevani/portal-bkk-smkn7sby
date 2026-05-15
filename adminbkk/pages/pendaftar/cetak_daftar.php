<?php
include_once("../../koneksi.php");
$query = $_POST['txttahun'];
$sql_loker = mysqli_query($con, "Select DISTINCT tb_pendaftaran.id_loker, tb_loker.nm_perusahaan, tb_loker.nm_loker FROM tb_pendaftaran, tb_loker WHERE tb_pendaftaran.id_loker=tb_loker.id_loker AND tb_loker.id_loker LIKE'" . $query . "'");
($dat = mysqli_fetch_array($sql_loker, MYSQLI_BOTH))
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DAFTAR PESERTA LOKER</title>

    <!-- Bootstrap core CSS -->
    <link href="css/sb-admin.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
        }

        th {
            background-color: #f2f2f2;
        }

        th,
        td {
            padding: 6px;
        }

        @media print {
            @page {
                margin: 20mm;
            }
        }
    </style>

</head>

<body style=color:black;>


    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td style="width:150px;">
                    <center>
                        <img src="img/logo_smkn7.png" width="110" height="110">
                    </center>
                </td>
                <td>
                    <center>
                        <h2 style="margin:0;">BURSA KERJA KHUSUS (BKK)</h2>
                        <h3 style="margin:0;"><b>SMK NEGERI 7 SURABAYA</b></h3>
                        Jl. Pawiyatan No. 2, Surabaya<br>
                        Jawa Timur<br>
                        Email : bkk@smkn7sby.sch.id
                    </center>
                </td>
            </tr>
        </tbody>
    </table>

    <hr style="border:2px solid black;">

    <hr>
    <br>
    <center>
        <h3 style="margin-bottom:5px;">DAFTAR HADIR PESERTA REKRUTMEN</h3>
        <h4 style="margin-top:0;">
            <?php echo $dat['nm_perusahaan']; ?> -
            <?php echo $dat['nm_loker']; ?>
        </h4>
    </center>

    <table border="1" style="width: 100%">
        <!-- <table border="1" width="700px"> -->


        <thead>
            <tr>
                <th>No. </th>
                <th>No. Pendaftaran</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Lowongan</th>
                <th>Tanda Tangan</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = $_POST['txttahun'];
            $sql_tampil = "SELECT tb_pendaftaran.id_pendaftaran, tb_peserta.nisn, tb_peserta.nama, tb_loker.nm_perusahaan, tb_loker.nm_loker, tb_pendaftaran.berkas FROM tb_pendaftaran, tb_peserta, tb_loker WHERE tb_pendaftaran.nisn=tb_peserta.nisn AND tb_pendaftaran.id_loker=tb_loker.id_loker AND tb_loker.id_loker LIKE'" . $query . "' ORDER BY id_pendaftaran ASC";
            $query_tampil = mysqli_query($con, $sql_tampil);
            while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td style='text-align: center'><?php echo $data['id_pendaftaran']; ?></td>
                    <td><?php echo $data['nisn']; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['nm_loker']; ?></td>
                    <td style="height:40px;"></td>
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
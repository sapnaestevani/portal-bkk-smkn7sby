<?php
include_once("koneksi.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="../../bower_components/morris.js/morris.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
<center>
	<h2>Grafik Data</h2>
</center>
<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
<?php 
if(isset($_POST["btnCetak"])){
    $dt1 = $_POST["tgl1"];
        $dt2 = $_POST["tgl2"];
    ?>
<canvas id="myChart" width="400" height="auto"></canvas>
 
<br>
 
<table class="table table-hover">
    <thead>
        <tr>
            <th>Total Permohonan</th>
            <th>Permohonan Antri</th>
            <th>Permohonan Ditolak</th>
            <th>Permohonan Selesai</th>
            <th>Pengambilan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total_permohonan = mysqli_query($con,"SELECT * FROM permohonan WHERE tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
        $p_diproses = mysqli_query($con,"SELECT * FROM permohonan WHERE status='antri' AND tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
        $p_ditolak = mysqli_query($con,"SELECT * FROM permohonan WHERE status='ditolak' AND tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
        $p_selesai = mysqli_query($con,"SELECT * FROM permohonan WHERE status='selesai' AND tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
        $pengambilan = mysqli_query($con,"SELECT * FROM pengambilan WHERE tgl_pengambilan BETWEEN '$dt1' AND '$dt2'");
        ?>
        <tr>
            <td><?php echo mysqli_num_rows($total_permohonan); ?></td>
            <td><?php echo mysqli_num_rows($p_diproses); ?></td>
            <td><?php echo mysqli_num_rows($p_ditolak); ?></td>
            <td><?php echo mysqli_num_rows($p_selesai); ?></td>
            <td><?php echo mysqli_num_rows($pengambilan); ?></td>
        </tr>
    </tbody>
</table>
<?php  
}elseif
(isset($_POST["btnCetakSemua"])){
?>
    <canvas id="myChartsemua" width="400" height="auto"></canvas>
 
    <br>
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Total Keseluruhan</th>
                <th>Alumni Bekerja</th>
                <th>Alumni Studi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_alumni = mysqli_query($con,"SELECT * FROM tb_tracer");
            $p_bekerja = mysqli_query($con,"SELECT * FROM tb_tracer WHERE status='Bekerja'");
            $p_studi = mysqli_query($con,"SELECT * FROM tb_tracer WHERE status='Studi'");
            // $pengambilan = mysqli_query($con,"SELECT * FROM pengambilan");
            ?>
            <tr>
                <td><?php echo mysqli_num_rows($total_alumni); ?></td>
                <td><?php echo mysqli_num_rows($p_bekerja); ?></td>
                <td><?php echo mysqli_num_rows($p_studi); ?></td>
            </tr>
        </tbody>
    </table>
<?php
}
?>
 
 <script>
  $(function () {
    "use strict";

   
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        {y: '2006', a: 100, b: 90},
        {y: '2007', a: 75, b: 65},
        {y: '2008', a: 50, b: 40},
        {y: '2009', a: 75, b: 65},
        {y: '2010', a: 50, b: 40},
        {y: '2011', a: 75, b: 65},
        {y: '2012', a: 100, b: 90}
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['CPU', 'DISK'],
      hideHover: 'auto'
    });
  });
</script>
<script>
    // var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Morris.Bar( {
      element: 'bar-chart',
      resize: true,
        data: {
            labels: ["Total Permohonan", "Permohonan Antri", "Permohonan Ditolak", "Permohonan Selesai", "Pengambilan"],
            datasets: [{
                label: '',
                data: [
                <?php 
                $total_permohonan = mysqli_query($con,"SELECT * FROM permohonan WHERE tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
                echo mysqli_num_rows($total_permohonan);
                ?>, 
                <?php 
                $p_antri = mysqli_query($con,"SELECT * FROM permohonan WHERE status='antri' AND tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
                echo mysqli_num_rows($p_antri);
                ?>, 
                <?php 
                $p_ditolak = mysqli_query($con,"SELECT * FROM permohonan WHERE status='ditolak' AND tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
                echo mysqli_num_rows($p_ditolak);
                ?>, 
                <?php 
                $p_selesai = mysqli_query($con,"SELECT * FROM permohonan WHERE status='selesai' AND tgl_permohonan BETWEEN '$dt1' AND '$dt2'");
                echo mysqli_num_rows($p_selesai);
                ?>, 
                <?php 
                $pengambilan = mysqli_query($con,"SELECT * FROM pengambilan WHERE tgl_pengambilan BETWEEN '$dt1' AND '$dt2'");
                echo mysqli_num_rows($pengambilan);
                ?>
                ],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById("myChartsemua").getContext('2d');
    var myChartsemua = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Total Alumni", "Alumni Bekerja", "Alumni Studi"],
            datasets: [{
                label: '',
                data: [
                <?php 
                $total_alumni = mysqli_query($con,"SELECT * FROM tb_tracer");
                echo mysqli_num_rows($total_alumni);
                ?>, 
                <?php 
                $p_bekerja = mysqli_query($con,"SELECT * FROM tb_tracer WHERE status='Bekerja'");
                echo mysqli_num_rows($p_bekerja);
                ?>, 
                <?php 
                $p_studi = mysqli_query($con,"SELECT * FROM tb_tracer WHERE status='Studi'");
                echo mysqli_num_rows($p_studi);
                ?>
                ],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
</html>
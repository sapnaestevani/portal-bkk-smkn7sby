<?php
error_reporting(0);
include_once("../../koneksi.php");

// Ambil parameter
$tipe  = isset($_GET['tipe']) ? $_GET['tipe'] : 'all';
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($con, $_GET['tahun']) : '';

// QUERY
if ($tipe == 'year' && !empty($tahun)) {

    $query = "SELECT 
        tb_tracer.id_tracer,
        tb_siswa.nama,
        tb_tracer.status_setelah_lulus,
        tb_tracer.aktivitas,
        tb_siswa.tahun_lulus
    FROM tb_tracer
    JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
    WHERE tb_tracer.status_setelah_lulus='Belum Bekerja'
    AND tb_siswa.tahun_lulus='$tahun'
    ORDER BY tb_tracer.id_tracer DESC";

    $judul = "Laporan Alumni Tahun $tahun";

} else {

    $query = "SELECT 
        tb_tracer.id_tracer,
        tb_siswa.nama,
        tb_tracer.status_setelah_lulus,
        tb_tracer.aktivitas,
        tb_siswa.tahun_lulus
    FROM tb_tracer
    JOIN tb_siswa ON tb_tracer.id_siswa = tb_siswa.id_siswa
    WHERE tb_tracer.status_setelah_lulus='Belum Bekerja'
    ORDER BY tb_tracer.id_tracer DESC";

    $judul = "Laporan Semua Alumni";
}

// Eksekusi query
$sql = mysqli_query($con, $query);

// Cek error query
if (!$sql) {
    die("Query Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Cetak Laporan</title>
<style>
body { font-family: Arial; }
table { border-collapse: collapse; width: 100%; }
th, td { border:1px solid #000; padding:8px; text-align:center; }
th { background:#eee; }
h2, h4 { margin: 0; }
</style>
</head>

<body onload="window.print()">

<h2 style="text-align:center;">LAPORAN TRACER STUDY</h2>
<h4 style="text-align:center;"><?php echo htmlspecialchars($judul); ?></h4>

<br>

<table>
<tr>
<th>No</th>
<th>Nama</th>
<th>Status</th>
<th>Aktivitas</th>
<th>Tahun</th>
</tr>

<?php
$no = 1;

if (mysqli_num_rows($sql) > 0) {
    while ($d = mysqli_fetch_assoc($sql)) {
?>
<tr>
<td><?php echo $no++; ?></td>
<td><?php echo htmlspecialchars($d['nama']); ?></td>
<td><?php echo htmlspecialchars($d['status_setelah_lulus']); ?></td>
<td><?php echo htmlspecialchars($d['aktivitas']); ?></td>
<td><?php echo htmlspecialchars($d['tahun_lulus']); ?></td>
</tr>
<?php
    }
} else {
?>
<tr>
<td colspan="5">Data tidak ditemukan</td>
</tr>
<?php } ?>

</table>

</body>
</html>
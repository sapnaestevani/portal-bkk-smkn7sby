<?php 
include_once("../../koneksi.php");

/* ================= DOMPDF ================= */
require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

/* ================= AMBIL INPUT ================= */
$jenis  = isset($_POST['jenis_laporan']) ? $_POST['jenis_laporan'] : "";
$filter = isset($_POST['txttahun']) ? $_POST['txttahun'] : "";
$mode   = isset($_POST['mode']) ? $_POST['mode'] : "print";

$where = "";
$judul = "LAPORAN SELURUH DATA PENDAFTAR";

/* ================= FILTER + JUDUL ================= */

if ($jenis == "per_loker" && $filter != "") {

    $where = " AND tb_lowongan.id_lowongan = '$filter'";

    $getLoker = mysqli_query($con, "SELECT judul_lowongan FROM tb_lowongan WHERE id_lowongan='$filter'");
    $dataLoker = mysqli_fetch_array($getLoker);
    $namaLoker = $dataLoker['judul_lowongan'];

    $judul = "LAPORAN PENDAFTAR BERDASARKAN LOWONGAN: $namaLoker";

}
elseif ($jenis == "per_perusahaan" && $filter != "") {

    $where = " AND tb_perusahaan.id_perusahaan = '$filter'";
    
    $getPerusahaan = mysqli_query($con, "SELECT nama_perusahaan FROM tb_perusahaan WHERE id_perusahaan='$filter'");
    $dataPerusahaan = mysqli_fetch_array($getPerusahaan);
    $namaPerusahaan = $dataPerusahaan['nama_perusahaan'];
    
    $judul = "LAPORAN PENDAFTAR BERDASARKAN PERUSAHAAN: $namaPerusahaan";

}
elseif ($jenis == "per_status" && $filter != "") {

    $where = " AND tb_lamaran.status = '$filter'";
    $judul = "LAPORAN PENDAFTAR BERDASARKAN STATUS: $filter";

}
elseif ($jenis == "semua") {

    $where = "";
    $judul = "LAPORAN SELURUH DATA PENDAFTAR";

}

/* ================= QUERY UTAMA ================= */

$sql_tampil = "
SELECT 
    tb_lamaran.id_lamaran,
    tb_siswa.nisn,
    tb_siswa.nama,
    tb_lowongan.judul_lowongan,
    tb_perusahaan.nama_perusahaan,
    tb_lamaran.status
FROM tb_lamaran
JOIN tb_siswa ON tb_lamaran.id_siswa = tb_siswa.id_siswa
JOIN tb_lowongan ON tb_lamaran.id_lowongan = tb_lowongan.id_lowongan
JOIN tb_perusahaan ON tb_lowongan.id_perusahaan = tb_perusahaan.id_perusahaan
WHERE 1=1
$where
ORDER BY tb_lamaran.id_lamaran DESC
";

$query_tampil = mysqli_query($con, $sql_tampil);

if (!$query_tampil) {
    die("Query Error: " . mysqli_error($con));
}

/* ================= MULAI CAPTURE HTML ================= */
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Data Pendaftar</title>

<style>
body{
    font-family: Arial, sans-serif;
    font-size: 11px;
    margin: 20px;
}
hr{
    border: 2px solid black;
    margin: 10px 0;
}
table{
    width: 100%;
    border-collapse: collapse;
}
th, td{
    border: 1px solid black;
    padding: 5px;
    vertical-align: middle;
}
th{
    background: #f2f2f2;
    text-align: center;
    font-weight: bold;
}
.text-left{ text-align: left; }
.text-center{ text-align: center; }
.text-right{ text-align: right; }
.ttd{
    width: 100%;
    margin-top: 40px;
}
.ttd td{
    border: none;
    text-align: right;
    padding-right: 40px;
    line-height: 1.5;
}
.header-table{
    width: 100%;
    border: none;
}
.header-table td{
    border: none;
    padding: 5px;
}
.judul-laporan{
    text-align: center;
    margin: 15px 0;
    font-weight: bold;
    text-decoration: underline;
}
</style>
</head>

<body>

<!-- ================= KOP SURAT ================= -->
<table class="header-table">
<tr>
<td width="15%" align="center">
<?php
// Coba berbagai kemungkinan path
$logo_paths = array(
    '../../img/logo_smkn7.png',
    '../img/logo_smkn7.png',
    'img/logo_smkn7.png',
    $_SERVER['DOCUMENT_ROOT'] . '/img/logo_smkn7.png'
);

$logo_found = false;
foreach ($logo_paths as $logo_path) {
    if (file_exists($logo_path)) {
        $logo_data = base64_encode(file_get_contents($logo_path));
        echo '<img src="data:image/png;base64,' . $logo_data . '" width="80" style="display:block; margin:0 auto;">';
        $logo_found = true;
        break;
    }
}
if (!$logo_found) {
    // Tampilkan placeholder jika logo tidak ditemukan
    echo '<div style="width:80px; height:80px; border:2px solid #333; display:inline-block; text-align:center; line-height:80px; font-size:10px;">LOGO<br>SMKN7</div>';
}
?>
</td>

<td width="70%" align="center">
<h3 style="margin:0; font-size:14px;">BURSA KERJA KHUSUS (BKK)</h3>
<h2 style="margin:0; font-size:16px;">SMK NEGERI 7 SURABAYA</h2>
Jl. Pawiyatan No.2, Bubutan, Kec. Bubutan, Surabaya, Jawa Timur 60174<br>
Email: bkk@smkn7sby.sch.id 
</td>

<td width="15%" align="center">
<?php
// Logo BKK - Cari dengan berbagai kemungkinan ekstensi & path
$logo_bkk_paths = array(
    '../../img/logo_bkk.png',
    '../../img/logo_bkk.jpg',
    '../../img/logo_bkk.jpeg',
    '../img/logo_bkk.png',
    '../img/logo_bkk.jpg',
    '../img/logo_bkk.jpeg',
    'img/logo_bkk.png',
    'img/logo_bkk.jpg'
);

$logo_bkk_found = false;
foreach ($logo_bkk_paths as $logo_bkk_path) {
    if (file_exists($logo_bkk_path)) {
        // Deteksi ekstensi & MIME type yang benar
        $ext = strtolower(pathinfo($logo_bkk_path, PATHINFO_EXTENSION));
        if ($ext == 'jpg' || $ext == 'jpeg') {
            $mime = 'jpeg';
        } elseif ($ext == 'png') {
            $mime = 'png';
        } elseif ($ext == 'gif') {
            $mime = 'gif';
        } else {
            $mime = 'png'; // default
        }
        
        $logo_bkk_data = base64_encode(file_get_contents($logo_bkk_path));
        echo '<img src="data:image/' . $mime . ';base64,' . $logo_bkk_data . '" width="70" style="display:block; margin:0 auto;">';
        $logo_bkk_found = true;
        break;
    }
}
if (!$logo_bkk_found) {
    // Placeholder jika logo tidak ditemukan
    echo '<div style="width:70px; height:70px; border:2px solid #333; display:inline-block; text-align:center; line-height:70px; font-size:10px; font-weight:bold;">LOGO<br>BKK</div>';
}
?>
</td>
</tr>
</table>

<hr>

<!-- ================= JUDUL LAPORAN ================= -->
<div class="judul-laporan">
<?php echo strtoupper($judul); ?>
</div>

<br>

<!-- ================= TABEL DATA ================= -->
<table>
<thead>
<tr>
<th width="5%">No</th>
<th width="12%">ID Lamaran</th>
<th width="12%">NISN</th>
<th width="20%">Nama</th>
<th width="22%">Lowongan</th>
<th width="20%">Perusahaan</th>
<th width="9%">Status</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;
$total = 0;

while ($data = mysqli_fetch_array($query_tampil)) {
    $total++;
?>

<tr>
<td class="text-center"><?php echo $no; ?></td>
<td class="text-center"><?php echo $data['id_lamaran']; ?></td>
<td class="text-center"><?php echo $data['nisn']; ?></td>
<td class="text-left"><?php echo $data['nama']; ?></td>
<td class="text-left"><?php echo $data['judul_lowongan']; ?></td>
<td class="text-left"><?php echo $data['nama_perusahaan']; ?></td>
<td class="text-center"><?php echo $data['status']; ?></td>
</tr>

<?php
$no++;
}

// Jika tidak ada data
if ($total == 0) {
?>
<tr>
<td colspan="7" class="text-center">Tidak ada data pendaftar</td>
</tr>
<?php
}
?>

</tbody>
</table>

<br>

<b>Total Pendaftar: <?php echo $total; ?> Orang</b>

<br><br><br>

<!-- ================= TANDA TANGAN ================= -->
<table class="ttd">
<tr>
<td></td>
<td class="text-right" style="padding-right: 50px; line-height: 1.8;">
Surabaya, <?php echo date("d F Y"); ?><br>
Mengetahui,<br>
Kepala BKK SMKN 7 Surabaya<br><br><br><br>

<b>
    <span style="display:inline-block; width:160px; border-bottom:1px solid #000;">&nbsp;</span>
</b><br>
NIP. <span style="display:inline-block; width:130px; border-bottom:1px solid #000;">&nbsp;</span>
</td>
</tr>
</table>

</body>
</html>

<?php
$html = ob_get_clean();

if ($mode == "pdf") {

    // ================= PDF MODE =================
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->render();
    
    // Download PDF
    $dompdf->stream("Laporan_Pendaftar_".date("Ymd").".pdf", array("Attachment" => true));
    exit;

} else {

    // ================= PREVIEW MODE =================
    echo $html;
    echo '<script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500);
    }
    </script>';
}
?>
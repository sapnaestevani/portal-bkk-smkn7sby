<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "koneksi.php";

$data_username = $_SESSION['ses_username'];

/* ambil tipe dari URL */
$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : '';

/* ambil data user */
$query = mysqli_query($con,"SELECT * FROM user WHERE username='$data_username'");
$data  = mysqli_fetch_assoc($query);

/* ambil isi sosial media sesuai tipe */
$tautan = "";

if($tipe == "instagram"){
    $tautan = $data['instagram'];
}
elseif($tipe == "facebook"){
    $tautan = $data['facebook'];
}
elseif($tipe == "linkedin"){
    $tautan = $data['linkedin'];
}
elseif($tipe == "whatsapp"){
    $tautan = $data['whatsapp'];
}
elseif($tipe == "website"){
    $tautan = $data['website'];
}

?>

<br>

<div class="card p-4">

<h4>Edit Sosial Media</h4>

<form method="POST" action="?halaman=update_sosial_media">

<input type="hidden" name="tipe" value="<?php echo $tipe; ?>">

<div class="form-group">

<label><?php echo ucfirst($tipe); ?></label>

<input type="text"
name="tautan"
class="form-control"
value="<?php echo $tautan; ?>"
required>

</div>

<br>

<button class="btn btn-success" name="update">
Simpan Perubahan
</button>

<a href="?halaman=profile&tab=sosial#sosial" class="btn btn-secondary">
Batal
</a>

</form>

</div>
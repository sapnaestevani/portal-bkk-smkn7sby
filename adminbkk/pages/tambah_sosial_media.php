<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "koneksi.php";

/* cek login */
$data_username = isset($_SESSION['ses_username']) ? $_SESSION['ses_username'] : '';

if($data_username == ""){
    echo "<script>window.location='login.php';</script>";
    exit;
}

/* ambil tab asal */
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'sosial';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.modal-card{
background:#fff;
border-radius:10px;
padding:25px;
box-shadow:0 4px 15px rgba(0,0,0,0.1);
max-width:750px;
width:100%;
margin:auto;
}

.modal-title{
font-size:20px;
font-weight:600;
margin-bottom:20px;
}

.form-group{
margin-bottom:18px;
}

.form-group label{
font-weight:500;
display:block;
margin-bottom:6px;
}

.form-control{
width:100%;
padding:10px;
border-radius:6px;
border:1px solid #ccc;
}

.btn-simpan{
background:#0d6efd;
color:#fff;
border:none;
padding:10px 18px;
border-radius:6px;
cursor:pointer;
}

.btn-simpan:hover{
background:#0b5ed7;
}

.help-text{
font-size:13px;
color:#777;
margin-top:5px;
}
.btn-batal{
background:#6c757d;
color:white;
padding:10px 18px;
border-radius:6px;
text-decoration:none;
margin-left:8px;
display:inline-block;
}

.btn-batal:hover{
background:#5a6268;
color:white;
}
</style>

<br><br><br>

<div class="modal-card">

<div class="modal-title">
Tambah Data Akun Sosial
</div>

<form method="POST">

<div class="form-group">

<label>Tipe *</label>

<select name="tipe" id="tipe" class="form-control"
style="height:40px;"
required onchange="ubahContoh()">

<option value="">-- Pilih Sosial Media --</option>
<option value="facebook">Facebook</option>
<option value="linkedin">LinkedIn</option>
<option value="instagram">Instagram</option>
<option value="whatsapp">WhatsApp</option>

</select>

<div class="help-text">
Tidak boleh kosong, contoh: WhatsApp Facebook Instagram LinkedIn
</div>

</div>


<div class="form-group">

<label>Tautan Profil *</label>

<input type="text" name="tautan" id="tautan" class="form-control" required>

<div class="help-text" id="contoh">
Tidak boleh kosong
</div>

</div>


<button type="submit" name="simpan" class="btn-simpan">
<i class="fa fa-save"></i> Simpan
</button>
<a href="?halaman=profile_perusahaan#sosial" class="btn-batal">
<i class="fa fa-times"></i> Batal
</a>

</form>

</div>


<script>

function ubahContoh(){

var tipe = document.getElementById("tipe").value;
var contoh = document.getElementById("contoh");
var input = document.getElementById("tautan");

if(tipe == "facebook"){
contoh.innerHTML = "Ex: https://facebook.com/namaperusahaan";
input.placeholder = "https://facebook.com/namaperusahaan";
}

else if(tipe == "instagram"){
contoh.innerHTML = "Ex: https://instagram.com/username";
input.placeholder = "https://instagram.com/username";
}

else if(tipe == "linkedin"){
contoh.innerHTML = "Ex: https://linkedin.com/in/username";
input.placeholder = "https://linkedin.com/in/username";
}

else if(tipe == "whatsapp"){
contoh.innerHTML = "Ex: (wajib Link tautan whatsapp)";
input.placeholder = "081234567890";
}

else{
contoh.innerHTML = "Tidak boleh kosong";
input.placeholder = "";
}

}

</script>


<?php

if(isset($_POST['simpan'])){

$tipe   = $_POST['tipe'];
$tautan = mysqli_real_escape_string($con,$_POST['tautan']);

if($tipe == "" || $tautan == ""){
echo "<script>alert('Data tidak boleh kosong');</script>";
exit;
}

/* validasi tipe */
$allowed = ['facebook','instagram','linkedin','whatsapp'];

if(in_array($tipe,$allowed)){

    // =========================
    // AMBIL ID USER
    // =========================
    $getUser = mysqli_query($con,"SELECT id_user FROM tb_user WHERE username='$data_username'");
    $user = mysqli_fetch_assoc($getUser);

    if(!$user){
        echo "<script>alert('User tidak ditemukan');</script>";
        exit;
    }

    $id_user = $user['id_user'];

    // =========================
    // CEK SUDAH ADA / BELUM
    // =========================
    $cek = mysqli_query($con,"
    SELECT * FROM tb_sosial_media 
    WHERE id_user='$id_user' 
    AND nama_platform='$tipe'
    ");

    if(mysqli_num_rows($cek) > 0){

        // UPDATE
        $sql = mysqli_query($con,"
        UPDATE tb_sosial_media 
        SET link='$tautan'
        WHERE id_user='$id_user' 
        AND nama_platform='$tipe'
        ");

    } else {

        // INSERT
        $sql = mysqli_query($con,"
        INSERT INTO tb_sosial_media 
        (id_user, nama_platform, link) 
        VALUES 
        ('$id_user','$tipe','$tautan')
        ");

    }

    if($sql){

        echo "<script>
        alert('Data berhasil disimpan');
        window.location='?halaman=profile_perusahaan&tab=sosial#sosial';
        </script>";

    }else{

        echo "<script>alert('Gagal menyimpan: ".mysqli_error($con)."');</script>";

    }

}else{

    echo "<script>alert('Tipe sosial media tidak valid');</script>";

}

}

?>
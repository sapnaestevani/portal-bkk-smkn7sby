<?php
$data_username = $_SESSION['ses_username'] ?? '';

if($data_username == ''){
    echo "<script>window.location='login.php';</script>";
    exit;
}

$tipe = $_GET['tipe'] ?? '';

$mapping = [
    'nib'  => 'file_nib',
    'npwp' => 'file_npwp',
    'mou'  => 'file_mou'
];

$kolom = $mapping[$tipe] ?? '';

$getUser = mysqli_query($con,"SELECT id_user FROM tb_user WHERE username='$data_username'");
$user = mysqli_fetch_assoc($getUser);
$id_user = $user['id_user'] ?? 0;

$getPerusahaan = mysqli_query($con,"SELECT id_perusahaan FROM tb_perusahaan WHERE id_user='$id_user'");
$perusahaan = mysqli_fetch_assoc($getPerusahaan);
$id_perusahaan = $perusahaan['id_perusahaan'] ?? 0;

$getDok = mysqli_query($con,"SELECT * FROM tb_dokumen_perusahaan WHERE id_perusahaan='$id_perusahaan'");
$dok = mysqli_fetch_assoc($getDok);

$file_lama = $dok[$kolom] ?? '';
?>

<style>

/* BACKGROUND HALAMAN */
.content-wrapper{
    background: linear-gradient(135deg, #f4f4f4, #ffffff);
    min-height: 100vh;
    padding:40px 20px;
}

/* CONTAINER */
.upload-container{
    max-width:550px;
    margin:auto;
}

/* CARD */
.upload-card{
    background:#ffffff;
    border-radius:20px;
    padding:30px;
    box-shadow:0 20px 50px rgba(0,0,0,0.2);
    text-align:center;
    animation:fadeIn .5s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

/* TITLE */
.upload-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:25px;
}

/* BOX */
.upload-box{
    border:2px dashed #28a745;
    border-radius:16px;
    padding:40px 20px;
    cursor:pointer;
    transition:.3s;
    background:#f8fff9;
}

.upload-box:hover{
    background:#eafff0;
    border-color:#20c997;
    transform:scale(1.02);
}

/* ICON */
.upload-icon{
    font-size:60px;
    margin-bottom:10px;
}

/* TEXT */
.main-text{
    font-size:16px;
    font-weight:600;
}

.sub-text{
    font-size:13px;
    color:#777;
}

/* FILE NAME */
.file-name{
    margin-top:15px;
    font-size:14px;
    font-weight:500;
    color:#333;
}

/* BUTTON */
.btn-upload{
    margin-top:25px;
    background:linear-gradient(45deg,#28a745,#20c997);
    color:white;
    border:none;
    padding:14px;
    border-radius:10px;
    width:100%;
    font-size:15px;
    font-weight:600;
    transition:.3s;
}

.btn-upload:hover{
    transform:scale(1.03);
}

/* BACK */
.btn-back{
    display:block;
    margin-top:12px;
    color:#444;
    text-decoration:none;
}

/* RESPONSIVE */
@media(max-width:600px){
    .upload-card{
        padding:20px;
    }
}

</style>

<div class="upload-container">

<div class="upload-card">

<div class="upload-title">
📄 Upload Dokumen <?= strtoupper($tipe) ?>
</div>

<form method="POST" enctype="multipart/form-data">

<input type="hidden" name="kolom" value="<?= $kolom ?>">

<label class="upload-box">

<div class="upload-icon">📤</div>

<div class="main-text">Klik untuk upload dokumen</div>
<div class="sub-text">Format PDF / JPG / PNG (Max 2MB)</div>

<input type="file" name="dokumen" id="fileInput" style="display:none;" required>

<div class="file-name" id="fileName">
Belum ada file dipilih
</div>

</label>

<?php if($file_lama != ""){ ?>
<br>
<a href="dokumen/<?= $file_lama ?>" target="_blank" class="btn btn-primary">
Lihat Dokumen Lama
</a>
<?php } ?>

<button type="submit" name="upload" class="btn-upload">
Upload Dokumen
</button>

<a href="?halaman=profile_perusahaan&tab=dokumen#dokumen" class="btn-back">
Kembali
</a>

</form>

</div>
</div>

<script>
const input = document.getElementById("fileInput");
const text = document.getElementById("fileName");

input.addEventListener("change", function(){
    if(this.files.length > 0){
        text.innerText = this.files[0].name;
    }else{
        text.innerText = "Belum ada file dipilih";
    }
});
</script>

<?php

if(isset($_POST['upload'])){

$kolom = $_POST['kolom'];

$nama = $_FILES['dokumen']['name'];
$tmp  = $_FILES['dokumen']['tmp_name'];

$folder = "dokumen/";

if($nama != ""){

$nama_baru = time().'_'.$nama;

move_uploaded_file($tmp, $folder.$nama_baru);

$cek = mysqli_query($con,"SELECT * FROM tb_dokumen_perusahaan WHERE id_perusahaan='$id_perusahaan'");

if(mysqli_num_rows($cek) > 0){

    mysqli_query($con,"
        UPDATE tb_dokumen_perusahaan 
        SET `$kolom`='$nama_baru'
        WHERE id_perusahaan='$id_perusahaan'
    ");

}else{

    mysqli_query($con,"
        INSERT INTO tb_dokumen_perusahaan (id_perusahaan, `$kolom`) 
        VALUES ('$id_perusahaan','$nama_baru')
    ");
}

echo "<script>
alert('Dokumen berhasil diupload');
window.location='?halaman=profile_perusahaan&tab=dokumen#dokumen';
</script>";

}

}
?>
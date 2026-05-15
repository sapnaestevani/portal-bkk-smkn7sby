<?php
// ======================
// SESSION AMAN
// ======================
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("../koneksi.php");

// Pastikan session ada
if (!isset($_SESSION["ses_nisn"])) {
    echo "<script>window.location='../login.php';</script>";
    exit;
}

$nisn = $_SESSION["ses_nisn"];


// ======================
// PROSES UPDATE
// ======================
if (isset($_POST['btnSimpan'])) {

    $nama        = $_POST['nama'];
    $jekel       = $_POST['jekel'];
    $tempat_lhr  = $_POST['tempat_lhr'];
    $tgl_lhr     = $_POST['tgl_lhr'];
    $nama_ortu   = $_POST['nama_ortu'];
    $alamat      = $_POST['alamat'];
    $telp        = $_POST['telp'];
    $jurusan     = $_POST['jurusan'];
    $tahun_lulus = $_POST['tahun_lulus'];

    // Jika upload foto baru
    if (!empty($_FILES['foto']['name'])) {

        $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = "foto_" . time() . "." . $ext;

        move_uploaded_file($_FILES['foto']['tmp_name'], "foto/" . $foto);

        $query = mysqli_query($con, "UPDATE tb_peserta SET
            nama='$nama',
            jekel='$jekel',
            tempat_lhr='$tempat_lhr',
            tgl_lhr='$tgl_lhr',
            nama_ortu='$nama_ortu',
            alamat='$alamat',
            telp='$telp',
            jurusan='$jurusan',
            tahun_lulus='$tahun_lulus',
            foto='$foto'
            WHERE nisn='$nisn'
        ");

    } else {

        $query = mysqli_query($con, "UPDATE tb_peserta SET
            nama='$nama',
            jekel='$jekel',
            tempat_lhr='$tempat_lhr',
            tgl_lhr='$tgl_lhr',
            nama_ortu='$nama_ortu',
            alamat='$alamat',
            telp='$telp',
            jurusan='$jurusan',
            tahun_lulus='$tahun_lulus'
            WHERE nisn='$nisn'
        ");
    }

    if ($query) {
        echo "<script>
            alert('Profil berhasil diperbarui');
            window.location='index_pst.php?halaman=profile_peserta&nisn=$nisn';
        </script>";
        exit;
    } else {
        echo mysqli_error($con);
        exit;
    }
}


// ======================
// AMBIL DATA
// ======================
$sql  = mysqli_query($con, "SELECT * FROM tb_peserta WHERE nisn='$nisn'");
$data = mysqli_fetch_array($sql, MYSQLI_BOTH);

if ($data['foto'] == "" || $data['foto'] == NULL) {
    $foto = "../dist/img/pegawai.png";
} else {
    $foto = "foto/" . $data['foto'];
}
?>

<style>

.overlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
z-index:9999;
overflow:auto;
padding:40px 15px;
}

/* CARD */

.edit-card{
max-width:900px;
margin:auto;
background:white;
border-radius:14px;
box-shadow:0 20px 40px rgba(0,0,0,.15);
overflow:hidden;
animation:fadeUp .5s ease;
}

/* HEADER */

.edit-header{
background:linear-gradient(120deg,#007bff,#00c6ff);
color:white;
padding:20px 25px;
display:flex;
justify-content:space-between;
align-items:center;
}

.edit-title{
font-size:20px;
font-weight:600;
}

/* BODY */

.edit-body{
padding:30px;
}

/* GRID FORM */

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

.form-group{
display:flex;
flex-direction:column;
}

.form-group.full{
grid-column:1/3;
}

label{
font-size:13px;
font-weight:600;
margin-bottom:5px;
color:#444;
}

input,select{
padding:10px 12px;
border:1px solid #ddd;
border-radius:6px;
font-size:14px;
transition:.2s;
}

input:focus,select:focus{
outline:none;
border-color:#007bff;
box-shadow:0 0 0 2px rgba(0,123,255,.15);
}

/* BUTTON */

.form-footer{
margin-top:25px;
display:flex;
gap:10px;
}

.btn-modern{
border:none;
padding:10px 18px;
border-radius:8px;
font-weight:600;
cursor:pointer;
display:inline-flex;
align-items:center;
gap:6px;
}

.btn-save{
background:linear-gradient(120deg,#28a745,#00d97e);
color:white;
}

.btn-save:hover{
transform:translateY(-2px);
box-shadow:0 8px 15px rgba(0,0,0,.2);
}

.btn-cancel{
background:#e9ecef;
color:#333;
text-decoration:none;
}

.btn-cancel:hover{
background:#dee2e6;
}

/* ANIMATION */

@keyframes fadeUp{
from{
opacity:0;
transform:translateY(30px);
}
to{
opacity:1;
transform:translateY(0);
}
}

</style>



<div class="overlay">

<div class="edit-card">

<div class="edit-header">

<div class="edit-title">
<i class="fa fa-user"></i> Edit Profil Saya
</div>

<a href="?halaman=profile_peserta&nisn=<?php echo $data_nisn; ?>" style="color:white;font-size:18px;">
<i class="fa fa-times"></i>
</a>

</div>


<div class="edit-body">

<form method="POST" enctype="multipart/form-data">

<div class="form-grid">

<div class="form-group">
<label>NISN</label>
<input type="text" name="nisn" value="<?php echo $data['nisn']; ?>" readonly>
</div>

<div class="form-group">
<label>Nama</label>
<input type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
</div>

<div class="form-group">
<label>Jenis Kelamin</label>
<select name="jekel" required>
<option value="<?php echo $data['jekel']; ?>"><?php echo $data['jekel']; ?></option>
<option value="Pria">Pria</option>
<option value="Wanita">Wanita</option>
</select>
</div>

<div class="form-group">
<label>Tempat Lahir</label>
<input type="text" name="tempat_lhr" value="<?php echo $data['tempat_lhr']; ?>" required>
</div>

<div class="form-group">
<label>Tanggal Lahir</label>
<input type="date" name="tgl_lhr" value="<?php echo $data['tgl_lhr']; ?>" required>
</div>

<div class="form-group">
<label>Nama Orang Tua</label>
<input type="text" name="nama_ortu" value="<?php echo $data['nama_ortu']; ?>" required>
</div>

<div class="form-group full">
<label>Alamat</label>
<input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" required>
</div>

<div class="form-group">
<label>No Telephone</label>
<input type="text" name="telp" value="<?php echo $data['telp']; ?>" required>
</div>

<div class="form-group">
<label>Jurusan</label>
<input type="text" name="jurusan" value="<?php echo $data['jurusan']; ?>" required>
</div>

<div class="form-group">
<label>Tahun Lulus</label>
<input type="text" name="tahun_lulus" value="<?php echo $data['tahun_lulus']; ?>" required>
</div>

</div>


<div class="form-footer">

<button type="submit" name="btnSimpan" class="btn-modern btn-save">
<i class="fa fa-save"></i> Simpan
</button>

<a href="?halaman=profile_peserta&nisn=<?php echo $data_nisn; ?>" class="btn-modern btn-cancel">
Batal
</a>

</div>

</form>

</div>

</div>

</div>
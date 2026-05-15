<?php
session_start();
include_once("../koneksi.php");

if (!isset($_SESSION["ses_nisn"])) {
    echo "<script>
alert('Data berhasil disimpan');
window.location='index_pst.php';
</script>";
    exit;
}

$nisn = $_SESSION["ses_nisn"];

// Jika sudah isi, langsung ke dashboard
$cek = mysqli_query($con, "SELECT nisn FROM tb_peserta WHERE nisn='$nisn'");
if (mysqli_num_rows($cek) > 0 && !isset($_POST['simpan'])) {
    header("Location: index_pst.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $jekel = $_POST['jekel'];
    $tempat = mysqli_real_escape_string($con, $_POST['tempat_lhr']);
    $tgl = $_POST['tgl_lhr'];
    $ortu = mysqli_real_escape_string($con, $_POST['nama_ortu']);
    $alamat = mysqli_real_escape_string($con, $_POST['alamat']);
    $telp = mysqli_real_escape_string($con, $_POST['telp']);
    $jurusan = mysqli_real_escape_string($con, $_POST['jurusan']);
    $tahun = $_POST['tahun_lulus'];

    // validasi wajib isi
    if (
        $nama == "" ||
        $jekel == "" ||
        $tempat == "" ||
        $tgl == "" ||
        $ortu == "" ||
        $alamat == "" ||
        $telp == "" ||
        $jurusan == "" ||
        $tahun == ""
    ) {

        echo "<script>alert('Semua data wajib diisi!');</script>";

    } else {

        $nama_foto = "";

        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {

            $foto = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];

            $nama_foto = time() . '_' . $foto;

            move_uploaded_file($tmp, "foto/" . $nama_foto);

        }

        mysqli_query($con, "INSERT INTO tb_peserta
        (nisn,nama,jekel,tempat_lhr,tgl_lhr,nama_ortu,alamat,telp,jurusan,tahun_lulus,foto)
        VALUES
        ('$nisn','$nama','$jekel','$tempat','$tgl','$ortu','$alamat','$telp','$jurusan','$tahun','$nama_foto')");

        header("Location: index_pst.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lengkapi Data Profil</title>

    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f7, #dbe6f6);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        /* CARD */
        .profile-card {
            max-width: 720px;
            margin: 60px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 40px;
            transition: 0.3s;
        }

        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
        }

        /* HEADER */
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        /* FOTO PROFIL */
        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: 0.3s;
        }

        .profile-img:hover {
            transform: scale(1.05);
        }

        /* RING GRADIENT */
        .profile-img-wrapper {
            width: 150px;
            height: 150px;
            margin: auto;
            border-radius: 50%;
            padding: 5px;
            background: linear-gradient(135deg, #3c8dbc, #00c6ff);
            position: relative;
        }

        /* ICON KAMERA */
        .upload-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #3c8dbc;
            color: white;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            border: 3px solid white;
        }

        /* TITLE */
        .profile-title {
            font-size: 26px;
            font-weight: 700;
            margin-top: 15px;
            color: #333;
        }

        /* NISN BADGE */
        .nisn-badge {
            display: inline-block;
            margin-top: 5px;
            background: #eaf3ff;
            color: #3c8dbc;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        /* FORM */
        .form-group label {
            font-weight: 600;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid #ddd;
            height: 45px;
            font-size: 14px;
        }

        /* BUTTON */
        .btn-save {
            background: linear-gradient(135deg, #3c8dbc, #00bcd4);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="profile-card">

            <form method="POST" enctype="multipart/form-data">

                <div class="profile-header">

                    <div class="profile-img-wrapper">

                        <label for="fotoUpload">
                            <img id="previewFoto" class="profile-img" src="../dist/img/user.png">
                        </label>
                        <label for="fotoUpload" class="upload-icon">
                            <i class="glyphicon glyphicon-camera"></i>
                        </label>
                    </div>

                    <input type="file" name="foto" id="fotoUpload" accept="image/*" style="display:none;">

                    <div class="profile-title">
                        Lengkapi Profil Peserta
                    </div>

                    <div class="nisn-badge">
                        NISN : <?php echo $nisn; ?>
                    </div>

                    <p style="color:#777;margin-top:10px;">
                        Klik foto untuk upload gambar
                    </p>

                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jekel" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lhr" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lhr" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nama Orang Tua</label>
                    <input type="text" name="nama_ortu" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="telp" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan" class="form-control" required>

                        <option value="">-- Pilih Jurusan --</option>

                        <option value="Teknik Gambar Bangunan (TGB)">Teknik Gambar Bangunan (TGB)</option>
                        <option value="Teknik Audio Video (TAV)">Teknik Audio Video (TAV)</option>
                        <option value="Teknik Komputer Jaringan (TKJ)">Teknik Komputer Jaringan (TKJ)</option>
                        <option value="Teknik Konstruksi Batu Beton (KBB)">Teknik Konstruksi Batu Beton (KBB)</option>
                        <option value="Teknik Instalasi Tenaga Listrik (TITL)">Teknik Instalasi Tenaga Listrik (TITL)
                        </option>
                        <option value="Teknik Kendaraan Ringan (TKR)">Teknik Kendaraan Ringan (TKR)</option>
                        <option value="Teknik Pemesinan (TPM)">Teknik Pemesinan (TPM)</option>
                        <option value="Teknik Pendingin dan Tata Udara (TPTU)">Teknik Pendingin dan Tata Udara (TPTU)
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" class="form-control" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-save btn-block">
                    Simpan Data
                </button>

            </form>

        </div>
    </div>

    <script>

        document.getElementById("fotoUpload").onchange = function (evt) {

            let reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById("previewFoto").src = e.target.result;
            }

            reader.readAsDataURL(evt.target.files[0]);

        };

    </script>

</body>

</html>
<?php
include_once("../../koneksi.php");

if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($con, $_GET['id']);

  // ✅ PERBAIKAN: Gunakan tabel yang BENAR sesuai struktur database
  $sql = mysqli_query($con, "
    SELECT l.*, s.nama, lw.judul_lowongan
    FROM tb_lamaran l
    JOIN tb_siswa s ON l.id_siswa = s.id_siswa
    JOIN tb_lowongan lw ON l.id_lowongan = lw.id_lowongan
    WHERE l.id_lamaran='$id'
  ");

  if (!$sql) {
    die("Query Error: " . mysqli_error($con));
  }

  $data = mysqli_fetch_array($sql);
  
  if (!$data) {
    echo "<script>
      alert('Data lamaran tidak ditemukan!');
      window.location='../../index.php?halaman=pendaftar_tampil';
    </script>";
    exit;
  }
} else {
  echo "<script>
    alert('ID lamaran tidak ditemukan!');
    window.location='../../index.php?halaman=pendaftar_tampil';
  </script>";
  exit;
}

if (isset($_POST['update'])) {
  $status = mysqli_real_escape_string($con, $_POST['status']);

  // ✅ PERBAIKAN: Update tabel tb_lamaran
  $update = mysqli_query($con, "
    UPDATE tb_lamaran
    SET status='$status'
    WHERE id_lamaran='$id'
  ");

  if ($update) {
    echo "<script>
      alert('Status berhasil diperbarui!');
      window.location='index.php?halaman=pendaftar_tampil';
    </script>";
  } else {
    echo "<script>
      alert('Gagal memperbarui status: " . mysqli_error($con) . "');
      window.history.back();
    </script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ubah Status Lamaran</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  
  <style>
    .update-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
    }
    .info-box {
      background: #f8f9fa;
      border-left: 4px solid #667eea;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
    }
    .info-box p {
      margin: 8px 0;
      font-size: 15px;
    }
    .info-box strong {
      color: #2d3748;
    }
    .form-control {
      border-radius: 8px;
      padding: 12px;
      font-size: 15px;
    }
    .btn {
      border-radius: 8px;
      padding: 12px 24px;
      font-weight: 600;
      margin-right: 10px;
    }
    .status-options {
      display: grid;
      gap: 10px;
      margin-bottom: 20px;
    }
    .status-option {
      padding: 15px;
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s;
      text-align: center;
      font-weight: 600;
    }
    .status-option:hover {
      border-color: #667eea;
      background: #f0f4ff;
      transform: translateY(-2px);
    }
    .status-option.selected {
      border-color: #667eea;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
  </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">
    <div class="content-wrapper" style="margin-left: 0;">
      <section class="content">
        <div class="update-container">
          <div class="box box-primary" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <div class="box-header with-border" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 16px 16px 0 0; padding: 20px;">
              <h3 class="box-title" style="font-size: 22px; font-weight: 700;">
                <i class="fa fa-edit"></i> Ubah Status Lamaran
              </h3>
            </div>

            <div class="box-body" style="padding: 30px;">
              <div class="info-box">
                <p><strong><i class="fa fa-user"></i> Nama Pelamar:</strong><br>
                <?php echo htmlspecialchars($data['nama']); ?></p>
                
                <p><strong><i class="fa fa-briefcase"></i> Posisi Dilamar:</strong><br>
                <?php echo htmlspecialchars($data['judul_lowongan']); ?></p>
                
                <p><strong><i class="fa fa-info-circle"></i> Status Saat Ini:</strong><br>
                <span class="label label-<?php 
                  switch($data['status']) {
                    case 'Diproses': echo 'warning'; break;
                    case 'Panggilan Tes': echo 'info'; break;
                    case 'Wawancara': echo 'primary'; break;
                    case 'Diterima': echo 'success'; break;
                    case 'Ditolak': echo 'danger'; break;
                    default: echo 'default';
                  }
                ?>" style="font-size: 14px; padding: 8px 15px;">
                  <?php echo htmlspecialchars($data['status']); ?>
                </span></p>
              </div>

              <form method="POST">
                <div class="form-group">
                  <label style="font-weight: 600; font-size: 15px; margin-bottom: 15px;">
                    <i class="fa fa-check-circle"></i> Pilih Status Baru:
                  </label>
                  
                  <div class="status-options">
                    <div class="status-option" onclick="selectStatus('Diproses')" data-status="Diproses">
                      <i class="fa fa-spinner fa-spin"></i> Diproses
                    </div>
                    <div class="status-option" onclick="selectStatus('Panggilan Tes')" data-status="Panggilan Tes">
                      <i class="fa fa-envelope"></i> Panggilan Tes
                    </div>
                    <div class="status-option" onclick="selectStatus('Wawancara')" data-status="Wawancara">
                      <i class="fa fa-comments"></i> Wawancara
                    </div>
                    <div class="status-option" onclick="selectStatus('Diterima')" data-status="Diterima">
                      <i class="fa fa-check"></i> Diterima
                    </div>
                    <div class="status-option" onclick="selectStatus('Ditolak')" data-status="Ditolak">
                      <i class="fa fa-times"></i> Ditolak
                    </div>
                  </div>
                  
                  <input type="hidden" name="status" id="statusInput" value="<?php echo htmlspecialchars($data['status']); ?>" required>
                </div>

                <hr style="margin: 30px 0;">

                <button type="submit" name="update" class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                  <i class="fa fa-save"></i> Update Status
                </button>
                
                <a href="../../index.php?halaman=pendaftar_tampil" class="btn btn-default btn-lg">
                  <i class="fa fa-arrow-left"></i> Kembali
                </a>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <!-- jQuery 3 -->
  <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  
  <script>
    function selectStatus(status) {
      // Set value input
      document.getElementById('statusInput').value = status;
      
      // Update UI
      document.querySelectorAll('.status-option').forEach(option => {
        option.classList.remove('selected');
        if (option.dataset.status === status) {
          option.classList.add('selected');
        }
      });
    }
    
    // Set initial selection
    document.addEventListener('DOMContentLoaded', function() {
      const currentStatus = '<?php echo htmlspecialchars($data['status']); ?>';
      selectStatus(currentStatus);
    });
  </script>
</body>
</html>
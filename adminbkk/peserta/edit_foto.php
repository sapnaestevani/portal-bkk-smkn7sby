<?php
// 1. Cek dan Mulai Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../koneksi.php";
// Tambahkan di bagian atas setelah require_once
$id_siswa = mysqli_real_escape_string($con, $_GET['id_siswa'] ?? '');
// Cek apakah user sudah login
if (!isset($_SESSION['ses_nisn'])) {
    // Jika belum, redirect ke login (sesuaikan path jika perlu)
    header("Location: ../peserta.php");
    exit;
}

$nisn = $_SESSION['ses_nisn'];

// 2. Proses Upload Foto
if (isset($_POST['simpan'])) {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

        // Validasi tipe file
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // Validasi ukuran (Maks 2MB)
            if ($_FILES['foto']['size'] <= 2 * 1024 * 1024) {

                // Nama file aman: profil_NISN_timestamp.ext
                $nama_baru = "profil_" . preg_replace("/[^a-zA-Z0-9]/", "", $nisn) . "_" . time() . "." . $ext;
                $tmp = $_FILES['foto']['tmp_name'];
                $target = "foto/" . $nama_baru;

                // Buat folder 'foto' jika belum ada
                if (!is_dir("foto"))
                    mkdir("foto", 0755, true);

                if (move_uploaded_file($tmp, $target)) {

                    // Ambil foto lama untuk dihapus (opsional, agar tidak menumpuk sampah)
                    $sql_cek_foto = mysqli_query($con, "SELECT foto FROM tb_siswa WHERE nisn='$nisn'");
                    if ($row = mysqli_fetch_assoc($sql_cek_foto)) {
                        if (!empty($row['foto']) && file_exists("foto/" . $row['foto'])) {
                            unlink("foto/" . $row['foto']);
                        }
                    }

                    // Update database
                    $update = mysqli_query($con, "UPDATE tb_siswa SET foto='$nama_baru' WHERE nisn='$nisn'");

                    if ($update) {
                        echo "<script>
        alert('✅ Foto profil berhasil diperbarui!');
        window.location.href='?halaman=profile_peserta&id_siswa=" . $id_siswa . "&tab=personal';
    </script>";
                        exit;
                    } else {
                        echo "<script>alert('❌ Gagal update database.');</script>";
                    }
                } else {
                    echo "<script>alert('❌ Gagal memindahkan file.');</script>";
                }
            } else {
                echo "<script>alert('⚠️ Ukuran foto maksimal 2MB!');</script>";
            }
        } else {
            echo "<script>alert('⚠️ Format harus JPG, PNG, atau WebP!');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Silakan pilih foto terlebih dahulu!');</script>";
    }
}

// 3. Ambil Data Foto Saat Ini untuk Preview
$sql_siswa = mysqli_query($con, "SELECT foto FROM tb_siswa WHERE nisn='$nisn'");
$d = mysqli_fetch_assoc($sql_siswa);
$foto_src = !empty($d['foto']) ? "foto/" . htmlspecialchars($d['foto']) : "dist/img/pegawai.png";
?>

<!-- TAMPILAN HTML & CSS -->
<!-- Kita gunakan style 'fixed' untuk menutupi sidebar dan layout utama -->
<div class="overlay-container">
    <div class="upload-card">

        <!-- Loading Spinner (Hidden by default) -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="spinner"></div>
        </div>

        <div class="card-title">Ubah Foto Profil</div>
        <div class="card-desc">Format: JPG, PNG, atau WebP (Maks. 2MB)</div>

        <div class="preview-container">
            <div class="preview-circle">
                <img id="previewImg" src="<?php echo $foto_src; ?>" alt="Preview Foto">
            </div>
            <label for="fotoInput" class="camera-badge" title="Ganti Foto">
                <i class="fa fa-camera"></i>
            </label>
        </div>

        <form method="POST" enctype="multipart/form-data" id="uploadForm">
            <label class="upload-area" id="uploadArea">
                <i class="fa fa-cloud-arrow-up"></i>
                <div class="upload-text" id="uploadText">Klik untuk memilih foto</div>
                <div class="upload-hint" id="uploadHint">atau tarik & lepas file di sini</div>
                <div class="file-name" id="fileName" style="display: none;"></div>
                <input type="file" name="foto" id="fotoInput" accept="image/jpeg, image/png, image/webp">
            </label>

            <div class="btn-group">
                <a href="?halaman=profile_peserta&id_siswa=<?php echo $id_siswa ?>&tab=personal"
                    class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="simpan" class="btn btn-primary" id="btnSimpan" disabled>
                    <i class="fa fa-save"></i> Simpan Foto
                </button>
            </div>
        </form>
    </div>
</div>

<!-- STYLE CSS KHUSUS OVERLAY -->
<style>
    /* 1. Overlay Container: Menutupi seluruh layar termasuk sidebar */
    .overlay-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.7);
        /* Gelap transparan */
        backdrop-filter: blur(5px);
        /* Efek blur background */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        /* Pastikan di atas segalanya */
        padding: 20px;
        box-sizing: border-box;
    }

    /* 2. Card Upload */
    .upload-card {
        background: #ffffff;
        width: 100%;
        max-width: 420px;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        padding: 36px 32px;
        text-align: center;
        position: relative;
        animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .card-desc {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 3. Preview Circle */
    .preview-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 24px;
    }

    .preview-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid #fff;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        background: #f1f5f9;
    }

    .preview-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s;
    }

    .camera-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        border: 3px solid white;
        transition: transform 0.2s;
    }

    .camera-badge:hover {
        transform: scale(1.1);
    }

    /* 4. Upload Area */
    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        cursor: pointer;
        transition: all 0.3s;
        background: #f8fafc;
        margin-bottom: 20px;
        display: block;
    }

    .upload-area:hover,
    .upload-area.active {
        border-color: #4f46e5;
        background: #eef2ff;
    }

    .upload-area i {
        font-size: 28px;
        color: #4f46e5;
        margin-bottom: 10px;
    }

    .upload-text {
        font-weight: 600;
        color: #334155;
        font-size: 14px;
    }

    .upload-hint {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 4px;
    }

    .file-name {
        margin-top: 10px;
        font-size: 12px;
        color: #4f46e5;
        background: #eef2ff;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
    }

    /* 5. Buttons */
    .btn-group {
        display: flex;
        gap: 10px;
    }

    .btn {
        flex: 1;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: 0.2s;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
    }

    .btn-primary:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    input[type="file"] {
        display: none;
    }

    /* 6. Loading Animation */
    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        align-items: center;
        justify-content: center;
        border-radius: 24px;
        z-index: 10;
    }

    .loading-overlay.show {
        display: flex;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e2e8f0;
        border-top-color: #4f46e5;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<!-- Font Awesome (Jika belum diload di index utama) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script>
    // Script untuk preview gambar dan drag-drop
    const input = document.getElementById("fotoInput");
    const preview = document.getElementById("previewImg");
    const uploadArea = document.getElementById("uploadArea");
    const uploadText = document.getElementById("uploadText");
    const uploadHint = document.getElementById("uploadHint");
    const fileNameEl = document.getElementById("fileName");
    const btnSimpan = document.getElementById("btnSimpan");
    const loadingOverlay = document.getElementById("loadingOverlay");

    input.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            // Update UI
            btnSimpan.disabled = false;
            uploadArea.classList.add('active');
            uploadText.textContent = "Foto dipilih!";
            uploadHint.textContent = "Klik lagi jika ingin mengganti";

            fileNameEl.innerHTML = `<i class="fa fa-image"></i> ${file.name}`;
            fileNameEl.style.display = 'inline-block';

            // Preview
            preview.style.opacity = '0.5';
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.opacity = '1';
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag & Drop effects
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.add('active');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('active');
        });
    });

    uploadArea.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            input.files = files;
            input.dispatchEvent(new Event('change'));
        }
    });

    // Show loading on submit
    document.getElementById("uploadForm").addEventListener("submit", function () {
        if (!btnSimpan.disabled) {
            loadingOverlay.classList.add('show');
        }
    });
</script>
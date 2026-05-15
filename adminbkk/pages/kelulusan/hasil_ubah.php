<?php
// ============================================================================
// 📁 HASIL_UBAH.PHP - Form Edit Pengumuman (Modal Popup)
// ============================================================================
include_once("koneksi.php");

// Validasi akses & parameter
if (!isset($data_status) || $data_status != "perusahaan" || !isset($_GET['kode'])) {
    echo "<script>alert('❌ Akses ditolak!'); window.location='index.php?halaman=hasil_tampil_per';</script>";
    exit;
}

// ✅ PERBAIKAN 1: Ganti 'kode_hasil' → 'id_kelulusan'
$id_kelulusan = intval($_GET['kode']); // Sanitasi dengan intval

// ✅ PERBAIKAN 2: Query dengan JOIN untuk ambil judul_lowongan
$sql = "SELECT k.*, l.judul_lowongan, l.id_lowongan 
        FROM tb_kelulusan k 
        JOIN tb_lowongan l ON k.id_lowongan = l.id_lowongan 
        WHERE k.id_kelulusan = $id_kelulusan";

$query = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('❌ Data tidak ditemukan!'); window.location='index.php?halaman=hasil_tampil_per';</script>";
    exit;
}
?>

<!-- ============================================================================
     ✅ MODAL POPUP dengan Backdrop (Background Tetap Terlihat)
     ============================================================================ -->
<div class="modal-backdrop-custom" onclick="closeModal()">
    <div class="modal-content-custom" onclick="event.stopPropagation()">
        
        <!-- Header -->
        <div class="modal-header-custom">
            <h5><i class="fa fa-edit"></i> Ubah Pengumuman</h5>
            <button type="button" class="btn-close-custom" onclick="closeModal()">&times;</button>
        </div>

        <!-- Form -->
        <form action="index.php?halaman=hasil_aksi" method="POST" enctype="multipart/form-data">
            
            <div class="modal-body-custom">
                
                <!-- Hidden: ID Kelulusan -->
                <input type="hidden" name="txtkode_hasil" value="<?= $data['id_kelulusan']; ?>">

                <!-- ✅ Lowongan (READONLY - Tidak Bisa Diubah) -->
                <div class="form-group-custom">
                    <label>Lowongan Kerja</label>
                    <div class="readonly-field">
                        <i class="fa fa-briefcase"></i> 
                        <strong><?= htmlspecialchars($data['judul_lowongan']); ?></strong>
                    </div>
                    <small class="text-muted">Lowongan tidak dapat diubah setelah pengumuman dibuat.</small>
                </div>

                <!-- ✅ File Pengumuman (Bisa Diubah - Opsional) -->
                <div class="form-group-custom">
                    <label>File Pengumuman</label>
                    <?php if (!empty($data['berkas'])): ?>
                        <div class="current-file">
                            <i class="fa fa-file"></i> File saat ini: 
                            <a href="pages/kelulusan/terupload/<?= htmlspecialchars($data['berkas']); ?>" 
                               target="_blank" class="file-link">
                                <?= htmlspecialchars($data['berkas']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="berkas" class="form-input" accept=".pdf,.doc,.docx,.jpg,.png">
                    <small class="help-text">Kosongkan jika tidak ingin mengganti file</small>
                </div>

                <!-- ✅ Keterangan (Bisa Diubah) -->
                <div class="form-group-custom">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-input" rows="3" placeholder="Contoh: Lulus, Jam Kerja 08:00-17:00"><?= htmlspecialchars($data['keterangan']); ?></textarea>
                </div>

                <!-- ✅ Tanggal Pengumuman (Bisa Diubah) -->
                <div class="form-group-custom">
                    <label>Tanggal Pengumuman <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pengumuman" class="form-input" 
                           value="<?= !empty($data['tanggal_pengumuman']) ? $data['tanggal_pengumuman'] : date('Y-m-d'); ?>" required>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer-custom">
                <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" name="btnUBAH" class="btn-primary">
                    <i class="fa fa-save"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

<!-- ============================================================================
     ✅ CSS Custom untuk Modal Popup
     ============================================================================ -->
<style>
    /* Backdrop: Gelap transparan */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }
    
    /* Konten Modal */
    .modal-content-custom {
        background: #fff;
        border-radius: 12px;
        width: 90%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
    }
    
    /* Header */
    .modal-header-custom {
        padding: 16px 20px;
        background: linear-gradient(135deg, #6b7ff4 0%, #0e136a 100%);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 12px 0 0;
    }
    .modal-header-custom h5 { margin: 0; font-size: 18px; font-weight: 600; }
    
    /* Tombol Close */
    .btn-close-custom {
        background: none; border: none; color: white;
        font-size: 28px; cursor: pointer; opacity: 0.9;
    }
    .btn-close-custom:hover { opacity: 1; }
    
    /* Body */
    .modal-body-custom { padding: 20px; }
    
    /* Form Group */
    .form-group-custom { margin-bottom: 18px; }
    .form-group-custom label {
        display: block; margin-bottom: 6px;
        font-weight: 600; color: #333; font-size: 14px;
    }
    
    /* Readonly Field */
    .readonly-field {
        background: #f8f9fa; border: 2px solid #e9ecef;
        border-radius: 8px; padding: 10px 14px;
        color: #495057; font-size: 14px;
    }
    
    /* Current File Display */
    .current-file {
        background: #e3f2fd; border-left: 4px solid #2196f3;
        padding: 8px 12px; margin-bottom: 8px;
        border-radius: 4px; font-size: 13px;
    }
    .file-link { color: #1976d2; font-weight: 600; text-decoration: none; }
    .file-link:hover { text-decoration: underline; }
    
    /* Input & Textarea */
    .form-input {
        width: 100%; padding: 10px 14px;
        border: 2px solid #dee2e6; border-radius: 8px;
        font-size: 14px; box-sizing: border-box;
    }
    .form-input:focus { outline: none; border-color: #f59e0b; }
    textarea.form-input { resize: vertical; min-height: 80px; }
    
    /* Help Text */
    .help-text, .text-muted {
        display: block; margin-top: 4px;
        font-size: 12px; color: #6c757d;
    }
    
    /* Footer */
    .modal-footer-custom {
        padding: 16px 20px; border-top: 1px solid #e9ecef;
        display: flex; justify-content: flex-end; gap: 10px;
    }
    
    /* Buttons */
    .btn-secondary, .btn-primary {
        padding: 10px 20px; border: none; border-radius: 8px;
        font-weight: 600; font-size: 14px; cursor: pointer;
    }
    .btn-secondary { background: #6c757d; color: white; }
    .btn-primary {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        color: white;
    }
    .btn-secondary:hover, .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Animations */
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- ============================================================================
     ✅ JavaScript: Fungsi Close Modal
     ============================================================================ -->
<script>
function closeModal() {
    window.location = 'index.php?halaman=hasil_tampil';
}

// Tutup modal jika tekan ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
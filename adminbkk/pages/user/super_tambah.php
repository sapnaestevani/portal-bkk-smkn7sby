<?php
include_once("koneksi.php");
?>

<style>
    html,
    body {
        overflow-y: auto;
    }

    /* Modern Styling */
    .modern-form-container {
        background: linear-gradient(135deg, #e2e8f0 0%, #ffffff 100%);
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 1200px;
        width: 100%;
        margin-top: -30px;
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }

    .modern-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }

    .modern-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .modern-body {
        padding: 40px;
    }

    .form-group-modern {
        margin-bottom: 25px;
    }

    .form-group-modern label {
        display: block;
        margin-bottom: 8px;
        color: #2d3748;
        font-weight: 600;
        font-size: 14px;
    }

    .input-group-modern {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 16px;
        z-index: 10;
    }

    .form-control-modern {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        height: 48px;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-control-modern::placeholder {
        color: #a0aec0;
    }

    select.form-control-modern {
        cursor: pointer;
    }

    .required {
        color: #e53e3e;
        margin-left: 3px;
    }

    .button-group {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 30px;
    }

    .btn-modern {
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-secondary-modern {
        background: #e2e8f0;
        color: #4a5568;
    }

    .btn-secondary-modern:hover {
        background: #cbd5e0;
        transform: translateY(-2px);
        color: #2d3748;
    }

    .row-modern {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    @media (max-width: 768px) {
        .row-modern {
            grid-template-columns: 1fr;
        }

        .modern-body {
            padding: 30px 20px;
        }

        .modern-header h2 {
            font-size: 24px;
        }
    }

    /* ================= PERLEBAR TAMPILAN ================= */

    .modern-form-container {
        width: 100% !important;
        max-width: 100% !important;
        padding: 5px !important;
    }

    .modern-card {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 auto !important;
    }

    /* KHUSUS MOBILE */
    @media screen and (max-width:768px) {

        .content-wrapper,
        .wrapper,
        .container,
        .container-fluid,
        .content {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .modern-form-container {
            padding: 20px !important;
        }

        .modern-card {
            width: 100% !important;
            max-width: 100% !important;
            border-radius: 16px !important;
        }

    }

</style>

<div class="modern-form-container">
    <div class="modern-card">
        <div class="modern-header">
            <h2><i class="fa fa-user-plus"></i> Tambah User Pengelola</h2>
            <p>Kelola akun pengguna sistem</p>
        </div>

        <div class="modern-body">
            <form action="?halaman=super_aksi" method="post" enctype="multipart/form-data">
                <div class="row-modern">
                    <!-- Kolom Kiri -->
                    <div class="col-left">
                        <div class="form-group-modern">
                            <label>Username <span class="required">*</span></label>
                            <div class="input-group-modern">
                                <i class="fa fa-user input-icon"></i>
                                <input type="text" class="form-control-modern" name="txtusername"
                                    placeholder="Masukkan Username" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <div class="input-group-modern">
                                <i class="fa fa-id-card input-icon"></i>
                                <input type="text" class="form-control-modern" name="txtnama"
                                    placeholder="Masukkan Nama Lengkap" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label>Password <span class="required">*</span></label>
                            <div class="input-group-modern">
                                <i class="fa fa-lock input-icon"></i>
                                <input type="password" class="form-control-modern" name="txtpassword"
                                    placeholder="Masukkan Password" required>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-right">
                        <div class="form-group-modern">
                            <label>Email <span class="required">*</span></label>
                            <div class="input-group-modern">
                                <i class="fa fa-envelope input-icon"></i>
                                <input type="email" class="form-control-modern" name="txtemail"
                                    placeholder="contoh@email.com" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label>Alamat <span class="required">*</span></label>
                            <div class="input-group-modern">
                                <i class="fa fa-map-marker input-icon"></i>
                                <input type="text" class="form-control-modern" name="txtalamat"
                                    placeholder="Masukkan Alamat Lengkap" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label>Role Pengguna <span class="required">*</span></label>
                            <div class="input-group-modern">
                                <i class="fa fa-shield input-icon"></i>
                                <select name="rbstatus" class="form-control-modern" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin / Ka. BKK</option>
                                    <option value="perusahaan">Perusahaan / CV</option>
                                    <option value="siswa">Siswa / Alumni</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-modern btn-primary-modern" name="btnSIMPAN">
                        <i class="fa fa-save"></i> Simpan Data
                    </button>
                    <a href="?halaman=super_tampil" class="btn-modern btn-secondary-modern">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
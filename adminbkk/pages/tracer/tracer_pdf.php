<?php
// tracer_pdf.php - Cetak Laporan Tracer Study (Semua Data atau Per Tahun)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include koneksi
$paths = [
    __DIR__ . '/../../koneksi.php',
    __DIR__ . '/../koneksi.php',
    __DIR__ . '/koneksi.php'
];

$con = null;
foreach ($paths as $p) {
    if (file_exists($p)) {
        include_once($p);
        break;
    }
}

if (!$con) {
    die("<h3>❌ Koneksi database gagal!</h3>");
}

// Validasi parameter dengan default value
$tipe = isset($_GET['tipe']) ? mysqli_real_escape_string($con, $_GET['tipe']) : 'all';
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($con, $_GET['tahun']) : '';

// Tentukan tipe laporan (Bekerja, Belum Bekerja, atau Studi)
$is_bekerja = (strpos($tipe, 'bekerja') !== false);
$is_studi = (strpos($tipe, 'studi') !== false);

if ($is_bekerja) {
    $status_filter = 'Bekerja';
    $redirect_page = 'tracerb';
} elseif ($is_studi) {
    $status_filter = 'Studi';
    $redirect_page = 'tracers';
} else {
    $status_filter = 'Belum Bekerja';
    $redirect_page = 'tracerbk';
}

$base_tipe = str_replace(['_bekerja', '_studi'], '', $tipe); // all atau year

// Build query berdasarkan tipe
if ($base_tipe == 'year' && !empty($tahun)) {
    if ($is_bekerja) {
        // Query untuk Alumni BEKERJA per tahun
        $sql = "SELECT 
                    t.id_tracer,
                    s.nama, 
                    s.nisn, 
                    s.jurusan,
                    s.tahun_lulus,
                    t.status_setelah_lulus, 
                    t.nama_instansi,
                    t.posisi
                FROM tb_tracer t
                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                WHERE t.status_setelah_lulus = 'Bekerja'
                AND s.tahun_lulus = '$tahun'
                ORDER BY s.nama ASC";
        $judul = "Laporan Alumni Bekerja - Tahun $tahun";
        $periode = "Tahun Lulus: $tahun";
    } elseif ($is_studi) {
        // ✅ UBAH: Query untuk Alumni STUDI LANJUT per tahun (dengan status)
        $sql = "SELECT 
                    t.id_tracer,
                    s.nama, 
                    s.nisn, 
                    s.jurusan,
                    s.tahun_lulus,
                    t.status_setelah_lulus, 
                    t.nama_kampus AS nama_instansi
                FROM tb_tracer t
                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                WHERE t.status_setelah_lulus = 'Studi'
                AND s.tahun_lulus = '$tahun'
                ORDER BY s.nama ASC";
        $judul = "Laporan Alumni Studi Lanjut - Tahun $tahun";
        $periode = "Tahun Lulus: $tahun";
    } else {
        // Query untuk Alumni BELUM BEKERJA per tahun
        $sql = "SELECT 
                    s.nama, 
                    s.nisn, 
                    s.jurusan, 
                    s.tahun_lulus,
                    t.status_setelah_lulus, 
                    t.aktivitas
                FROM tb_tracer t
                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                WHERE t.status_setelah_lulus = 'Belum Bekerja'
                AND s.tahun_lulus = '$tahun'
                ORDER BY s.nama ASC";
        $judul = "Laporan Alumni Belum Bekerja - Tahun $tahun";
        $periode = "Tahun Lulus: $tahun";
    }
} else {
    if ($is_bekerja) {
        // Query untuk Alumni BEKERJA semua data
        $sql = "SELECT 
                    t.id_tracer,
                    s.nama, 
                    s.nisn, 
                    s.jurusan,
                    s.tahun_lulus,
                    t.status_setelah_lulus, 
                    t.nama_instansi,
                    t.posisi
                FROM tb_tracer t
                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                WHERE t.status_setelah_lulus = 'Bekerja'
                ORDER BY s.tahun_lulus DESC, s.nama ASC";
        $judul = "Laporan Alumni Bekerja - Semua Data";
        $periode = "Semua Tahun";
    } elseif ($is_studi) {
        // ✅ UBAH: Query untuk Alumni STUDI LANJUT semua data (dengan status)
        $sql = "SELECT 
                    t.id_tracer,
                    s.nama, 
                    s.nisn, 
                    s.jurusan,
                    s.tahun_lulus,
                    t.status_setelah_lulus, 
                    t.nama_kampus AS nama_instansi
                FROM tb_tracer t
                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                WHERE t.status_setelah_lulus = 'Studi'
                ORDER BY s.tahun_lulus DESC, s.nama ASC";
        $judul = "Laporan Alumni Studi Lanjut - Semua Data";
        $periode = "Semua Tahun";
    } else {
        // Query untuk Alumni BELUM BEKERJA semua data
        $sql = "SELECT 
                    s.nama, 
                    s.nisn, 
                    s.jurusan, 
                    s.tahun_lulus,
                    t.status_setelah_lulus, 
                    t.aktivitas
                FROM tb_tracer t
                INNER JOIN tb_siswa s ON t.id_siswa = s.id_siswa
                WHERE t.status_setelah_lulus = 'Belum Bekerja'
                ORDER BY s.tahun_lulus DESC, s.nama ASC";
        $judul = "Laporan Alumni Belum Bekerja - Semua Data";
        $periode = "Semua Tahun";
    }
}

$query = mysqli_query($con, $sql);

if (!$query) {
    die("<h3>❌ Query Error!</h3><p>" . mysqli_error($con) . "</p>");
}

$total_data = mysqli_num_rows($query);

// ✅ Pastikan variabel tidak null untuk htmlspecialchars
$judul_safe = htmlspecialchars($judul ?? "", ENT_QUOTES, "UTF-8");
$periode_safe = htmlspecialchars($periode ?? "", ENT_QUOTES, "UTF-8");
$status_safe = htmlspecialchars($status_filter ?? "", ENT_QUOTES, "UTF-8");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_safe; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }

        .control-panel {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .control-panel h3 {
            margin-bottom: 10px;
            color: #2d3748;
            font-size: 20px;
        }

        .control-panel p {
            color: #4a5568;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-print {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-pdf {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
        }

        .btn-pdf:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 87, 108, 0.5);
        }

        .btn-back {
            background: #718096;
            color: white;
            box-shadow: 0 4px 15px rgba(113, 128, 150, 0.3);
        }

        .btn-back:hover {
            background: #4a5568;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(113, 128, 150, 0.4);
        }

        .tips {
            margin-top: 12px;
            font-size: 12px;
            color: #718096;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .laporan-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .laporan-header {
            text-align: center;
            border-bottom: 3px double #2d3748;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .laporan-header h2 {
            font-size: 26px;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .laporan-header h3 {
            font-size: 16px;
            color: #4a5568;
            margin: 5px 0;
            font-weight: 600;
        }

        .laporan-header .info {
            font-size: 13px;
            color: #718096;
            margin: 3px 0;
        }

        .laporan-header .meta {
            font-size: 12px;
            color: #a0aec0;
            margin-top: 8px;
        }

        .info-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-left: 5px solid #2196f3;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-box i {
            font-size: 20px;
            color: #1976d2;
        }

        .info-box strong {
            color: #2d3748;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            background: #ffc107;
            color: #000;
        }

        .table-wrapper {
            margin-top: 25px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        thead tr {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #e2e8f0;
        }

        th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        tbody tr:hover {
            background: #e3f2fd;
        }

        .text-center {
            text-align: center;
        }

        .laporan-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: right;
            font-size: 11px;
            color: #718096;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a0aec0;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media print {
            .control-panel {
                display: none !important;
            }

            body {
                background: white;
                padding: 0;
            }

            .laporan-container {
                box-shadow: none;
                padding: 20px;
                margin: 0;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .laporan-container {
                padding: 20px;
            }

            table {
                font-size: 10px;
            }

            th,
            td {
                padding: 6px;
            }
        }
    </style>
</head>

<body>

    <div class="control-panel no-export">
        <h3><i class="fa fa-print"></i> Preview Laporan</h3>
        <p>Klik tombol di bawah untuk mencetak atau download laporan</p>
        <div class="button-group">
            <button onclick="cetakLaporan()" class="btn btn-print"><i class="fa fa-print"></i> Cetak Laporan</button>
            <button onclick="downloadPDF()" class="btn btn-pdf"><i class="fa fa-file-pdf"></i> Download PDF</button>
            <button onclick="kembali()" class="btn btn-back"><i class="fa fa-arrow-left"></i> Kembali</button>
        </div>
        <div class="tips"><i class="fa fa-info-circle"></i> <span>Untuk cetak: Pilih printer. Untuk PDF: File akan
                otomatis terdownload</span></div>
    </div>

    <div class="laporan-container" id="laporanContent">
        <div class="laporan-header">
            <h2><i class="fa fa-graduation-cap"></i> LAPORAN TRACER STUDY</h2>
            <h3><?= $judul_safe; ?></h3>
            <div class="info"><strong>BKK - SMKN 7</strong></div>
            <div class="meta">Dicetak: <?= date('d F Y, H:i:s'); ?> WIB</div>
        </div>

        <?php if ($total_data > 0): ?>
            <div class="info-box">
                <i class="fa fa-chart-bar"></i>
                <div>
                    <strong>Ringkasan:</strong>
                    Total: <strong><?= $total_data; ?> alumni</strong> |
                    Status: <span class="badge"><?= $status_safe; ?></span> |
                    Periode: <strong><?= $periode_safe; ?></strong>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <?php if ($is_bekerja): ?>
                            <!-- Kolom untuk Alumni BEKERJA -->
                            <tr>
                                <th width="5%">No</th>
                                <th>NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th width="10%">Tahun Lulus</th>
                                <th>Status</th>
                                <th>Instansi</th>
                                <th>Posisi</th>
                            </tr>
                        <?php elseif ($is_studi): ?>
                            <!-- ✅ UBAH: Kolom untuk Alumni STUDI LANJUT (dengan Status) -->
                            <tr>
                                <th width="5%">No</th>
                                <th>NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th width="10%">Tahun Lulus</th>
                                <th>Status</th>
                                <th>Kampus/Instansi</th>
                            </tr>
                        <?php else: ?>
                            <!-- Kolom untuk Alumni BELUM BEKERJA -->
                            <tr>
                                <th width="5%">No</th>
                                <th>NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th width="10%">Tahun Lulus</th>
                                <th>Status</th>
                                <th>Aktivitas</th>
                            </tr>
                        <?php endif; ?>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($d = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($d['nisn'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                <td><strong><?= htmlspecialchars($d['nama'] ?? "", ENT_QUOTES, "UTF-8"); ?></strong></td>
                                <td><?= htmlspecialchars($d['jurusan'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                <td class="text-center"><?= htmlspecialchars($d['tahun_lulus'] ?? "", ENT_QUOTES, "UTF-8"); ?>
                                </td>

                                <?php if ($is_bekerja): ?>
                                    <!-- Kolom untuk Alumni BEKERJA -->
                                    <td><?= htmlspecialchars($d['status_setelah_lulus'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                    <td><?= htmlspecialchars($d['nama_instansi'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                    <td><?= htmlspecialchars($d['posisi'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                <?php elseif ($is_studi): ?>
                                    <!-- ✅ UBAH: Kolom untuk Alumni STUDI LANJUT (dengan Status) -->
                                    <td><?= htmlspecialchars($d['status_setelah_lulus'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                    <td><?= htmlspecialchars($d['nama_instansi'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                <?php else: ?>
                                    <!-- Kolom untuk Alumni BELUM BEKERJA -->
                                    <td><?= htmlspecialchars($d['status_setelah_lulus'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                    <td><?= htmlspecialchars($d['aktivitas'] ?? "", ENT_QUOTES, "UTF-8"); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa fa-inbox"></i>
                <h3>Tidak Ada Data</h3>
                <p>Tidak ada alumni dengan kriteria yang dipilih.</p>
            </div>
        <?php endif; ?>

        <div class="laporan-footer">
            <p><strong>Dokumen otomatis - Sistem BKK SMKN 7</strong></p>
            <p>Tanggal: <?= date('d-m-Y'); ?></p>
        </div>
    </div>

    <script>
        function cetakLaporan() { window.print(); }

        function downloadPDF() {
            const element = document.getElementById('laporanContent');
            const timestamp = new Date().getTime();
            const tahunParam = '<?= htmlspecialchars($tahun ?? "", ENT_QUOTES, "UTF-8"); ?>';
            const tipeParam = '<?= htmlspecialchars($tipe ?? "", ENT_QUOTES, "UTF-8"); ?>';

            // Generate filename yang berbeda
            let filename = 'laporan_tracer_';
            if (tipeParam.includes('bekerja')) {
                filename += 'bekerja_';
            } else if (tipeParam.includes('studi')) {
                filename += 'studi_';
            } else {
                filename += 'belum_bekerja_';
            }

            if (tipeParam.includes('year') && tahunParam !== '') {
                filename += 'tahun_' + tahunParam + '_';
            }

            filename += timestamp + '.pdf';

            const opt = {
                margin: [10, 10, 10, 10],
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';
            btn.disabled = true;

            html2pdf().set(opt).from(element).save().then(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(err => {
                console.error('Error generating PDF:', err);
                alert('Terjadi kesalahan saat membuat PDF. Silakan coba lagi.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        function kembali() {
            const tipeParam = '<?= htmlspecialchars($tipe ?? "", ENT_QUOTES, "UTF-8"); ?>';
            if (tipeParam.includes('bekerja')) {
                window.location.href = 'http://localhost/bkk/SistemBKK_smkn7/adminbkk/index.php?halaman=tracerb';
            } else if (tipeParam.includes('studi')) {
                window.location.href = 'http://localhost/bkk/SistemBKK_smkn7/adminbkk/index.php?halaman=tracers';
            } else {
                window.location.href = 'http://localhost/bkk/SistemBKK_smkn7/adminbkk/index.php?halaman=tracerbk';
            }
        }

        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey && e.key === 'p') { e.preventDefault(); cetakLaporan(); }
            if (e.ctrlKey && e.key === 's') { e.preventDefault(); document.querySelector('.btn-pdf').click(); }
            if (e.key === 'Escape') { kembali(); }
        });
    </script>

</body>

</html>
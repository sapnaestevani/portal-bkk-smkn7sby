<?php
// 1. Koneksi Database
include_once("koneksi.php");

// Cek apakah parameter 'kode' (id_lowongan) ada
if (isset($_GET['kode'])) {
    
    $id_lowongan = mysqli_real_escape_string($con, $_GET['kode']);

    // ✅ PERBAIKAN: Gunakan nama tabel dan kolom yang BENAR sesuai database
    // Tabel: tb_lowongan | Kolom: id_lowongan, status
    $sql_arsip = "UPDATE tb_lowongan SET status = 'aktif' WHERE id_lowongan = '$id_lowongan'";
    
    $query_arsip = mysqli_query($con, $sql_arsip);

    if ($query_arsip) {
        // Opsional: Kirim Notifikasi Email setelah konfirmasi berhasil
        
        // Ambil data lowongan yang baru saja diaktifkan untuk isi email
        $sql_data = "SELECT l.judul_lowongan, l.batas_lamaran, p.nama_perusahaan, p.email as email_perusahaan 
                     FROM tb_lowongan l 
                     JOIN tb_perusahaan p ON l.id_perusahaan = p.id_perusahaan 
                     WHERE l.id_lowongan = '$id_lowongan' LIMIT 1";
        
        $result_data = mysqli_query($con, $sql_data);
        $data_loker = mysqli_fetch_assoc($result_data);

        if ($data_loker && !empty($data_loker['email_perusahaan'])) {
            // Konfigurasi Email (Menggunakan PHPMailer Modern atau mail() sederhana jika server mendukung)
            // Catatan: Untuk produksi, disarankan menggunakan PHPMailer via Composer atau library modern.
            // Di sini kita gunakan logika dasar. Jika Anda memiliki file class.phpmailer.php, pastikan path-nya benar.
            
            $tujuan = $data_loker['email_perusahaan'];
            $subjek = "Konfirmasi Lowongan Kerja - " . $data_loker['nama_perusahaan'];
            $pesan = "Yth. Admin Perusahaan,<br><br>";
            $pesan .= "Lowongan kerja dengan judul <b>" . htmlspecialchars($data_loker['judul_lowongan']) . "</b> ";
            $pesan .= "telah dikonfirmasi dan ditayangkan di Portal BKK SMK Negeri 7 Surabaya.<br>";
            $pesan .= "Batas Lamaran: " . date('d-m-Y', strtotime($data_loker['batas_lamaran'])) . "<br><br>";
            $pesan .= "Terima Kasih,<br>BKK SMKN 7 Surabaya";

            // --- OPSI PENGIRIMAN EMAIL ---
            // Jika Anda ingin menggunakan PHPMailer seperti kode asli, pastikan library terload dengan benar.
            // Kode di bawah ini adalah contoh struktur jika library tersedia.
            
            /* 
            require_once "phpmailer/src/PHPMailer.php"; // Sesuaikan path library modern
            require_once "phpmailer/src/SMTP.php";
            require_once "phpmailer/src/Exception.php";

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aksaramedia6@gmail.com';
                $mail->Password = 'Febrian_1999'; // Gunakan App Password jika pakai Gmail
                $mail->SMTPSecure = 'tls'; // Atau ssl port 465
                $mail->Port = 587; // Atau 465

                $mail->setFrom('aksaramedia6@gmail.com', 'BKK SMKN 7 Surabaya');
                $mail->addAddress($tujuan);
                $mail->isHTML(true);
                $mail->Subject = $subjek;
                $mail->Body    = $pesan;

                if(!$mail->send()) {
                    // Biarkan proses tetap berjalan meskipun email gagal, atau tampilkan error
                    // echo 'Email gagal dikirim: ' . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            */
           
           // Jika tidak pakai PHPMailer, bisa pakai mail() bawaan PHP (harus konfigurasi sendmail di php.ini)
           // mail($tujuan, $subjek, $pesan, "Content-Type: text/html; charset=UTF-8");
        }

        echo "<script>alert('✅ Konfirmasi Lowongan Berhasil! Status diubah menjadi Aktif.'); window.location.href='?halaman=loker_tampil';</script>";
    } else {
        echo "<script>alert('❌ Gagal Mengkonfirmasi Lowongan: " . mysqli_error($con) . "'); window.location.href='?halaman=loker_tampil';</script>";
    }
    exit;
} else {
    // Jika tidak ada kode, redirect kembali
    echo "<script>window.location.href='?halaman=loker_tampil';</script>";
    exit;
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'estevaniasapna@gmail.com'; // GANTI
    $mail->Password   = 'hcskdykdychaatep'; // GANTI (tanpa spasi)
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('estevaniasapna@gmail.com', 'Portal BKK');
    $mail->addAddress('estevania1406@gmail.com'); // email tujuan tes

    $mail->isHTML(true);
    $mail->Subject = 'Test Email BKK';
    $mail->Body    = 'Email berhasil dikirim dari sistem BKK 🎉';

    $mail->send();
    echo "✅ Email berhasil dikirim!";
} catch (Exception $e) {
    echo "❌ Gagal kirim: {$mail->ErrorInfo}";
}
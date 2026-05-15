<?php
include_once("../../../koneksi.php");
$email = mysqli_query($con,"SELECT email FROM tb_coba") or die (mysqli_error());
$row = mysqli_fetch_row($email);
$mail = $row[0]; 
echo $mail;
$tujuan = $mail ; 
include "classes/class.phpmailer.php";

$mail = new PHPMailer; 
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "smtp.gmail.com"; //host email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "aksaramedia6@gmail.com"; //user email server
$mail->Password = "Febrian_1999"; //password email server
$mail->SetFrom("aksaramedia6@gmail.com","BKK SMK Ma'arif "); //set email pengirim / server
$mail->Subject = "Layanan Notifikasi"; //subyek email
$mail->AddAddress($tujuan);  // email tujuan
$isi=mysqli_query($con,"SELECT nm_perusahaan, nm_loker, batas FROM tb_loker ORDER BY id_loker DESC LIMIT 1 ") or die (mysqli_error());
$row1 = mysqli_fetch_row($isi);
$isimail = $row1[0]; 
$isimail1 = $row1[1]; 
$isimail2= $row1[2];
$mail->MsgHTML("Selamat, Lowongan kerja masuk $isimail dengan lowongan $isimail1, batas pendaftaran $isimail2");


if(!$mail->Send()) {
    echo "Eror: ".$mail->ErrorInfo;
    exit;
}else {
    echo "<div class='alert alert-success'><strong>Berhasil.</strong> Email telah dikirim.</div>";
}

?>

<!-- Elseif Channel -->
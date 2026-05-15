<?php
$konek = mysqli_connect("localhost","root","","coba_bkk");
$email = mysqli_query($konek,"SELECT email FROM tb_coba") or die (mysqli_error());
$row = mysqli_fetch_row($email);
$mail = $row[0]; 
echo $mail;
?>
<?php
        include_once("../../../koneksi.php");
        $email =  mysqli_query($con,"SELECT email FROM tb_peserta");
        while ($mail = mysqli_fetch_array($email)) {
            echo $mail['email']. " <br/>";
        }
    ?>


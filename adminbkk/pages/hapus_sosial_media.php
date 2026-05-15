<?php
// ======================
// CEK LOGIN
// ======================
if (!isset($_SESSION['ses_username'])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

// ======================
// AMBIL ID
// ======================
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {

    $username = $_SESSION['ses_username'];

    // ======================
    // AMBIL ID USER
    // ======================
    $getUser = mysqli_query($con, "SELECT id_user FROM tb_user WHERE username='$username'");
    $user = mysqli_fetch_assoc($getUser);

    if ($user) {

        $id_user = $user['id_user'];

        // ======================
        // HAPUS DATA
        // ======================
        mysqli_query($con, "
            DELETE FROM tb_sosial_media 
            WHERE id_sosial_media='$id' 
            AND id_user='$id_user'
        ");
    }
}

// ======================
// REDIRECT AMAN
// ======================
echo "<script>
window.location='?halaman=profile_perusahaan&tab=sosial#sosial';
</script>";
exit;
?>